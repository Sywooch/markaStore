<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\ConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конфигурация';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить конфигурацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
            'parameter:ntext',
                ['content' => function($model){
                    return strlen($model->value) > 50 ? substr($model->value , 0, 50) . ' ...' : $model->value;
                },
                'label' => 'Value'],
            /*'value',*/
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
