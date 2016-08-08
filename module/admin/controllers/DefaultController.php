<?php

namespace app\module\admin\controllers;

use app\module\admin\models\Log;
use app\module\admin\models\LogSearch;
use Yii;
use yii\web\Controller;
use app\module\admin\models\OrderSearch;
use yii\data\ActiveDataProvider;
use app\module\admin\models\Order;

class DefaultController extends Controller
{
    public function actionIndex()
    {

        $searchModel = new OrderSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['status' => 1]),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

       /* return $this->render('index');*/
    }
    public function actionMenu()
    {
        return $this->render('menu');
    }

    public function actionSend()
    {
        $emails = Order::find()->select('email')->distinct()->all();
        return $this->render('sendemail', ['emails' => $emails]);
    }

    public function actionLog()
    {
        $searchModel = new LogSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => Log::find(),
            'pagination' => [
                'pageSize' => 20,
                'validatePage' => false,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ],
            ],
        ]);
        return $this->render('log', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }


    public function actionStatistic()
    {
        return $this->render('statistic');
    }
}
