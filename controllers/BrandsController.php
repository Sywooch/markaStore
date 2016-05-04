<?php

namespace app\controllers;

use Yii;
use app\models\Brands;
use app\models\BrandsSearch;
use yii\web\Controller;
use yii\data\Pagination;
use app\module\admin\models\ProductSearch;
use app\module\admin\models\Product;
use app\module\admin\models\Genus;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * BrandsController implements the CRUD actions for Brands model.
 */
class BrandsController extends Controller
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
     * Lists all Brands models.
     * @return mixed
     */
   public function actionIndex()
    {
        $searchModel = new BrandsSearch();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $allbrands = Brands::find()->orderBy('brand')->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Brands::find(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'brand' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allbrands' => $allbrands,
        ]);
    }

    public function actionBrands($filter_brand = [], $filter_cost = [])
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getItemsByGenus = Product::find()->select('type_id')->
        orderBy('type_id')->distinct('type_id')->all();

        $getBrandsByItems = Product::find()->select('brand_id')->where(['public' => 1]);

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

        $products = $query->orderBy('product_id')
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
            'genus' => '???',
            'itemList' => $getItemsByGenus,
            'brandList' => $getBrandsByItems,
            'maxcost' => $maxcost,
            'mincost' => $mincost,
            'pagination' => $pagination,
        ]);
    }


    /**
     * Displays a single Brands model.
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
     * Creates a new Brands model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brands();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brands model.
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
     * Deletes an existing Brands model.
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
     * Finds the Brands model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brands the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brands::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
