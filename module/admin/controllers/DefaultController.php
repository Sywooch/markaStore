<?php

namespace app\module\admin\controllers;

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

    public function actionStatistic()
    {
        return $this->render('statistic');
    }
}
