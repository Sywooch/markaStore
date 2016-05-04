<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
    use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Slidebar */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="slidebar-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= Yii::$app->user->getName() == 'art' ? $form->field($model, 'id')->textarea(['rows' => 4]) : 'error' ?>


     <?= $form->field($model, 'head')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'onblur' => 'slidePreview();', 'id' => 'descr']) ?>

    <?= $form->field($model, 'file')->fileInput()->label('Добавление слайда (Размеры картинки должны быть 2000 х 811 px)') ?>

   <!-- --><?/*= $form->field($model, 'image_url')->textarea(['rows' => 6]) */?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php if(isset($model->id)): ?>

    <h2>Предпросмотр</h2>
</br></br>
<div align="center">
    <div id="carousel-example-generic"  style="margin-left: -2%; margin-right: -2%; margin-top: -2%;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
    </ol>
			<div class="carousel-inner" role="listbox">
                    <div style="width: 100%;" class="item active">
                        <div style="width: 100%;
                            background: url(<?php echo Url::base() . '/images/' . $model->image_url; ?>) 100% no-repeat;
                            background-size: 100%; height: 500px; margin-top: -5%;" >
                            <div class="carousel-caption" id="slide">
                                <?/*= html_entity_decode($model->description); */?>
                            </div>
                        </div>

                    </div>
    </div>

</div>

<?php endif; ?>



    <script>
        document.getElementById('slide').innerHTML = document.getElementById('descr').value;
        function slidePreview(){

            document.getElementById('slide').innerHTML = document.getElementById('descr').value;

        }


    </script>