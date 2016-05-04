<!--<div class="admin-default-index">
    <h1><?/*= $this->context->action->uniqueId */?></h1>
    <p>
        This is the view content for action "<?/*= $this->context->action->id */?>".
        The action belongs to the controller "<?/*= get_class($this->context) */?>"
        in the "<?/*= $this->context->module->id */?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?/*= __FILE__ */?></code>
    </p>
</div>
-->

<?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\GridView;
    use app\module\admin\models\Order;
    use app\module\admin\models\Purchases;

    /* @var $this yii\web\View */
    /* @var $searchModel app\module\admin\models\ProductSizesSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

  /*  $this->title = 'admin Panel';
    $this->params['breadcrumbs'][] = $this->title;
*/?><!--
<div class="woman-sizes-index">-->

 <!--   <h1><?/*= Html::encode($this->title) */?></h1>
    <?php /*// echo $this->render('_search', ['model' => $searchModel]); */?>

    <p>
        <?/*= Html::a('Create Product Sizes', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
<!--
</div>-->

<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?></div>
    <div class="col-md-10">
        <p><h2><?= Html::a('Статистика', [Url::to('/admin/default/statistic')]); ?></h2></p>
        <?php
            foreach (Order::find()->where(['like', 'date', date('o')])->all() as $item_id) {
                //$i_id[] = ->id;
                $ffddf = Purchases::find()->where(['order_id' => $item_id->id]);
                $ssmf[] = $ffddf->count();
                $summa[] = array_sum($ssmf);
            }
            $max = max($summa);
        ?>
		<p><h3><?= date('o') ?></h3></p>
		<table class="table">
			<tr>
			<?php for($i = 1; $i <= 12; $i++): ?>
			<td align="center">
			<?php $count = 0; foreach(Order::find()->where(['like', 'date', date('o') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT)])->all() as $item_id): ?>
<?php
$count = $count + Purchases::find()->where(['order_id' => $item_id->id])->count();
?>
<?php endforeach; ?>
<span class="glyphicon glyphicon-record" style=" color: <?php echo $count == 0 ? '#cccccc' : '#337ab7'  ?>; padding-top:<?php
echo 100-($count*100/$max); ?>px; margin-bottom: 0;"><p><?php
echo $count; ?></p></span>

</td>

				<?php endfor ?>
			</tr>
			<tr>
<?php for($i = 1; $i <= 12; $i++): ?>
				<td align="center">
					<div style="margin-bottom: 0; padding-bottom: 0;"><?php
echo $i == 1 ? 'Янв' : ($i == 2 ? 'Фев' : ($i == 3 ? 'Мар' : ($i == 4 ? 'Апр' :
($i == 5 ? 'Май' : ($i == 6 ? 'Июн' : ($i == 7 ? 'Июл' : ($i == 8 ? 'Авг' :
  ($i == 9 ? 'Сен' : ($i == 10 ? 'Окт' : ($i == 11 ? 'Ноя' : ($i == 12 ? 'Дек' : '')))))))))));
 ?>
</div>
				</td>
				<?php endfor ?>
			</tr>
		</table>

<p><h2>Последние активные заказы:</h2></p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [

                'id',
                'date',
                'user.username',
                'fio',
                [
                    'content'  => function ($model) {
                 return '+380' . $model->phone; }
                ],
                //'phone:ntext',
                'email:ntext',
                'final_cost',
                [
                    'content'  => function ($model) {
                        return Html::a('Просмотр заказа', ["/admin/purchases/index?order_id=" . $model->id], ['class'=>'btn btn-default']);
                    }
                ],
            ],
        ]); ?>



        <!--<div class="product-sizes-index">

            <?/*= Html::a('Товары', ['/admin/product/'], ['class' => 'btn btn-success']) */?>
            <?/*= Html::a('Размеры и количество товаров', ['/admin/sizesofproduct/index'], ['class' => 'btn btn-success']) */?>
            <?/*= Html::a('Фото товаров', ['/admin/images'], ['class' => 'btn btn-success']) */?>
            <?/*= Html::a('Материал товара', ['/admin/materialproduct'], ['class' => 'btn btn-success']) */?>
            </br> </br>
            <?/*= Html::a('База Размеров', ['/admin/sizes'], ['class' => 'btn btn-warning']) */?>
            <?/*= Html::a('База цветов', ['/admin/colors'], ['class' => 'btn btn-warning']) */?>
            <?/*= Html::a('База материалов', ['/admin/materials'], ['class' => 'btn btn-warning']) */?>
            </br> </br>
            <?/*= Html::a('Разделы', ['/admin/genus'], ['class' => 'btn btn-default']) */?>
            <?/*= Html::a('Типы товаров', ['/admin/types'], ['class' => 'btn btn-default']) */?>
            <?/*= Html::a('Названия товаров', ['/admin/names'], ['class' => 'btn btn-default']) */?>
        </div>

        </br> </br>
        <div class="panel panel-default">
            <div class="panel-body">

                <button class="btn btn-primary" onclick="location.href='<?/*= Url::to('admin/order')*/?>'" >Заказы <span class="badge">
            <?php
/*                echo Order::find()->where(['status' => 1])->count();
            */?>
        </span>
                </button>
            </div>-->
        </div>
    </div>
</div>

