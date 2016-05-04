<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Materialproduct */

$this->title = $model->materials->material . ' ' . $model->procent . '%';
$this->params['breadcrumbs'][] = ['label' => 'Materialproducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="materialproduct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'order-button-large-wide']) ?>
        <?= Html::a('Удалить материал товара', ['delete', 'id' => $model->id], [
            'class' => 'cancel-button-large-wide',
            'data' => [
                'confirm' => 'Вы уверены что ходите уданить данный материал?',
                'method' => 'post',
            ],
        ]) ?>
        <button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/materialproduct/create?product_id=' . $model->product_id) ?>'">Добавить еще материал товара</button>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'material_id',
            'procent',
        ],
    ]) ?>

</div>
</div>
