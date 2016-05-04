<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Woman */

$this->title = 'Create Woman';
$this->params['breadcrumbs'][] = ['label' => 'Women', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="woman-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
