<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Genus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="genus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'genus')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать раздел' : 'Внести обновление в раздел', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
