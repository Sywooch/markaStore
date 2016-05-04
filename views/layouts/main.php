<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\module\admin\models\Genus;
use app\module\admin\models\Types;
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


    if (Yii::$app->user->getRole() !== 'admin') {
    if (stristr(Yii::$app->request->getAbsoluteUrl(), 'admin') === false) {
    }else{
        echo 'lol';
     Yii::$app->response->redirect(Url::to('/'));
    }

    }

   // session_start();
/*$_SESSION = NULL;
    $_SESSION = [];*/


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!--<script src="content/bootstrapJS/jquery-2.1.1.min.js" type="text/javascript"></script>-->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<!--    <script type="text/javascript">
        $(window).load(function(){
            $('#basket').modal('show');
        });
    </script>-->

</head>
<body style=" background: #ffffff;" class="markaua-font">
<?php $this->beginBody() ?>
<div class="navbar navbar" role="navigation" style="background-color: #ffffff;">
    <div class="container-fluid">
        <table class="table" border="00">
            <tr>
                <td width="33%" align="center">
                    <h3 style="font-size: 2.2em;">+38096 794 09 49</h3>
                    <h5><a style="color: #1a1a1a;" href="#">м.Київ, вул. Кіквідзе 7/11</a><label>
                            <button class="btn-link glyphicon glyphicon-map-marker" data-toggle="modal"
                                    data-target="#map">
                                <small>мапа</small>
                            </button>
                        </label></h5>
                </td>
                <td width="33%" align="center">
                    <center><a href="http://markaua.com.ua/"><img alt="MarKaUa" width="220px"
                               src="http://artsemenishch.inf.ua/markalogo3.png">
                    </center>
                    </a><p style="font-size: 1.2em;" class="text-center">Lounge Store</p>
                </td>
                <td width="33%" align="left" style="padding-left: 5%;">
                    <small class="text-uppercase">
                        <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/facebook2-20.png">
                            <a style="color: #1a1a1a;" href="https://www.facebook.com/LoungeStore.MarKaUA"> Lounge Store
                                MarKaUA</a></h5>
                    </small>
                    <small class="text-uppercase">
                        <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/vk-20.png">
                            <a style="color: #1a1a1a;" href="http://vk.com/markaua"> MarKaUA</a></h5>
                    </small>
                    <small class="text-uppercase">
                        <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/707752-instagram-20.png">
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
                    <?php if(\app\module\admin\models\Product::find()->where(['genus_id' => $genus->id ])->count() > 0): ?>
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
                            <?php if(\app\module\admin\models\Product::find()->where(['type_id' => $types->id, 'public' => 1])->count() > 0): ?>
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
                                           href="<?= Url::to('brands/index') ?>">BRANDS</a>
                <li role="presentation" style="font-size: 1.2em;"><a style="color: #1a1a1a;" href="#">SALE</a>
                <li role="presentation"><?= (Yii::$app->user->getRole() == 'admin' ?
                        Html::a('<strong><small><span class="glyphicon glyphicon-user"></span></small> ' .
                            Yii::$app->user->getName() . '</strong>', Url::to('/admin')) : Html::encode('')) ?></li>
                <li role="presentation" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                    <?= (Yii::$app->user->isGuest ? Html::a(
                        '<small><span class="glyphicon glyphicon-user"></span></small> Вхід',
                        Url::to('/login')
                    ) : Html::a('Вихід',
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
        src="http://artsemenishch.inf.ua/markapic.png"><span class="badge">
                        <?php if (!empty($_SESSION['count'])) {
                            echo array_sum($_SESSION['count']);
                        } else {
                            echo 0;
                        } ?></span></a>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="map" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2542.355784804457!2d30.54957000000001!3d50.415842499999975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf69164f4aab%3A0x3f890cc1384f3c6a!2zNy8xMSwg0LLRg9C7LiDQmtGW0LrQstGW0LTQt9C1LCA3LzExLCDQmtC40ZfQsg!5e0!3m2!1sru!2sua!4v1440271655914" width="100%" height="500px" frameborder="0" style="border:0; padding-top:30px;" allowfullscreen></iframe>
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

<!--<div class="wrap">
    <?php
/*    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    */?>

    <div class="container">
        <?/*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) */?>
        <?/*= $content */?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?/*= date('Y') */?></p>

        <p class="pull-right"><?/*= Yii::powered() */?></p>
    </div>
</footer>-->




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
