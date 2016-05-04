<?php
	/**
	 * Created by PhpStorm.
	 * User: art
	 * Date: 2/22/2016
	 * Time: 10:26 PM
	 */

	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\grid\GridView;
	use app\module\admin\models\Order;
	use app\module\admin\models\Purchases;

	$this->title = 'Statistic';
	$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
	$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<div class="col-md-2"><?php include(__DIR__ . ('/../default/menu.php')); ?></div>
	<div class="col-md-10">
		<p><h2>Статистика:</h2></p>
		<?php foreach (Order::find()->orderBy('date')->all() as $date_orders): ?>
			<?php $dates['date'][] = substr($date_orders->date, 0, 4); ?>
		<?php endforeach ?>
		<?php foreach (array_unique($dates['date']) as $orders) {
			foreach (Order::find()->where(['like', 'date', $orders])->all() as $item_id) {
				//$i_id[] = ->id;
				$ffddf = Purchases::find()->where(['order_id' => $item_id->id]);
				$ssmf[] = $ffddf->count();
				$summa[] = array_sum($ssmf);
			}
		}
			$max = max($summa);
		?>
		<?php foreach(array_unique($dates['date']) as $orders): ?>
		<p><h3><?= $orders ?></h3></p>
		<table class="table">
			<tr>
			<?php for($i = 1; $i <= 12; $i++): ?>
			<td align="center">
			<?php $count = 0; foreach(Order::find()->where(['like', 'date', $orders . '-' . str_pad($i, 2, '0', STR_PAD_LEFT)])->all() as $item_id): ?>
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
		<?php endforeach ?>
	</div>
</div>
