<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Genus */

$this->title = $model->genus_id;
$this->params['breadcrumbs'][] = ['label' => 'Genuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genus-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->genus_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->genus_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'genus_id',
            'genus:ntext',
            'type_id',
        ],
    ]) ?>

</div>
