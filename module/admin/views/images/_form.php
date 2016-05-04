<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Product;
use app\module\admin\models\Colors;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Images */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="images-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

   <!-- --><?/*= $form->field($model, 'product_id')->textInput() */?>
    <?php if(isset($_GET['product_id'])): ?>
        <?=
        $form->field($model, 'product_id')->dropDownList([$_GET['product_id'] => $_GET['product_id']]) ?>
    <?php else: ?>
        <input type="checkbox" id="no_id" onchange="setNull('images-product_id');"><label>Не для товара</label>
        <?=
        $form->field($model, 'product_id')->dropDownList(ArrayHelper::map(Product::find()->all(),'product_id',
            'product_id',
            'brand.brand'
        )) ?>
    <?php endif ?>
    <?/*= $form->field($model, 'color_id')->textInput() */?>

    <?php if(isset($_GET['color_id'])): ?>
    <?=
        $form->field($model, 'color_id')->dropDownList([$_GET['color_id'] => $_GET['color_id']]) ?>
    <?php else: ?>
        <input type="checkbox" id="no_id" onchange="setNull('images-color_id');"><label>Не для товара</label>
    <?= $form->field($model, 'color_id')->dropDownList(ArrayHelper::map(Colors::find()->all(),'id','color_name')) ?>
    <?php endif ?>
    <?= $form->field($model, 'file')->fileInput()->label('Выбрать изображение') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить Изображение' : 'Внести изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>


   function setNull(id){
        if(document.getElementById(id).value > 0){
            document.getElementById(id).value=0;
            document.getElementById(id).style.display='none';
        }else{
            document.getElementById(id).style.display='block';
        }
    }

</script>
