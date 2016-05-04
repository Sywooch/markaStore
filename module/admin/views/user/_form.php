<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= ($model->isNewRecord ?
        $form->field($model, 'password')->passwordInput(['maxlength' => true]) :
        $form->field($model, 'password')->passwordInput(['maxlength' => true , 'value' => ''])
        ) ?>

    <?/*= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) */?>

    <?/*= $form->field($model, 'token')->textInput(['maxlength' => true]) */?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?/*= $form->field($model, 'role')->textInput(['maxlength' => true]) */?>

    <?= $form->field($model, 'role')->dropDownList(['admin' => 'admin', 'user' => 'user']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Внести изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
