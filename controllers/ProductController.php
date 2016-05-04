<?php

namespace app\controllers;

use app\module\admin\models\Images;
use app\module\admin\models\Names;
use app\module\admin\models\Sizesofproduct;
use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use app\module\admin\models\Genus;
use yii\data\ActiveDataProvider;

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
    public function actionIndex($filter_brand = [], $filter_cost = [])
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getController = Genus::find()->where(['genus' => $_GET['genus']])->one();

        $getItemsByGenus = Product::find()->select('type_id')->
        where(['genus_id' => $getController->id])->
        orderBy('type_id')->distinct('type_id')->all();

        $getBrandsByItems = Product::find()->select('brand_id')->where(['public' => 1])->andWhere(['genus_id' => $getController->id]);

        $query = Product::find();

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
           // $query = $query->andWhere(['>', 'cost', $_GET['cost']['min']-1])->andWhere(['<', 'cost', $_GET['cost']['max']+1])->andWhere(['sale' => 0]);
            $query = $query->andFilterWhere([
                'or',
                [
                    '>',
                    'cost',
                    $_GET['cost']['min']-1,
                ],
                [
                    'and',
                    'sale!=0',
                    [
                        '>',
                        'sale',
                        $_GET['cost']['min']-1
                    ],
                ]
            ])->andFilterWhere([
                'or',
                [
                    '<',
                    'cost',
                    $_GET['cost']['max']+1,
                ],
                ['and',
                    'sale!=0',
                    [
                        '<',
                        'sale',
                        $_GET['cost']['max']+1,
                    ]
                ]
            ]);


        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);

        $products = $query->andWhere(['genus_id' => $getController->id, 'public' => 1])->orderBy(['product_id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if(isset($_GET['type']) AND $_GET['type'] != NULL)
            $getBrandsByItems = $getBrandsByItems->andWhere(['type_id' => $_GET['type']]);

        $getBrandsByItems = $getBrandsByItems->orderBy('brand_id')->distinct('brand_id')->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'filter_brand' => isset($_GET['brand']) ? $_GET['brand'] : '',
            'filter_cost' => isset($_GET['cost']) ? $_GET['cost'] : '',
            'filter_sort' => isset($_GET['sort']) ? $_GET['sort'] : '',
            'genus' => $getController,
            'itemList' => $getItemsByGenus,
            'brandList' => $getBrandsByItems,
            'maxcost' => $maxcost,
            'mincost' => $mincost,
            'pagination' => $pagination,
        ]);
    }


    public function actionBrand($brand)
    {

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getItemsByBrand = Product::find()->select('type_id')->where(['brand_id' => $brand])->
        orderBy('type_id')->distinct()->all();

        $getController = Genus::find()->where(['id' => 1])->one();


        $getBrandsByItems = Product::find()->select('brand_id')->where(['brand_id' => $brand,'public' => 1]);

        $query = Product::find();

        /// Brand Filters
        if (isset($brand)){
            if (isset($_GET['type']) AND $_GET['type'] != NULL)
                $query = $query->andWhere(['brand_id' => $brand, 'type_id' => $_GET['type']]);
            else
                $query = $query->andWhere(['brand_id' => $brand]);
        }else{
            if (isset($_GET['type']) AND $_GET['type'] != NULL)
                $query = $query->andWhere(['type_id' => $_GET['type']]);
        }

        $maxcost = $query->max('cost');
        $mincost = $query->min('cost');

        /// Cost Filters
        if (isset($_GET['cost']))
            // $query = $query->andWhere(['>', 'cost', $_GET['cost']['min']-1])->andWhere(['<', 'cost', $_GET['cost']['max']+1])->andWhere(['sale' => 0]);
            $query = $query->andFilterWhere([
                'or',
                [
                    '>',
                    'cost',
                    $_GET['cost']['min']-1,
                ],
                [
                    'and',
                    'sale!=0',
                    [
                        '>',
                        'sale',
                        $_GET['cost']['min']-1
                    ],
                ]
            ])->andFilterWhere([
                'or',
                [
                    '<',
                    'cost',
                    $_GET['cost']['max']+1,
                ],
                ['and',
                    'sale!=0',
                    [
                        '<',
                        'sale',
                        $_GET['cost']['max']+1,
                    ]
                ]
            ]);


        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $query->count(),
        ]);

        $products = $query->andWhere(['public' => 1])->orderBy(['product_id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if(isset($_GET['type']) AND $_GET['type'] != NULL)
            $getBrandsByItems = $getBrandsByItems->andWhere(['type_id' => $_GET['type']]);

        $getBrandsByItems = $getBrandsByItems->orderBy('brand_id')->distinct('brand_id')->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'products' => $products,
            'filter_brand' => isset($brand) ? $brand : '',
            'filter_cost' => isset($_GET['cost']) ? $_GET['cost'] : '',
            'filter_sort' => isset($_GET['sort']) ? $_GET['sort'] : '',
            'genus' => $getController,
            'itemList' => $getItemsByBrand,
            'brandList' => $getBrandsByItems,
            'maxcost' => $maxcost,
            'mincost' => $mincost,
            'pagination' => $pagination,
        ]);
    }


    /**
     * Displays a single Product model.
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

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   /* public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->product_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

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
}
