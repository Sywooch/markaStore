<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\NotifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Условия рассылки';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
    $this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
        <!--</br></br><h4>Поиск товара</h4>
	--><?php /*echo $this->render('_search', ['model' => $searchModel]); */?>
    </div>
    <div class="col-md-10">
<div class="notify-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новое условие', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            ['content' => function($model){
                if ($model->condition == 0) return 'Товаров добавлено';
                if ($model->condition == 1) return 'Товаров со скидкой';
            },
            'label' => 'Условие'],
            ['content' => function($model){
                if ($model->condition2 == 0) return '>';
            },
                'label' => '...'],
            'number',
            'genus.genus',
            ['content' => function($model){
                return $model->message->name;
            },
                'label' => 'Сообщение'],
            ['content' => function ($model){
                if ($model->status != 1){
                    return Html::a('Активировать', ["/admin/notify/active?id=$model->id"], ['class'=>'btn btn-success']);
                }else{
                    return Html::a('Деактивировать', ["/admin/notify/deactive?id=$model->id"], ['class'=>'btn btn-danger']);
                }
            },  'label' => 'Действие',],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
