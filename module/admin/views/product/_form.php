<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\module\admin\models\Names;
use app\module\admin\models\Brands;
use app\module\admin\models\Genus;
use app\module\admin\models\Types;
use app\module\admin\models\Sizes;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>
<script>

    function getTypes(vl){
        document.getElementById('product-name_id').setAttribute('value','');
        document.getElementById('product-type_id').setAttribute('value','');

        document.getElementById('product-type_id').setAttribute('value',document.getElementById('type-'+vl).value);
        if(document.getElementsByName('old').length != 0) {
            var old = document.getElementsByName('old');
            var id = old[0].getAttribute('id');
            document.getElementById(id).style.display = "none";
            document.getElementById(id).setAttribute('name', '');
        }
        if(document.getElementsByName('oldn').length != 0) {
            var oldn=document.getElementsByName('oldn');
            var idn=oldn[0].getAttribute( 'id' );
            document.getElementById(idn).style.display = "none";
            document.getElementById(idn).setAttribute('name', '');
        }
        document.getElementById('type-'+vl).setAttribute('name', 'old');
        var type=document.getElementById('type-'+vl);
        type.style.display="block";
        getNames(document.getElementById('type-'+vl).value);
    }
    function getNames(vl){
        if(document.getElementsByName('oldn').length != 0) {
            var old=document.getElementsByName('oldn');
            var id=old[0].getAttribute( 'id' );
            document.getElementById(id).style.display = "none";
            document.getElementById(id).setAttribute('name', '');
        }
        document.getElementById('name-'+vl).setAttribute('name', 'oldn');
        var name=document.getElementById('name-'+vl);
        name.style.display="block";
        document.getElementById('product-name_id').setAttribute('value',document.getElementById('name-'+vl).value);
        document.getElementById('product-type_id').setAttribute('value',document.getElementById('type-'+document.getElementById('product-genus_id').value).value);
    }
    function getFinish(vl){
        document.getElementById('product-name_id').setAttribute('value',document.getElementById('name-'+document.getElementById('product-type_id').value).value);
    }


</script>
<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'genus_id')->dropDownList(ArrayHelper::map(Genus::find()->all(),'id','genus'),['onchange' => 'getTypes(this.value);','prompt' => '- Выберите раздел -']) ?>

    <?php if(isset($_GET['id'])): ?>

    <div class="form-group field-product-type_id required">
        <label class="control-label" for="product-type_id" style="display: none">Тип товара</label>
        <?php foreach(Genus::find()->all() as $genus): ?>
        <select id="type-<?php echo $genus->id; ?>" class="form-control" onchange="getNames(this.value);"
                style="display: <?php echo $genus->id == $model->genus_id ? 'block' : 'none'; ?>"
<?php echo $genus->id == $model->genus_id ? 'name="old"' : ''; ?> >
            <?php foreach(Types::find()->where(['genus_id' => $genus->id])->all() as $type): ?>
            <option value="<?php echo $type->id; ?>"
                <?php echo $type->id == $model->type_id ? 'selected' : ''; ?> ><?php echo $type->type; ?></option>
            <?php endforeach; ?>
        </select>
        <?php endforeach; ?>
    </div>

    <div class="form-group field-product-name_id required">
        <label class="control-label" for="product-name_id" style="display: none">Наименование</label>
        <?php foreach(Types::find()->all() as $types): ?>
            <select id="name-<?php echo $types->id; ?>" class="form-control"
                    style="display: <?php echo $types->id == $model->type_id ? 'block' : 'none'; ?>"
                    onchange="getFinish(this.value);" <?php echo $types->id == $model->type_id ? 'name="oldn"' : ''; ?> >
                <?php foreach(Names::find()->where(['type_id' => $types->id])->all() as $name): ?>
                    <option value="<?php echo $name->id; ?>" <?php echo $name->id == $model->name_id ? 'selected' : ''; ?>
                        ><?php echo $name->name; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <div class="form-group field-product-type_id required">
        <label class="control-label" for="product-type_id" style="display: none">Тип товара</label>
        <?php foreach(Genus::find()->all() as $genus): ?>
            <select id="type-<?php echo $genus->id; ?>" class="form-control" onchange="getNames(this.value);" style="display: none">
                <?php foreach(Types::find()->where(['genus_id' => $genus->id])->all() as $type): ?>
                    <option value="<?php echo $type->id; ?>"><?php echo $type->type; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endforeach; ?>
    </div>

    <div class="form-group field-product-name_id required">
        <label class="control-label" for="product-name_id" style="display: none">Наименование</label>
        <?php foreach(Types::find()->all() as $types): ?>
            <select id="name-<?php echo $types->id; ?>" class="form-control" style="display: none" onchange="getFinish(this.value);">
                <?php foreach(Names::find()->where(['type_id' => $types->id])->all() as $name): ?>
                    <option value="<?php echo $name->id; ?>"><?php echo $name->name; ?></option>
                <?php endforeach; ?>
            </select>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>

    <?= $form->field($model, 'brand_id')->dropDownList(ArrayHelper::map(Brands::find()->all(),'id','brand')) ?>

    <?= $form->field($model, 'brand_art')->textarea() ?>

    <?= $form->field($model, 'cost')->textarea() ?>

    <?= $form->field($model, 'sale')->textarea()->label('Новая цена (SALE). Если указана сумма, то при заказе, будет учитываться сумма указанная в данном поле') ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <input id="product-type_id" class="form-control" style="display: none;" name="Product[type_id]">
    <input id="product-name_id" class="form-control" style="display: none;" name="Product[name_id]">

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить товар' : 'Внести изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php if(isset($_GET['id'])): ?>
        <script>
            document.getElementById('product-name_id').setAttribute('value',<?php echo $model->name_id; ?>);
            document.getElementById('product-type_id').setAttribute('value',<?php echo $model->type_id; ?>);
        </script>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

</div>
