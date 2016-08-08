<?php

	/* @var $this \yii\web\View */
	/* @var $content string */

	use yii\helpers\Html;
	use \yii\helpers\Url;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\module\admin\models\Brands;
	use app\module\admin\models\Config;
	use app\assets\AppAsset;
	use app\module\admin\models\Genus;
	use app\module\admin\models\Types;
	use app\module\admin\models\Order;
	use app\models\Woman;
	use yii\helpers\ArrayHelper;
	use app\module\admin\models\Images;
	use app\module\admin\models\Sizesofproduct;
	use yii\web\ForbiddenHttpException;

	if (stristr(Yii::$app->request->getAbsoluteUrl(), 'cart') === false) {
		if (stristr(Yii::$app->request->getAbsoluteUrl(), 'view') === false) {
			Url::remember();
		}
	}


	if (Yii::$app->user->getRole() == NULL and (stristr(Yii::$app->request->getAbsoluteUrl(), 'admin')
			or stristr(Yii::$app->request->getAbsoluteUrl(), 'personal'))) {
		Yii::$app->response->redirect(Url::to('/'));
	}elseif(Yii::$app->user->getRole() == 'user' and stristr(Yii::$app->request->getAbsoluteUrl(), 'admin')){
		Yii::$app->response->redirect(Url::to('/'));
	}

	// session_start();
	/*$_SESSION = NULL;
		$_SESSION = [];*/
	$keywords = isset(Config::getConfig('meta', 'keywords')->value) ? Config::getConfig('meta', 'keywords')->value : '';
	$descriptions = isset(Config::getConfig('meta', 'descriptions')->value) ? Config::getConfig('meta', 'descriptions')->value : '';
	 foreach (\app\module\admin\models\Names::find()->orderBy(['id' => SORT_DESC])->all() as $name) $names[] = $name->name;
	$keywords = $keywords . implode(',',$names);
	$keywordsCount = strlen($keywords);
	$keywordsMax = 250;

	AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<?= Html::csrfMetaTags() ?>
	<meta name="copyright" lang="<?= Yii::$app->language ?>" content="Lounge Store MarkaUa">
	<meta name="Keywords"
		  content="<?= ($keywordsCount < $keywordsMax ? $keywords : substr($keywords, 0, $keywordsMax)) ?>">
	<meta name="description" content="<?= $descriptions ?>">
	<meta name="document-state" content="Dynamic">
	<meta name="robots" content="all">
	<title><?= Html::encode(Config::getConfig('meta', 'title')->value . ' ' . $this->title) ?></title>
	<?php $this->head() ?>

</head>
<body style=" background: #ffffff;" class="markaua-font">
<script>
	function buttonAction(id) {
		document.getElementById(id).disabled = true;
		setTimeout(function () {
			document.getElementById(id).disabled = false;
		}, 3000);
	}
</script>
<?php $this->beginBody() ?>
<div class="navbar navbar" role="navigation" style="background-color: #ffffff;">
	<div class="container-fluid">
		<table class="table" border="00">
			<tr>
				<td width="33%" align="center">
					<h3 style="font-size: 2.2em;"><?= isset(Config::getConfig('head', 'phone_number')->value) ? Config::getConfig('head', 'phone_number')->value : '+38096 794 09 49' ?></h3>
					<h5><a style="color: #1a1a1a;" ><?= isset(Config::getConfig('head', 'locations')->value) ? Config::getConfig('head', 'locations')->value : '' ?></a><label>
							<button class="btn-link glyphicon glyphicon-map-marker" data-toggle="modal"
									data-target="#map">
								<small>мапа</small>
							</button>
						</label></h5>
				</td>
				<td width="33%" align="center">
					<center><a href="http://markaua.com.ua/"><img alt="MarKaUa" width="220px"
																  src="/images/markalogo.png">
					</center>
					</a><p style="font-size: 1.2em;" class="text-center">Lounge Store</p>
				</td>
				<td width="33%" align="left" style="padding-left: 5%;">
					<small class="text-uppercase">
						<h5><img src="/images/facebook_icon.png">
							<a style="color: #1a1a1a;" href="https://www.facebook.com/LoungeStore.MarKaUA"> Lounge Store
								MarKaUA</a></h5>
					</small>
					<small class="text-uppercase">
						<h5><img src="/images/vk_icon.png">
							<a style="color: #1a1a1a;" href="http://vk.com/markaua"> MarKaUA</a></h5>
					</small>
					<small class="text-uppercase">
						<h5><img src="/images/instagram_icon.png">
							<a style="color: #1a1a1a;" href="https://instagram.com/markaua/"> @MarKaUA</a></h5>
					</small>
				</td>
			</tr>
		</table>
	</div>
	<div class="container-fluid" style="background-color: #1a1a1a; margin-top: -30px; padding-top: 3px;"></div>
</div>
<div class="container-fluid" style="z-index: 5; margin-top: -18px;">
	<div style="width: 100%; height: 26px; z-index: 5;">
		<div style="display: table;
    margin: 0 auto;">
			<ul class="nav navbar-nav">
				<?php
					$getGenus = Genus::find()->orderBy('id')->all(); ?>
				<?php foreach ($getGenus as $genus): ?>
					<?php if (\app\module\admin\models\Product::find()->where(['genus_id' => $genus->id])->count() > 0): ?>
						<li class="dropdown" style="font-size: 1.2em;">
							<a style="color: #1a1a1a;" href="#"
							   class="dropdown-toggle text-uppercase"
							   data-toggle="dropdown"
							   role="button" aria-haspopup="true"
							   aria-expanded="false">
								<?= Html::encode($genus->genus); ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" style="font-size: 1.1em;">
								<?php $getTypes = Types::find()->where(['genus_id' => $genus->id])->orderBy('id')->all(); ?>
								<?php foreach ($getTypes as $types): ?>
									<?php if (\app\module\admin\models\Product::find()->where(['type_id' => $types->id, 'public' => 1])->count() > 0): ?>
										<li><a href="<?=
												Url::to('/' . $genus->genus . '/index?type=' . $types->id) ?>">
												<?= Html::encode($types->type) ?>
											</a>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
				<li role="presentation" style="font-size: 1.2em;"><a style="color: #1a1a1a;"
																	 href="<?= Url::toRoute('/brands/index') ?>">BRANDS</a>
				<li role="presentation" style="font-size: 1.2em;"><a style="color: #1a1a1a;"
																	 href="<?= Url::toRoute('/all/sale') ?>">SALE</a>
				<li role="presentation"><?= (Yii::$app->user->getRole() == 'admin' ?
						Html::a('<strong><small><span class="glyphicon glyphicon-user"></span></small> ' .
							Yii::$app->user->getName() . '</strong> <span class="badge">' . Order::find()->where(['status' => 1])->count() . '</span>', Url::to('/admin')) : Html::encode('')) ?></li>
				<li role="presentation" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
					<?= (Yii::$app->user->isGuest ? '' /*Html::a(
                        '<small><span class="glyphicon glyphicon-user"></span></small> Вхід',
                        Url::to('/login')
                    )*/ : Html::a('Вихід',
						Url::to('/logout'), ['data-method' => 'post']))
					?>
			</ul>
		</div>
	</div>

	<div align="right" style="position: fixed; margin-right: -2%; top: 126px;
    right: 0; z-index: 10000; padding-right: 5%; padding-bottom: 13px; padding-left: 13px; padding-top: 13px; background-color: rgba(255,255,255,.7);"
		 class="img-rounded">
		<a class="img-rounded" style="right: 0;" href="<?= Url::to('/cart/view') ?>"><img width="50px"
																						  style="right: 0; padding-top: 0px;"
																						  src="/images/markapic.png"><span
				class="badge">
                        <?php if (!empty($_SESSION['count'])) {
							echo array_sum($_SESSION['count']);
						} else {
							echo 0;
						} ?></span></a>
	</div>

	<div class="modal fade bs-example-modal-lg" tabindex="-1" id="map" role="dialog"
		 aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<iframe
					src="<?= isset(Config::getConfig('head', 'google_map_location')->value) ? Config::getConfig('head', 'google_map_location')->value : '' ?>"
					width="100%" height="500px" frameborder="0" style="border:0; padding-top:30px;"
					allowfullscreen></iframe>
			</div>
		</div>
	</div>

	<div class="wrap" style="width: 100%; padding-left: 0; padding-right: 0;">
		<div class="container" style="width: 100%; padding-left: 2; padding-right: 2;">
			<?= Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
			<?= $content ?>
		</div>
	</div>

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
