<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\grid\GridView;
use app\module\admin\models\Genus;
use app\module\admin\models\Sizesofproduct;
    use yii\helpers\ArrayHelper;
    use app\module\admin\models\Materialproduct;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список товаров';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
            <!--</br></br><h4>Поиск товара</h4>
        --><?php /*echo $this->render('_search', ['model' => $searchModel]); */?>
    </div>
    <div class="col-md-10">
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
       <h4> <?= Html::a('Добавить новый товар', ['create'], ['class' => 'btn order-button-large-wide']) ?> </h4>
    </p>
    </br>
    <form action="<?php Url::toRoute('findbyart'); ?>">
        <div class="row" >
            <div class="col-lg-2" style="padding-right: 0; padding-left: 0;">
                <div class="input-group">
                    <div class="input-group-btn">
                        <select name="genus" class="btn btn-default">
                            <?php foreach(Genus::find()->all() as $genusArt): ?>
                                <option value="<?php echo $genusArt->id; ?>"><?php echo strtoupper(substr($genusArt->genus, 0, 1)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div><!-- /btn-group -->
                    <input type="text" placeholder="000" name="id" class="form-control">
                </div>
            </div>
            <div class="col-lg-2" style="padding-right: 0; padding-left: 0;">
                <div class="input-group">
                    <span class="input-group-addon">S</span>
                    <input type="text" placeholder="000" name="size" class="form-control">
                </div>
            </div>
            <div class="col-lg-4" style="padding-right: 0; padding-left: 0;">
                <div class="input-group">
                    <span class="input-group-addon">C</span>
                    <input type="text" placeholder="000" name="color" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn btn-default" onclick="this.form.submit()" type="button">Поиск по артикулу
                        </button>
                    </div>
                </div>
            </div>
    </form>

</div>
</div>
    </br>
</div>
    </br></br>
<div>
    <?=

        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],

                'product_id',

                'brand_art',
                'genus.genus',
                'name.name',
                'brand.brand',
                'type.type',
                /*
							[
								// 'attribute'=>'quantity',
								'attribute' => 'availability',
									'content'  => function ($model) {
									foreach(Sizesofproduct::find()->select('availability')->where(['product_id' => $model->product_id])->all() as $quant){
										foreach($quant as $quants){

											echo $quants;
										}
										return $quant->availability;
									}

								},
								'format' => 'text',
				],*/
                //   'quantity.availability',
                // 'size_id',
                //'quantity',
                // 'size_id.size_id',
                // 'quantity.quantity',
                /*[
					'contentOptions' =>
						function ($model)
						{
							return
								[ 'style' => 'background-color: #' . $model->color->color . ';'];
						},
					'attribute' => 'color.color_name',
					'format' => 'html',
					'label' => 'Quantity',

					/* 'attribute' => 'color.color',
					 'format' => 'html',
					 'label' => 'Color',*/
                // ],*/

                'cost',
                'sale',
                [
                    'content'  => function ($model) {
                        if (isset($_GET['size']) and isset($_GET['color']) and isset($_GET['genus']) and isset($_GET['id']) and
                            !empty($_GET['size']) and !empty($_GET['color']) and !empty($_GET['genus']) and !empty($_GET['id'])) {
                            foreach (Sizesofproduct::find()->where(['product_id' => $_GET['id'], 'size_id' => $_GET['size'],
                                'color_id' => $_GET['color']])->all() as $sizecolor) {
                                $array[] = Html::a($sizecolor->size->size . '   <span class="badge">' . $sizecolor->availability . '</span>',
                                    [Url::to('sizesofproduct/view?id=' . $sizecolor->id)], [
                                        'class' => 'btn', 'style' => 'background-color: #' . $sizecolor->color->color . ';', 'alt' => $sizecolor->color->color_name]);
                            }
                        }else{
                            foreach (Sizesofproduct::find()->where(['product_id' => $model->product_id])->all() as $sizecolor) {
                                $array[] = Html::a($sizecolor->size->size . '   <span class="badge">' . $sizecolor->availability . '</span>',
                                    [Url::to('sizesofproduct/view?id=' . $sizecolor->id)], [
                                        'class' => 'btn', 'style' => 'background-color: #' . $sizecolor->color->color . ';', 'alt' => $sizecolor->color->color_name]);

                            }
                        }

                        if(isset($array)){
                            return implode('</br>',$array) . ' ' . Html::a('',[
                                Url::to('sizesofproduct/create?product_id=' . $model->product_id )],['class' => 'glyphicon glyphicon-plus']);
                        }else {
                            return Html::a('', [Url::to('sizesofproduct/create?product_id=' . $model->product_id)], ['class' => 'glyphicon glyphicon-plus']);
                        }
                },
                    'label' => 'Размеры/Цвета',
                ],
        [
        'content'  => function ($model) {
            foreach(Materialproduct::find()->where(['product_id' => $model->product_id])->all() as $allmaterial){
                $array[] = Html::a($allmaterial->materials->material . ' ' . $allmaterial->procent . '%',
                    [Url::to('materialproduct/view?id=' . $allmaterial->id)],
                    ['class' => 'btn btn-link']);
            }
            if (isset($array)){
                return implode(',', $array) . (Materialproduct::getMaterialSum($model->product_id) > 0 ? Html::a('',[Url::to('materialproduct/create?product_id=' . $model->product_id )],['class' => 'glyphicon glyphicon-plus']) : ' ');
            }else{
                return Materialproduct::getMaterialSum($model->product_id) != 0 ? (Html::a('',[Url::to('materialproduct/create?product_id=' . $model->product_id )],['class' => 'glyphicon glyphicon-plus'])) : '';
            }

        },
            'label' => 'Материал',
        ],
                'description:ntext',
                [
                    'content'  => function ($model) {

                        if ($model->public == 0){
                            return Html::a('Опубликовать', ["/admin/product/publish?id=$model->product_id"], ['class'=>'btn btn-success']);
                        }else{
                            return Html::a('Скрыть', ["/admin/product/unpublish?id=$model->product_id"], ['class'=>'btn btn-danger']);
                        }

                    },
                    'label' => 'Видимость',
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

</div>