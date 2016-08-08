<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\module\admin\models\Messages;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Genus;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Notify */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notify-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condition')->dropDownList([0 => 'Товаров добавлено', 1 => 'Товаров со скидкой'])->label('Если, ') ?>

    <?= $form->field($model, 'condition2')->dropDownList(['>']) ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'condition3')->dropDownList(ArrayHelper::map(Genus::find()->all(),'id','genus')) ?>

    <?= $form->field($model, 'message_id')->dropDownList(ArrayHelper::map(Messages::find()->all(), 'id', 'name'))->label('Отправить сообщение по шаблону') ?>

    <?= $form->field($model, 'status')->dropDownList([0 => 'deactive', 1 => 'active']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
