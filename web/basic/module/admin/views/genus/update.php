<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Genus */

$this->title = 'Update Genus: ' . ' ' . $model->genus_id;
$this->params['breadcrumbs'][] = ['label' => 'Genuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->genus_id, 'url' => ['view', 'id' => $model->genus_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="genus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
