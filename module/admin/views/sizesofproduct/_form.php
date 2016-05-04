<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Sizes;
use app\module\admin\models\Product;
use app\module\admin\models\Colors;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Sizesofproduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sizesofproduct-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(isset($_GET['product_id'])): ?>
        <?=
        $form->field($model, 'product_id')->dropDownList([$_GET['product_id'] => $_GET['product_id']]) ?>
    <?php else: ?>
    <?=
        $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(),'product_id',
        'product_id',
        'brand.brand'
    )) ?>
    <?php endif ?>

    <?= $form->field($model, 'size_id')->dropDownList(ArrayHelper::map(Sizes::find()->all(),'id','size')) ?>

    <?= $form->field($model, 'color_id')->dropDownList(ArrayHelper::map(Colors::find()->all(),'id','color_name')) ?>

    <?= $form->field($model, 'availability')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Внести изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
