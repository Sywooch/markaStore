<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\module\admin\models\Sizes;
use app\module\admin\models\Colors;
use app\module\admin\controllers\SizesofproductController;
use app\module\admin\models\Sizesofproduct;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\SizesofproductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sizesofproducts';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="sizesofproduct-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sizesofproduct', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'size.size',

            [

                'contentOptions' =>
        function ($model)
        {
        return
                    [ 'style' => 'background-color: #' . $model->color->color . ';'];
        },
                        'attribute' => 'color.color_name',
                        'format' => 'html',
                        'label' => 'Color',

               /* 'attribute' => 'color.color',
                'format' => 'html',
                'label' => 'Color',*/
            ],
           // 'color.color:html',
            'availability',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
