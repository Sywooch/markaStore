
<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Woman;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin() ?>

    <?/*= $form->field($model, 'user_id')->textInput() */?>

    <?= $form->field($model, 'fio')->textInput(['placeholder' => 'Прізвище та Ім`я'])->label(false) ?>

    <?/*= $form->field($model, 'phone')->input('int', ['maxlength' => 9])->label(false) */?>
    <?= $form->field($model, 'phone',[
    'template' => '<div class="input-group">
<span class="input-group-addon">+380</span>{input}</div>{error}',
        'inputOptions'=> ['placeholder'=>'Контактний номер телефону', 'maxlength' => 9]
    ]) ?>

    <?= $form->field($model, 'email')->input('email',['placeholder' => 'E-mail'])->label(false) ?>


   <!-- --><?/*= $form->field($model, 'date')->textarea(['vslue' =>  date('Y-m-d h:M')]) */?>

   <!-- --><?/*= $form->field($model, 'status')->textInput() */?>

   <!-- <div class="form-group">
        <?/*= Html::submitButton('Замовити', ['class' => 'btn btn-success' ]) */?>
    </div>-->

    <div class="form-group">
        <div class="modal-footer">
        <?= Html::submitButton('Замовити', ['class' => 'order-button-large-wide']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
