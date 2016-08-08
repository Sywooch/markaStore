<?php

namespace app\module\admin\controllers;

use Yii;
use app\module\admin\models\Sizesofproduct;
use app\module\admin\models\SizesofproductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\module\admin\models\Log;

/**
 * SizesofproductController implements the CRUD actions for Sizesofproduct model.
 */
class SizesofproductController extends Controller
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
     * Lists all Sizesofproduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SizesofproductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sizesofproduct model.
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
     * Creates a new Sizesofproduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sizesofproduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $newModel = [
                'id' => $model->id,
                'product_id' => $model->product_id,
                'size_id' => $model->size->size,
                'color_id' => $model->color->color_name,
                'availability' => $model->availability,
            ];
            Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Create', 'Размеры и количество');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Sizesofproduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreating($product_id)
    {
        $model = new Sizesofproduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $newModel = [
                'id' => $model->id,
                'product_id' => $model->product_id,
                'size_id' => $model->size->size,
                'color_id' => $model->color->color_name,
                'availability' => $model->availability,
            ];
            Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Create', 'Размеры и количество');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'product_id' => $product_id
            ]);
        }
    }


    /**
     * Updates an existing Sizesofproduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $oldModel = [
            'id' => $model->id,
            'product_id' => $model->product_id,
            'size_id' => $model->size->size,
            'color_id' => $model->color->color_name,
            'availability' => $model->availability,
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $newModel = [
                'id' => $model->id,
                'product_id' => $model->product_id,
                'size_id' => $model->size->size,
                'color_id' => $model->color->color_name,
                'availability' => $model->availability,
            ];
            Log::writeLog(Log::logMessageGenerator($oldModel, $newModel, $model), 'Update', 'Размеры и количество');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sizesofproduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        $newModel = [
            'id' => $id,
        ];
        $model = new Sizesofproduct();
        Log::writeLog(Log::logMessageGenerator(false, $newModel, $model), 'Delete', 'Размеры и количество');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sizesofproduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sizesofproduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sizesofproduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
