<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\module\admin\models\Order;
use app\module\admin\models\Followers;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Messages */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'E-mail рассылка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            //'id',
            'name',
            'subject'
        ],
    ]) ?>
<div align="center"><label>Тело письма: </label></div>
    <div>

    <?= html_entity_decode($model->message) ?>

    </div>
</div>
