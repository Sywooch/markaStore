<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Genus;
use app\module\admin\models\Sizesofproduct;
use Yii;
use app\module\admin\models\Product;
use app\module\admin\models\ProductSearch;
use app\module\admin\models\Materialproduct;
use app\module\admin\models\Images;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex($id = false, $size = false, $color = false)
    {
        $searchModel = new ProductSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     if ($id || $size || $color){
         $dataProvider = new ActiveDataProvider([
             'query' => Product::find()->where(['product_id' => $id]),
             'pagination' => [
                 'pageSize' => 20,
                 //'pageParam' => 'page',
                 'validatePage' => false,
             ],
             'sort' => [
                 'defaultOrder' => [
                     'product_id' => SORT_DESC,
                 ],
             ],
         ]);
     }else {
         $dataProvider = new ActiveDataProvider([
             'query' => Product::find(),
             'pagination' => [
                 'pageSize' => 20,
                 //'pageParam' => 'page',
                 'validatePage' => false,
             ],
             'sort' => [
                 'defaultOrder' => [
                     'product_id' => SORT_DESC,
                 ],
             ],
         ]);
     }

       // $sizeses = Sizesofproduct::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
           // 'sizeses' =>  $sizeses,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $color = false)
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

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Sizesofproduct::deleteAll('product_id = :product_id', [':product_id' => $id]);
        Materialproduct::deleteAll('product_id = :product_id', [':product_id' => $id]);
        foreach (Images::find()->where(['product_id' => $id])->all() as $images){
            unlink('images/' . substr($images->img_file, strrpos($images->img_file, '/')));
        }
        Images::deleteAll('product_id = :product_id', [':product_id' => $id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPublish($id)
    {
        $publication = Product::find()->where(['product_id' => $id])->one();
        if (Sizesofproduct::find()->where(['product_id' => $publication->product_id])->count() > 0) {
            $publication->public = 1;
            $publication->save();
            return $this->redirect(['index']);
        }
        else{
            return $this->redirect(['index']);
        }
    }

    public function actionUnpublish($id)
    {
        $publication = Product::find()->where(['product_id' => $id])->one();
        $publication->public = 0;
        $publication->save();
        return $this->redirect(['index']);
    }

    public function actionFindbyart($genus = false, $color = false, $size = false, $id = false)
    {

        $genus = Genus::find()->where(['genus' => $_GET['genus']])->one();
        $color = $_GET['color'];
        $size = $_GET['size'];
        $id = $_GET['id'];

        $searchModel = new ProductSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['id' => $id, 'genus_id' => $genus->id, 'color_id' => $color, 'size_id' => $size]),
        ]);


        // $sizeses = Sizesofproduct::find()->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'sizeses' =>  $sizeses,
        ]);


    }
}
