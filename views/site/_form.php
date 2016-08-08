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

    <?= $form->field($followers, 'fio')->textInput(['placeholder' => 'Прізвище та Ім`я'])->label(false) ?>

    <?= $form->field($followers, 'email')->textInput(['placeholder'=>'E-mail' , 'class' => 'form-control'])->label(false) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($followers, 'genus_id')->radioList(ArrayHelper::map(Genus::find()->all(),'id','genus'),['class' => 'text-uppercase'])->label(false) ?>
        </div>
        <div class="col-md-6" align="right">
            <button class="primary-button-large-wide">Підписатися</button>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
