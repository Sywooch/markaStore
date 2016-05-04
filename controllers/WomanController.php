<?php

	namespace app\controllers;

	use app\module\admin\models\Brands;
	use app\module\admin\models\Genus;
	use Yii;
	use app\models\Woman;
	use app\models\WomanSearch;
	use yii\helpers\Url;
	use yii\web\Controller;
	use yii\web\NotFoundHttpException;
	use yii\filters\VerbFilter;
	use app\module\admin\models\Images;
	use app\module\admin\models\Sizesofproduct;
	use yii\data\Pagination;
	use app\module\admin\models\Product;
	use app\models\Cart;

	/**
	 * WomanController implements the CRUD actions for Woman model.
	 */
	class WomanController extends Controller
	{
		public function behaviors()
		{
			return [
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['post'],
					],
				],
			];
		}

		/**
		 * Lists all Woman models.
		 * @return mixed
		 */

		public function actionIndex($filter_brand = [], $filter_cost = [])
		{
			$searchModel = new WomanSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

			$getController = Genus::find()->where(['genus' => $_GET['genus']])->one();

			$getItemsByGenus = Product::find()->select('type_id')->
				where(['genus_id' => $getController->id])->
				orderBy('type_id')->distinct('type_id')->all();

			$getBrandsByItems = Product::find()->select('brand_id')->where(['public' => 1])->andWhere(['genus_id' => $getController->id]);

			$query = Woman::find();

			/// Brand Filters
			if (isset($_GET['brand'])){
				if (isset($_GET['type']) AND $_GET['type'] != NULL)
					$query = $query->andWhere(['brand_id' => $_GET['brand'], 'type_id' => $_GET['type']]);
				else
					$query = $query->andWhere(['brand_id' => $_GET['brand']]);
			}else{
				if (isset($_GET['type']) AND $_GET['type'] != NULL)
					$query = $query->andWhere(['type_id' => $_GET['type']]);
			}

			$maxcost = $query->andWhere(['genus_id' => $getController->id])->max('cost');
			$mincost = $query->andWhere(['genus_id' => $getController->id])->min('cost');

			/// Cost Filters
			if (isset($_GET['cost']))
				$query = $query->andWhere(['>', 'cost', $_GET['cost']['min']-1])->andWhere(['<', 'cost', $_GET['cost']['max']+1]);

			$pagination = new Pagination([
				'defaultPageSize' => 12,
				'totalCount' => $query->count(),
			]);

			$products = $query->andWhere(['genus_id' => $getController->id])->orderBy('product_id')
				->offset($pagination->offset)
				->limit($pagination->limit)
				->all();

			if(isset($_GET['type']) AND $_GET['type'] != NULL)
				$getBrandsByItems = $getBrandsByItems->andWhere(['type_id' => $_GET['type']]);

			$getBrandsByItems = $getBrandsByItems->orderBy('brand_id')->distinct('brand_id')->all();


			/*if (isset($_GET['sort']['lesstomore'])){
				$query = $query->orderBy(['cost' => SORT_DESC]);
			}*/

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'products' => $products,
				//'brandsll' => isset($_SESSION['filter']) ? count($_SESSION['filter']['type'][$_GET['type']]['brand'])  : '',
				'filter_brand' => isset($_GET['brand']) ? $_GET['brand'] : '',
				'filter_cost' => isset($_GET['cost']) ? $_GET['cost'] : '',
				'filter_sort' => isset($_GET['sort']) ? $_GET['sort'] : '',
				'genus' => $getController,
				'itemList' => $getItemsByGenus,
				'brandList' => $getBrandsByItems,
				'maxcost' => $maxcost,
				'mincost' => $mincost,
				//'nme' => $nme,
				'pagination' => $pagination,
				// 'brand' => $brand,
			]);
		}


		public function actionBrand($brand)
		{

			$searchModel = new WomanSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);


			//$query = Product::find();
			$query = Woman::find();
			$pagination = new Pagination([
				'defaultPageSize' => 12,
				'totalCount' => $query->count(),
			]);
			/*$products = $query->orderBy('product_id')
				->offset($pagination->offset)
				->limit($pagination->limit)
				->all();*/
//			$products = Woman::findAll(
//				array(
//					'brand_id' => $brand,
//				)
//			);

			$products = Woman::find()->where(['public' => 1])->andWhere(['brand_id' => $brand])->all();

			//  $nme = Names::find()->orderBy('name', 'id')->one();

			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'products' => $products,
				//'nme' => $nme,
				'pagination' => $pagination,
				//'brand' => $brand,
			]);

		}

		/**
		 * Displays a single Woman model.
		 * @param integer $id
		 * @return mixed
		 */
		public function actionView($id, $color)
		{

			$sizes = Sizesofproduct::find()->with('size_id.size')->where(['product_id' => $id]);

			if (isset($color)){
				return $this->render('view', [
					'model' => $this->findModel($id),
					'sizes' => $sizes,
					'color' => $color,
				]);
			}else{
				foreach (Images::find()->with('color_id')->where(['product_id' => $id])->limit(1) as $col) {
					$color = $col;
				}
				return $this->render('view', [
					'model' => $this->findModel($id),
					'sizes' => $sizes,
					'color' => $color,
				]);
			}
		}

		public function actionCart()
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
				unset($_SESSION['uid']);
				unset($_SESSION['product_id']);
				unset($_SESSION['color_id']);
				unset($_SESSION['size_id']);
				unset($_SESSION['count']);
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
			return $this->redirect(Url::previous()/* . '&cart=1'*/);
		}
		/**
		 * Creates a new Woman model.
		 * If creation is successful, the browser will be redirected to the 'view' page.
		 * @return mixed
		 */
		public function actionCreate()
		{
			$model = new Woman();

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->product_id]);
			} else {
				return $this->render('create', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Updates an existing Woman model.
		 * If update is successful, the browser will be redirected to the 'view' page.
		 * @param integer $id
		 * @return mixed
		 */
		public function actionUpdate($id)
		{
			$model = $this->findModel($id);

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->product_id]);
			} else {
				return $this->render('update', [
					'model' => $model,
				]);
			}
		}

		/**
		 * Deletes an existing Woman model.
		 * If deletion is successful, the browser will be redirected to the 'index' page.
		 * @param integer $id
		 * @return mixed
		 */
		public function actionDelete($id)
		{
			$this->findModel($id)->delete();

			return $this->redirect(['index']);
		}

		/**
		 * Finds the Woman model based on its primary key value.
		 * If the model is not found, a 404 HTTP exception will be thrown.
		 * @param integer $id
		 * @return Woman the loaded model
		 * @throws NotFoundHttpException if the model cannot be found
		 */
		protected function findModel($id)
		{
			if (($model = Woman::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}


	}

