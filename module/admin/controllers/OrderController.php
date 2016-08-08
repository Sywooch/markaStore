<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Purchases;
use app\module\admin\models\Sizesofproduct;
use Yii;
use app\module\admin\models\Product;
use app\module\admin\models\Order;
use app\module\admin\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
            'pagination' => [
                'pageSize' => 20,
                //'pageParam' => 'page',
                'validatePage' => false,
            ],

            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_DESC,
                    'date' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'error' => isset($_GET['error']) ? $_GET['error'] : NULL,
            'info' => isset($_GET['info']) ? $_GET['info'] : NULL,
            'success' => isset($_GET['success']) ? $_GET['success'] : NULL,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
       // $model->phone = '+380' . $model->phone;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            session_start();
            $_SESSION['status'] = 1;
            session_write_close();
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionSold($id)
    {
        $order = $this->findModel($id);
        $sizes = Sizesofproduct::find();

        if($order->status == 1) {
            foreach (Purchases::find()->where(['order_id' => $id])->all() as $purchases) {
                $countNow = $sizes->select('availability')->
                where(['product_id' => $purchases->product_id, 'color_id' => $purchases->color_id, 'size_id' => $purchases->size_id])->one();


                if ($countNow->availability < $purchases->count) {
                    $error[] = '<strong>Товара: </strong>' .
                        Product::find()->where(['product_id' => $purchases->product_id])->one()->name->name . ' ' .
                        Product::find()->where(['product_id' => $purchases->product_id])->one()->brand->brand . ' ' .
                        $purchases->colors->color_name . ' ' .
                        $purchases->size->size . ' Осталось <strong>' . $countNow->availability .
                        ' единиц</strong>. Этого количества недостаточно для проведения заказа в количестве <strong>' .
                        $purchases->count . ' единиц</strong>.';
                }

            }

            if (isset($error)) {
                return $this->redirect(['index', 'error' => $error]);
            } else {
                $tovarCount = 0;
                foreach (Purchases::find()->where(['order_id' => $id])->all() as $purchases) {
                    $countNow = $sizes->select('availability')->
                    where(['product_id' => $purchases->product_id, 'color_id' => $purchases->color_id, 'size_id' => $purchases->size_id])->one();

                    $tovarCount = $tovarCount+$purchases->count;
                    $count = $countNow->availability - $purchases->count;
                    Sizesofproduct::findOne(['product_id' => $purchases->product_id, 'color_id' => $purchases->color_id, 'size_id' => $purchases->size_id])->
                    updateAttributes(['availability' => $count]);

                    if($countNow->availability < 4){
                        $countNow = $sizes->select('availability')->
                        where(['product_id' => $purchases->product_id, 'color_id' => $purchases->color_id, 'size_id' => $purchases->size_id])->one();

                        $info[] = '<strong>Товар: </strong>' .
                            Product::find()->where(['product_id' => $purchases->product_id])->one()->name->name . ' ' .
                            Product::find()->where(['product_id' => $purchases->product_id])->one()->brand->brand . ' ' .
                            $purchases->colors->color_name . ' ' .
                            $purchases->size->size . ($countNow->availability == 0 ? ' Закончился' : ' Заканчивается. Осталось <strong>' . $countNow->availability .
                            ' единиц</strong>');
                    }
                }
                $order->updateAttributes(['status' => 0]);
                return $this->redirect(['index', 'info' => isset($info) ? $info : '',
                    'success' => $success[] = ['1' => 'Заказ №' . $order->id .
                        ' Продано клиенту <strong>' . $order->fio . '</strong>, <strong>' . $tovarCount . ' единиц</strong>.']]);
            }
        }else{
            return $this->redirect(['index', 'error' =>  $error[] = ['1' => 'Заказ №' . $order->id . ' уже проведен']]);
        }
    }


    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Purchases::deleteAll('order_id = :order_id', [':order_id' => $id]);
        return $this->redirect(['index']);
    }



    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
