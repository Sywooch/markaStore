<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Images */

$this->title = 'Изображение №' . $model->id . ' для цвета: ' . $model->color->color_name;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="images-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'order-button-large-wide']) ?>
        <?= Html::a('Удалить изображение', ['delete', 'id' => $model->id], [
            'class' => 'cancel-button-large-wide',
            'data' => [
                'confirm' => 'Вы уверены что ходите уданить данное изображение?',
                'method' => 'post',
            ],
        ]) ?>
<button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/images/create?product_id=' . $model->product_id . '&color_id=' . $model->color_id) ?>'">Добавить еще изображение</button>
<button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/materialproduct/create?product_id=' . $model->product_id) ?>'">Добавить материал товара</button>

    </p>
    <div class="row">
        <div class="col-md-4">
            <img width="90%" src="<?php echo Url::base() . '/images/' . $model->img_file; ?>">
            </div>
        <div class="col-md-6" >
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'product_id',
            'color_id',
            'img_file:ntext',
        ],
    ]) ?>
</div>
        </div>

</div>
</div>
