<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Все заказы';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <!-- --><?/*= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) */?>
    </p>

    <?php if($error): ?>
    <?php foreach($error as $showErr): ?>
            <div class="alert alert-danger" role="alert"><?php echo $showErr; ?></div>
    <?php endforeach; ?>
    <?php endif; ?>

    <?php if($success): ?>
        <?php foreach($success as $showScs): ?>
            <div class="alert alert-success" role="alert"><?php echo $showScs; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if($info): ?>
        <?php foreach($info as $showInf): ?>
            <div class="alert alert-info" role="alert"><?php echo $showInf; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    </br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'date',
            'user.username',
            'fio',
            [
                'content'  => function ($model) {
                    return '+380' . $model->phone; }
            ],
            'email:ntext',
            'final_cost',
            [
                'content'  => function ($model) {
                 return Html::a('Просмотр заказа', ["/admin/purchases/index?order_id=" . $model->id], ['class'=>'btn btn-default']);
                }
            ],
            [
                'content'  => function ($model) {
                    if ($model->status == 1){
                        return Html::a('Провести', ["/admin/order/sold?id=" . $model->id], ['class'=>'btn btn-danger']);
                    }else{
                        return Html::encode('Проведено');
                    }
                }
            ],
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div></div>
