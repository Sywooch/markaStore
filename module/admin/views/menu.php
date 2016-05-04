<?php

	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\grid\GridView;
	use app\module\admin\models\Order;
	use app\module\admin\models\Purchases;

	/* @var $this yii\web\View */
	/* @var $searchModel app\module\admin\models\ProductSizesSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */
?>


<div class="btn-group-vertical" role="group" style="width: 100%;">
	<div class="btn-group">
	<button class="btn btn-info" onclick="location.href='<?= Url::to('admin/order')?>'" >Заказы <span class="badge">
            <?php
				echo Order::find()->where(['status' => 1])->count();
			?>
        </span>
	</button>
		</div>
	<div class="btn-group">
	<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Магазин
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="admin/product/index">Список товаров</a></li>
		<li><a href="admin/sizesofproduct/index">Размеры и количество товаров</a></li>
		<li><a href="admin/images">Фото товаров</a></li>
		<li><a href="admin/materialproduct">Материалы товаров</a></li>
	</ul>
	</div>
	<div class="btn-group">
	<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Наполнение Баз
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a href="admin/sizes">База Размеров</a></li>
		<li><a href="admin/colors">База цветов</a></li>
		<li><a href="admin/materials">База материалов</a></li>
	</ul>
</div>
	<div class="btn-group">
		<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Сайт
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><a href="admin/genus">Разделы</a></li>
			<li><a href="admin/types">Типы товаров</a></li>
			<li><a href="admin/names">Названия товаров</a></li>
		</ul>
	</div>
</div>