<?php

namespace app\module\admin\controllers;

use app\module\admin\models\User;
use Yii;
use app\module\admin\models\Followers;
use app\module\admin\models\FollowersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\module\admin\models\Order;

/**
 * FollowersController implements the CRUD actions for Followers model.
 */
class FollowersController extends Controller
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
     * Lists all Followers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FollowersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Followers model.
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
     * Creates a new Followers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Followers();
        $order = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$order->sendEmail('markaua2014@gmail.com', 'Появился новый подписчик в LoungeStore Markaua', $model->fio . "\r\n" . $model->email);
            //$order->sendEmail('art@naverex.net', 'New follower in LoungeStore Markaua', $model->fio . '-' . $model->email);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionMailing($id, $mailing)
    {
        $model = $this->findModel($id);

            if($mailing == 1){
                $model->mailing = 1;
                $model->save();
            }else{
                $model->mailing = 0;
                $model->save();
            }

        return $this->redirect('index');
    }

    /**
     * Updates an existing Followers model.
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
     * Deletes an existing Followers model.
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
     * Finds the Followers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Followers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Followers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
