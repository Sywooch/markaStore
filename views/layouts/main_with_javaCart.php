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

    session_start();
/*$_SESSION = NULL;
    $_SESSION = [];*/
    Url::remember();
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<div class="row" style="padding-top: 10px; background-color: #f5f5f5; width: 101%; z-index: 4;">
    <div class="col-xs-4 col-md-4" style="padding-left: 100px;">
        <h3>+38096 794 09 49</h3>
        <h5><a  style="color: #1a1a1a;" href="#">м.Київ, вул. Кіквідзе 7/11</a><label><button class="btn-link glyphicon glyphicon-map-marker" data-toggle="modal" data-target="#map"><small>мапа</small></button></label></h5>
    </div>
    <div class="col-xs-4 col-md-4">

            <center><a href="http://markaua.naverex.net/index.php"><img alt="MarKaUa" width="220px" src="http://artsemenishch.inf.ua/markalogo3.png"></center>
        </a><p class="text-center">Lounge Store</p>

            </div>
    <div class="col-xs-4 col-md-4" style="padding-left: 100px;">
        <small class="text-uppercase">
                <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/facebook2-20.png">
                <a  style="color: #1a1a1a;" href="https://www.facebook.com/LoungeStore.MarKaUA"> Lounge Store MarKaUA</a></h5>
        </small>
        <small class="text-uppercase">
        <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/vk-20.png">
            <a  style="color: #1a1a1a;" href="http://vk.com/markaua"> MarKaUA</a></h5>
        </small>
        <small class="text-uppercase">
        <h5><img src="https://cdn1.iconfinder.com/data/icons/capsocial/500/707752-instagram-20.png">
            <a  style="color: #1a1a1a;" href="https://instagram.com/markaua/"> @MarKaUA</a></h5>
        </small>
    </div>
</div>
<div style="background-color: #1a1a1a; padding-top: 3px;"></div>

<div class="container" style="width: 100%;  z-index: 5;">
    <div style="display: table;
    margin: 0 auto;">
        <ul class="nav navbar-nav">

            <?php

                $getGenus = Genus::find()->orderBy('id')->all(); ?>
            <?php foreach ($getGenus as $genus): ?>
                <?php echo '<li class="dropdown"><a  style="color: #1a1a1a;" href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'; ?>
                <?= Html::encode($genus->genus); ?>
                <?php echo '<span class="caret"></span></a> <ul class="dropdown-menu">'; ?>
                <?php $getTypes = Types::find()->where(['genus_id' => $genus->id])->orderBy('id')->all(); ?>
                <?php foreach($getTypes as $types ): ?>
                    <li><a href="<?= Url::toRoute('/woman/index?type=' . $types->id) ?>"><?= Html::encode($types->type) ?></a></li>
                <?php endforeach; ?>
                <?php echo ' </ul></li>'; ?>

            <?php endforeach; ?>

            <!--<li class="dropdown">
                <a  style="color: #1a1a1a;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">WOMAN <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php /*$wcats = \app\module\admin\models\Types::find()->orderBy('id')->all(); */?>
                    <?php /*foreach($wcats as $wcat ): */?>
                        <li><a href="<?/*= Url::toRoute('/woman/index?type=' . $wcat->id) */?>"><?/*= Html::encode($wcat->type) */?></a></li>
                    <?php /*endforeach; */?>
                </ul>
            </li>
            <li role="presentation"><a  style="color: #1a1a1a;" href="#">MAN</a>
            <li role="presentation"><a  style="color: #1a1a1a;" href="#">KIDS</a>-->

            <li role="presentation"><a  style="color: #1a1a1a;" href="<?= Url::toRoute('brands/index') ?>">BRANDS</a>
            <li role="presentation"><a  style="color: #1a1a1a;" href="#">SALE</a>
            <li role="presentation" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><a href="
            <?= Url::toRoute('/admin/') ?>"><strong style="color: #5cb85c;"><small><span class="glyphicon glyphicon-user"></span></small> SIGN IN</strong></a>

        </ul>
        <div align="right" style="position: absolute;
    right: 5%;">
            <ul class="nav navbar-nav navbar-right" >
                <li style="padding-top: 0px;" data-toggle="modal" data-target="#basket" class="nav right"><a href="#"><img width="40px" style="padding-top: 0px;" src="http://artsemenishch.inf.ua/markapic.png"><span class="badge">
                        <?php if(!empty($_SESSION['count'])){
                            echo array_sum($_SESSION['count']);
                        }else {
                            echo 0;
                        }  ?></span></a></li>
            </ul>
        </div>
    </div>
</div>

<!-----------Cart-------------->


<div class="modal fade" id="basket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Обрані речі:</h4>
            </div>
            <div class="modal-body">

<?php if(isset($_SESSION['count']) and array_sum($_SESSION['count']) > 0 ): ?>

           <table class="table table-hover">
<?php foreach($_SESSION['uid'] as $item): ?>

<?php if ($_SESSION['count'][$item] == 0): ?>
<?php else: ?>
<tr>
<td width="15%"><div class="crop img-rounded" ><img width="100px" class="img-rounded" src="<?php

 echo ArrayHelper::getValue(Images::find()->
 select('img_file')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 andWhere(['color_id' => $_SESSION['color_id'][$item]])->
 one(), 'img_file');
 ?>"></div></td>
<td><a href="#"><?php
 echo ArrayHelper::getValue(Woman::find()->
 select('name_id')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one()->name, 'name');
 ?></a></td>
<td><a href="#"><?php
 echo ArrayHelper::getValue(Woman::find()->
 select('brand_id')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one()->brand, 'brand');
 ?></a></td>
 <td><span class="badge"><?php
 echo ArrayHelper::getValue(Sizesofproduct::find()->
 select('size_id')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 andWhere(['size_id' => $_SESSION['size_id'][$item]])->
 one()->size, 'size');
 ?></span></td>
 <td><button class="btn" style="background-color: #<?=
 ArrayHelper::getValue(Sizesofproduct::find()->
 select('color_id')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 andWhere(['color_id' => $_SESSION['color_id'][$item]])->
 one()->color, 'color')
 ?>"></button></td>
<td><span class="badge"> <?= $_SESSION['count'][$item]; ?>шт</span></td>
<td><?php
$getCost = ArrayHelper::getValue(Woman::find()->
 select('sale')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one(), 'sale');
if ($getCost == 0){
    echo ArrayHelper::getValue(Woman::find()->
 select('cost')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one(), 'cost')  * $_SESSION['count'][$item];
 $sum[] = ArrayHelper::getValue(Woman::find()->
 select('cost')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one(), 'cost')  * $_SESSION['count'][$item];
}else {
    echo $getCost * $_SESSION['count'][$item];
$sum[] = $getCost * $_SESSION['count'][$item];
}
 ?>грн.</td>
 <td><center><a href="<?= Url::toRoute('/woman/delcartitem?uid=' .
$item . '&id=' .
$_SESSION['product_id'][$item] . '&color=' .
$_SESSION['color_id'][$item] . '&size=' .
$_SESSION['size_id'][$item]) ?>" class="glyphicon glyphicon-remove"></a></center>
</td>
</tr>
 <!-- <?/*= $item; */?>
    <?/*= $_SESSION['product_id'][$item]; */?>
    <?/*= $_SESSION['color_id'][$item]; */?>
    --><?/*= $_SESSION['size_id'][$item]; */?>

<?php endif ?>
                <?php endforeach ?>

               <!-- <tr>
                    <td><input type="checkbox" value="" checked></td>
                    <td width="15%"><img  class="img-rounded" width="80%" src="https://scontent.xx.fbcdn.net/hphotos-xaf1/v/t1.0-9/11350571_866516090082478_2408206140319447393_n.jpg?oh=fccfeefe3296ecb1f572a87aff6981d9&oe=566837F3" alt="Сукня"></td>
                    <td><a href="#">Сукня</a></td>
                    <td><a href="#">БРЕНД</a></td>
                    <td><span class="badge"> 2шт</span></td>
                    <td>2400грн.</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="" checked></td>
                    <td width="15%"><img  class="img-rounded" width="80%" src="https://scontent.xx.fbcdn.net/hphotos-xta1/v/t1.0-9/11218498_866218643445556_5527491933957587027_n.jpg?oh=6e84f9d5274b3de7f83eb4f16f8b7378&oe=56359024" alt="Сукня"></td>
                    <td><a href="#">Спiдниця</a></td>
                    <td><a href="#">БРЕНД</a></td>
                    <td><span class="badge"> 1шт</span></td>
                    <td>1000грн.</td>
                </tr>
                <tr>
                    <td><input type="checkbox" value="" checked></td>
                    <td width="15%"><img  class="img-rounded" width="80%" src="https://scontent.xx.fbcdn.net/hphotos-xtf1/v/t1.0-9/11265404_864386620295425_6273150492028099264_n.jpg?oh=d02bb06cc6d124d506a56eb036a74e1f&oe=566E66A5" alt="Сукня"></td>
                    <td><a href="#">Сорочка</a></td>
                    <td><a href="#">БРЕНД</a></td>
                    <td><span class="badge"> 1шт</span></td>
                    <td>800грн.</td>
                </tr>-->
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger nav-left" onclick="window.location.href='<?= Url::toRoute('/woman/delcartitem?delall=1') ?>'">Очистити кошик</button>
           <h4 style="padding-right: 20px;" class="text-right">Всього: <?php echo array_sum($sum); ?> грн.<span>
                <button type="button" class="btn btn-success">Замовити</button></span></h4>
            </div>
                <?php else: ?>
             <center><h4>Кошик порожній</h4></center></br>
                <?php endif ?>
            </div>
        </div>
    </div>
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
