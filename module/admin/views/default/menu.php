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
	<button class="btn btn-info" onclick="location.href='<?= Url::toRoute('order/index')?>'" >Заказы <span class="badge">
            <?php
				echo Order::find()->where(['status' => 1])->count();
			?>
        </span>
	</button></br>
		<button type="button" style="text-align: left;" class="btn btn-default" onclick="location.href='<?= Url::toRoute('/admin')?>'">
			<span class="glyphicon glyphicon-home"></span>  Основная панель
		</button>
		</div>
	<div class="btn-group">
	<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="glyphicon glyphicon-shopping-cart"></span>  Магазин
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><?= Html::a('Список товаров', [Url::to('/admin/product/index')]); ?></li>
		<li><?= Html::a('Размеры и количество товаров', [Url::to('/admin/sizesofproduct/index')]); ?></li>
		<li><?= Html::a('Фото товаров', [Url::to('/admin/images/index')]); ?></li>
		<li><?= Html::a('Материалы товаров', [Url::to('/admin/materialproduct/index')]); ?></li>
	</ul>
	</div>
	<div class="btn-group">
	<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="glyphicon glyphicon-indent-left"></span>  Наполнение Баз
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><?= Html::a('База размеров', [Url::to('/admin/sizes/index')]); ?></li>
		<li><?= Html::a('База цветов', [Url::to('/admin/colors/index')]); ?></li>
		<li><?= Html::a('База материалов', [Url::to('/admin/materials/index')]); ?></li>
		<li><?= Html::a('База брендов', [Url::to('/admin/brands/index')]); ?></li>
	</ul>
</div>
	<div class="btn-group">
		<button type="button" style="text-align: left;" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="glyphicon glyphicon-eye-open"></span>  Сайт
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li><?= Html::a('Слайдер', [Url::to('/admin/slidebar/index')]); ?></li>
			<li><?= Html::a('Посты', [Url::to('/admin/post/index')]); ?></li>
			<li><?= Html::a('E-mail рассылка', [Url::to('/admin/messages/index')]); ?></li>
			<li><?= Html::a('Условия рассылки', [Url::to('/admin/notify/index')]); ?></li>
			<li role="separator" class="divider"></li>
			<li><?= Html::a('Разделы', [Url::to('/admin/genus/index')]); ?></li>
			<li><?= Html::a('Типы товаров', [Url::to('/admin/types/index')]); ?></li>
			<li><?= Html::a('Названия товаров', [Url::to('/admin/names/index')]); ?></li>
			<li role="separator" class="divider"></li>
			<li><?= Html::a('<small><span class="glyphicon glyphicon-bullhorn"></span></small> Подписчики', [Url::to('/admin/followers/index')]); ?></li>
			<li><?= Html::a('<small><span class="glyphicon glyphicon-user"></span></small> Пользователи', [Url::to('/admin/user/index')]); ?></li>
		</ul>
	</div>
	<?= Html::a('<span class="glyphicon glyphicon-wrench"></span> Конфигурация', [Url::to('/admin/config/index')],
		['class' => 'btn btn-default', 'style' => 'text-align: left;']); ?>
	<?= Html::a('<span class="glyphicon glyphicon-time"></span> История действий', [Url::to('/admin/default/log')],
		['class' => 'btn btn-default', 'style' => 'text-align: left;']); ?>

</div>