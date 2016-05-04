<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BrandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brands-index">

    <center><h1 style="margin-top: -50px;" ><?= Html::encode($this->title) ?></h1></center>
    <?php /*echo $this->render('_search', ['model' => $searchModel]); */?>
    </br></br>
    <div class="row">
    <?//= ListView::widget([
        //'dataProvider' => $dataProvider,
        //'itemOptions' => ['class' => 'item'],
        //'itemView' => function ($model, $key, $index, $widget) {
          //  return

            //Html::encode($model->brand);
               // Html::a(Html::encode($model->brand), ['view', 'brand' => $model->brand]);
            //    print ('<div class="col-md-2">');
              //  Html::a(Html::encode($model->brand), ['view', 'brand' => $model->brand]);
           // print ('</div>');
       // },

    //])
    ?>
        <?php foreach ($allbrands as $brand): ?>
        <div class="col-md-2" style="height: 50px;"><p class="text-center text-uppercase" >
        <?= Html::a(Html::encode($brand->brand) ,  Url::toRoute('all/brand?brand=' . $brand->id), ['style' => 'color: #1a1a1a;']); ?>
            </p></div>
<? endforeach; ?>

        </div>

</div>
