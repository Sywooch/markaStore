<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\module\admin\models\Product;
use app\module\admin\models\Brands;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\PurchasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список товаров по заказу № ' . $_GET['order_id'];
    $this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => [\yii\helpers\Url::to('order/index')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="purchases-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?/*= Html::a('Create Purchases', ['create'], ['class' => 'btn btn-success']) */?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'content'  => function ($model) {
                    $image = \app\module\admin\models\Images::find()->
                    where(['product_id' => $model->product_id])->
                    andWhere(['color_id' => $model->color_id])->one();
                    return Html::img( Url::base() . '/images/' . $image->img_file, ['width' => '100px']);
                },
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Image',
            ],
           // 'id',
           // 'order_id',
            'product_id',
            [
                'content'  => function ($model) {
                   $name = Product::find()->where(['product_id' => $model->product_id])->one();
                 return $name->name->name;
                },
                'label' => 'Наименование',
            ],
            [
                'content'  => function ($model) {
                    $name = Product::find()->where(['product_id' => $model->product_id])->one();
                    return $name->brand->brand;
                },
                'label' => 'Бренд',
            ],

            'size.size',
            'colors.color_name',
            [
                'content'  => function ($model) {
                    $name = Product::find()->where(['product_id' => $model->product_id])->one();
                    if ($name->sale !== 0){
                        return $name->sale;
                    }else{
                        return $name->cost;
                    }
                },
                'label' => 'Цена',
            ],
             'count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
