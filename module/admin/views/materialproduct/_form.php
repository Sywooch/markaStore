<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Materials;
    use app\module\admin\models\Materialproduct;
use app\module\admin\models\Product;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Materialproduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="materialproduct-form">

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

   <!-- --><?/*= $form->field($model, 'material_id')->textInput() */?>
    <?= $form->field($model, 'material_id')->dropDownList(ArrayHelper::map(Materials::find()->all(),'id','material')) ?>

   <!-- --><?/*= $form->field($model, 'procent')->textInput() */?>

    <?= $form->field($model, 'procent',[
        'template' => '<div class="input-group">{input}<span class="input-group-addon">%</span></div>{error}',
        'inputOptions'=> ['max' => Materialproduct::getMaterialSum(isset($_GET['product_id']) ? $_GET['product_id'] : '0'),
            'required' => true,
            'class' => 'form-control'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Внести изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
