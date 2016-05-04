<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Sizesofproduct */

$this->title = 'Размер: ' . $model->size->size . ' | Цвет: ' . $model->color->color_name;
$this->params['breadcrumbs'][] = ['label' => 'Sizesofproducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="sizesofproduct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'order-button-large-wide']) ?>
        <?= Html::a('Удалить связку размер / цвет', ['delete', 'id' => $model->id], [
            'class' => 'cancel-button-large-wide',
            'data' => [
                'confirm' => 'Вы уверены что ходите уданить данную связку размер / цвет?',
                'method' => 'post',
            ],
        ]) ?>
        <button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/sizesofproduct/create?product_id=' . $model->product_id) ?>'">Добавить еще связку размер / цвет товара</button>
        <button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/images/create?product_id=' . $model->product_id . '&color_id=' . $model->color_id) ?>'">Добавить изображение</button>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'size.size',
            'color.color_name',
            'availability',
        ],
    ]) ?>


</div>
</div>
