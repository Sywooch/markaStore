<?php

	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\helpers\Url;

	/* @var $this yii\web\View */
	/* @var $searchModel app\module\admin\models\LogSearch */
	/* @var $dataProvider yii\data\ActiveDataProvider */

	$this->title = 'История действий';
	$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
	</div>
	<div class="col-md-10" >
		<div class="followers-index">

			<h1><?= Html::encode($this->title) ?></h1>
			<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					//'id',
					'section',
					'date',
					'user.username',
					'action',
					'message',

				],
			]); ?>

		</div>
	</div>
</div>
