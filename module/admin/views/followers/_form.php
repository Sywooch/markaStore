<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Genus;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Followers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="followers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genus_id')->radioList(ArrayHelper::map(Genus::find()->all(),'id','genus'),['class' => 'text-uppercase'])->label(false) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
