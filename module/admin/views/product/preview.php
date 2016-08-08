<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\helpers\ArrayHelper;
	use app\module\admin\models\Images;
	/**
	 * Created by PhpStorm.
	 * User: art
	 * Date: 8/3/2016
	 * Time: 08:39 AM
	 */

?>
</br>
<div class="row">
	<?php foreach ($products as $product): ?>
		<div style="padding-left: 1px; padding-right: 1px;">
			<a href="<?php echo Url::home() . '/woman/view?id=' . $product->product_id . '&color=' . $product->color->color_id .
				'&size=' . $product->size->size_id; ?>" class="thumbnail">
				<img alt="<?= Html::encode($product->brand->brand); ?>" src="<?= 'http://markaua.com.ua/images/' . ArrayHelper::getValue(Images::find()->
				select('img_file')->
				where(['product_id' => $product->product_id])->
				one(), 'img_file'); ?>" style="height: 300px; width: inherit;">
				<p class="text-uppercase text-center"><?= Html::encode($product->name->name); ?>
					<?= Html::encode($product->brand->brand); ?></p>
				<?php if ($product->sale > 0): ?>
					<strong>
						<p class="text-center"><?= Html::encode($product->sale); ?> грн. <s>
								<small style="color: #959595;"><?= Html::encode($product->cost); ?> грн.</small>
							</s>
						</p>
					</strong>
				<?php else: ?>
					<strong><p class="text-center"><?= Html::encode($product->cost); ?> грн.</p></strong>
				<?php endif ?>
			</a>
		</div>
	<?php endforeach ?>
</div>
