<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\ColorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Colors';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="colors-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Colors', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?=
        GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'rowOptions' =>function ($model)
    {
            return [
              'style' => 'background-color: #' . $model->color . ';',
    ];
    },
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'color:html',
                'color_name:text',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
