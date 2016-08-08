
<?php

	use yii\helpers\Html;
	use \yii\helpers\Url;
use app\models\Woman;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\module\admin\models\Images;
use app\module\admin\models\Sizesofproduct;
use app\module\admin\models\Order;
use app\module\admin\models\Product;
	session_start();
    if( isset($_GET['order_number'])) {
        $_SESSION['number'] = $_GET['order_number'];
    }

?>
<?php if(isset($_SESSION['number'])): ?>
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong> Дякуємо за замовлення! <strong> Ваш номер замовлення: <?php echo $_SESSION['number'] ?>. Наш менеджер зв'яжеться з Вами найближчим часом
</div>
    <?php
    //$order = Order::find()->where(['id' => $_SESSION['number']])->one();
    //$message = 'Ваш номер замовлення: ' . $order->id. '. Наш менеджер зв`яжеться з Вами найближчим часом';
    //$orderModel = new Order();
    //$orderModel->sendEmail($order->email, 'Дякуємо за замовлення!', $message);
    ?>
<?php endif ?>

<h4 class="modal-title text-center" xmlns="http://www.w3.org/1999/html">Обрані речі:</h4> </br>
<?php
	//print_r($_SESSION['count']);
	if(isset($_SESSION['count']) and array_sum($_SESSION['count']) > 0 ): ?>

           <table class="table table-hover">
<?php foreach($_SESSION['uid'] as $item): ?>

<?php if ($_SESSION['count'][$item] == 0): ?>
<?php else: ?>
<tr>
<td width="15%"><div class="crop img-rounded" ><a href="<?php
$url = Product::find()->where(['product_id' => $_SESSION['product_id'][$item]])->one();
echo Url::toRoute('/' . $url->genus->genus . '/view?id=' .
 $_SESSION['product_id'][$item] . '&color=' . $_SESSION['color_id'][$item] . '&size=' . $_SESSION['size_id'][$item]);
?>"><img width="100px" class="img-rounded" src="<?php

 echo Url::base() . '/images/' . ArrayHelper::getValue(Images::find()->
 select('img_file')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 andWhere(['color_id' => $_SESSION['color_id'][$item]])->
 one(), 'img_file');
 ?>"></a></div></td>
<td><a href="<?php echo Url::toRoute('/' . $url->genus->genus . '/view?id=' .
 $_SESSION['product_id'][$item] . '&color=' . $_SESSION['color_id'][$item] . '&size=' . $_SESSION['size_id'][$item]);
?>"><?php
 echo ArrayHelper::getValue(Woman::find()->
 select('name_id')->
 where(['product_id' => $_SESSION['product_id'][$item]])->
 one()->name, 'name');
 ?></a></td>
<td><a href="<?php
$getBrand = Product::find()->select('brand_id')->where(['product_id' => $_SESSION['product_id'][$item]])->one();
 echo Url::toRoute('/' . $url->genus->genus . '/index?brand%5B' . $getBrand->brand->brand  . '%5D=' . $getBrand->brand->id);
?>"><?php
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
 <td><center><a href="<?= Url::toRoute('/cart/delcartitem?uid=' .
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

            </table>

            <div class="row">
  <div class="col-md-4"><h4><button type="button" class="cancel-button-large-wide nav-left " onclick="window.location.href='<?= Url::toRoute('/cart/delcartitem?delall=1') ?>'">Очистити кошик</button>
</h4></div>
  <div class="col-md-4"></div>
  <div class="col-md-4">

     <?php if(isset($_SESSION['number'])): ?>
  <h4 style="padding-right: 20px;" class="text-right nav-right">Виконано замовлення на сумму: <?php echo array_sum($sum); ?> грн.</h4>
  <h4 style="padding-right: 20px;" class="text-right nav-right">Номер замовлення: <?php echo $_SESSION['number'] ?></h4>
  <?php else: ?>
  <h4 style="padding-right: 20px;" class="text-right nav-right">Всього: <?php echo array_sum($sum); ?> грн.<span>
                <button type="button" class="order-button-large-wide nav-right" data-toggle="modal" data-target="#order">Замовити</span></h4>
<?php endif ?>
</div>
</div>

                <?php else: ?>
             <center><h4>Кошик порожній</h4></center></br>
                <?php endif ?>
<div class="row">
    <div class="col-md-4">
        </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4" align="right">
<h4><button type="button" style="margin-right: 20px;" class="nap-wishlist-button" onclick="window.location.href='<?= Url::previous(); ?>'">Продовжити покупки</button>
</h4></div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="order" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg">
             <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">Оформлення покупки</h4>
                    </div>
                        <div class="modal-body">
                            <div class="order-form">
                                <div class="order-create">
                                <h1><?= Html::encode($this->title) ?></h1>
                                <?= $this->render('_form', [
                                'model' => $model,
                                ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
             </div>
    </div>
</div>