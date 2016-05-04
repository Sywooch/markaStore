<?php
	/**
	 * Created by PhpStorm.
	 * User: art
	 * Date: 1/4/2016
	 * Time: 03:32 PM
	 */
	namespace app\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\helpers\Url;
	use app\module\admin\models\Order;
	use yii\helpers\ArrayHelper;
	use app\models\Woman;
	use app\module\admin\models\Purchases;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use yii\data\ActiveDataProvider;

	/**
	 * BrandsController implements the CRUD actions for Brands model.
	 */
	class CartController extends Controller
	{
		public function actionView()
		{
			if(isset($_SESSION['count']) and array_sum($_SESSION['count']) > 0 ){
				foreach($_SESSION['uid'] as $item){
					if ($_SESSION['count'][$item] == 0){
						$cart = false;
					}
					else{
						$cart = true;
					}
				}
			}else{
				$cart = false;
			}

			$model = new Order();

			/*	return $this->render('view', [
					'model' => $model,
				]);
*/

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				//session_start();
				foreach($_SESSION['uid'] as $item) {
							$getCost = ArrayHelper::getValue(Woman::find()->
							select('sale')->
							where(['product_id' => $_SESSION['product_id'][$item]])->
							one(), 'sale');
							if ($getCost == 0) {
								$sum[] = ArrayHelper::getValue(Woman::find()->
									select('cost')->
									where(['product_id' => $_SESSION['product_id'][$item]])->
									one(), 'cost') * $_SESSION['count'][$item];
							} else {
								$sum[] = $getCost * $_SESSION['count'][$item];
							}
						Yii::$app->getDb()->
						createCommand()->
						update('order',['final_cost' => array_sum($sum)],"id = $model->id")->
						execute();

				Yii::$app->getDb()->createCommand()->insert('purchases', [
					'order_id' => $model->id,
					'product_id' => $_SESSION['product_id'][$item],
					'size_id' => $_SESSION['size_id'][$item],
					'color_id' => $_SESSION['color_id'][$item],
					'count' => $_SESSION['count'][$item]
				])->execute();
				}
				return $this->redirect(['view', 'order_number' => $model->id]);
			} else {
				return $this->render('view', [
					'model' => $model,
				]);
			}

			//return $this->render('view', [
			//	'model' => $this->findModel($id),
			//]);

		}

		public function actionAdd()
		{
			session_start();
			if (Yii::$app->request->get('id')){

				/*if (empty($_SESSION['count'])){
					$_SESSION['count'] = 1;
					return $this->redirect(['index']);
				}else {*/

				//$_SESSION['count'] = (!isset($_SESSION['count']) ? 1 : $_SESSION['count'] + 1);
				$checkid = (isset($_SESSION['product_id']) ? array_search($_GET['id'], $_SESSION['product_id']) : 0 );
				$checkcolor = (isset($_SESSION['color_id']) ? array_search($_GET['color'], $_SESSION['color_id']) : 0 );
				$checksize = (isset($_SESSION['size_id']) ? array_search($_GET['size'], $_SESSION['size_id']) : 0 );
				if ($checkid > 0 ){
					if ($_SESSION['color_id'][$checkid] == $_GET['color'] and $_SESSION['size_id'][$checkid] == $_GET['size']){
						$_SESSION['count'][$checkid] = $_SESSION['count'][$checkid] + 1;
					}elseif ($checkcolor > 0) {
						if ($_SESSION['color_id'][$checkcolor] == $_GET['color'] and $_SESSION['size_id'][$checkcolor] == $_GET['size']){
							$_SESSION['count'][$checkcolor] = $_SESSION['count'][$checkcolor] + 1;
						}elseif($checksize > 0){
							if($_SESSION['color_id'][$checksize] == $_GET['color'] and $_SESSION['size_id'][$checksize] == $_GET['size']){
								$_SESSION['count'][$checksize] = $_SESSION['count'][$checksize] + 1;
							}else{
								$uid = uniqid();
								$_SESSION['uid'][] = $uid;
								$_SESSION['product_id'][$uid] = $_GET['id'];
								$_SESSION['color_id'][$uid] = $_GET['color'];
								$_SESSION['size_id'][$uid] = $_GET['size'];
								$_SESSION['count'][$uid] = 1;
							}

						}else {
							$uid = uniqid();
							$_SESSION['uid'][] = $uid;
							$_SESSION['product_id'][$uid] = $_GET['id'];
							$_SESSION['color_id'][$uid] = $_GET['color'];
							$_SESSION['size_id'][$uid] = $_GET['size'];
							$_SESSION['count'][$uid] = 1;
						}
					}else {
						$uid = uniqid();
						$_SESSION['uid'][] = $uid;
						$_SESSION['product_id'][$uid] = $_GET['id'];
						$_SESSION['color_id'][$uid] = $_GET['color'];
						$_SESSION['size_id'][$uid] = $_GET['size'];
						$_SESSION['count'][$uid] = 1;
					}
				}else{

					$uid = uniqid();
					$_SESSION['uid'][] = $uid;
					$_SESSION['product_id'][$uid] = $_GET['id'];
					$_SESSION['color_id'][$uid] = $_GET['color'];
					$_SESSION['size_id'][$uid] = $_GET['size'];
					$_SESSION['count'][$uid] = 1;
					/*	$_SESSION['color_id'] = (!isset($_SESSION['color_id']) ? [$_GET['color']] : array_push($_SESSION['color_id'], $_GET['color']));
						$_SESSION['size_id'] = (!isset($_SESSION['size_id']) ? [$_GET['size']] : array_push($_SESSION['size_id'], $_GET['size']));*/
				}
				//return $this->redirect(['view', 'id' => $_GET['id'], 'color' => $_GET['color'], 'size' => $_GET['size']/*, 'cart' => 1*/]);
				return $this->redirect(Url::toRoute('/cart/view'));

			}

		}

		public function actionDelcartitem()
		{
			session_start();
			if (isset($_GET['delall']) and $_GET['delall'] == '1') {
				$_SESSION = NULL;
				$_SESSION = [];
			}else {

				if (Yii::$app->request->get('uid')) {
					$uid = $_GET['uid'];
					$_SESSION['count'][$uid] = 0;
					unset($_SESSION['uid'][$uid]);
					unset($_SESSION['product_id'][$uid]);
					unset($_SESSION['color_id'][$uid]);
					unset($_SESSION['size_id'][$uid]);

				}
			}
			return $this->redirect(Url::toRoute('/cart/view'));
		}
	}