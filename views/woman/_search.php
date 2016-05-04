<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WomanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="woman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'name_id') ?>

    <?= $form->field($model, 'brand_id') ?>

    <?= $form->field($model, 'genus_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?php // echo $form->field($model, 'brand_art') ?>

    <?php // echo $form->field($model, 'sale') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'public') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
