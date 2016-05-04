<?php

	/* @var $this yii\web\View */
	use app\module\admin\models\Images;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\helpers\ArrayHelper;
	use app\models\Woman;
	use \app\module\admin\models\Slidebar;

	$this->title = 'Lounge Store MarKaUa';
?>

<div align="center">
	<div id="carousel-example-generic"  style="margin-left: -2%; margin-right: -2%; margin-top: -2%;" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php $item = -1;
				foreach (Slidebar::find()->where(['display' => 1])->
			orderBy(['id' => SORT_DESC])->all() as $slide): ?>
			<li data-target="#carousel-example-generic" data-slide-to="<?php
				$item = $item + 1;
				echo $item;
				if ($item === 0) {
					echo '" class="active"></li>';
				} else {
					echo '"></li>';
				} ?>
        <?php endforeach ?>
    </ol>
			<div class="carousel-inner" role="listbox">
			<?php $item = -1;
				foreach (Slidebar::find()->where(['display' => 1])->orderBy(['id' => SORT_DESC])->all() as $slide): ?>
					<div style="width: 100%;" class=<?php $item = $item + 1;
						if ($item === 0): ?>"item active"><?php else: ?>"item"><?php endif ?>
						<div style="width: 100%;
							background: url(<?php echo Url::base() . '/images/' . $slide->image_url; ?>) 100% no-repeat;
							background-size: 100%; height: 500px; margin-top: -5%;" >
							<div class="carousel-caption">
								<?= html_entity_decode($slide->description); ?>
							</div>
						</div>

					</div>
				<?php endforeach ?>
	</div>

</div>
</div>
</br>
<div>
	<center><h1>Новинки</h1></center>
	</br>



	<div class="row">
		<?php foreach (Woman::find()->
		where(['public' => 1])->orderBy(['product_id' => SORT_DESC])->limit(4)->all() as $product): ?>
		<div class="col-xs-6 col-md-3" style="padding-left: 1px; padding-right: 1px;">
			<a href="<?php echo Url::home() . '/woman/view?id=' . $product->product_id . '&color=' . $product->color->color_id .
						'&size=' . $product->size->size_id; ?>" class="thumbnail">
	<img alt="<?= Html::encode($product->brand->brand); ?>" src="<?= Url::base() . '/images/' . ArrayHelper::getValue(Images::find()->
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

</div>
</div>
</div>

<div class="row" style="width: 100%;" align="center">
	<?php foreach(\app\module\admin\models\Post::find()->all() as $model): ?>
    <div class="col-md-6" style="padding-bottom: 3%;">
<div style="width: 88%; background-color: #FAFAFA; padding: 2%;">
    <div><h3><?php echo $model->title; ?></h3></div>
</br>
        <?php if($model->category_id == 1): ?>
                <table style=" width: 100%;">
                    <tr>
                        <td align="center">
                            <div style="padding: 5%;">
                                <?php echo html_entity_decode($model->content1); ?>
                            </div>
                        </td>
                        <td align="center">
                            <div style="padding: 5%;">
                                <?php echo html_entity_decode($model->content4); ?>
                            </div>
                        </td>
                        <td align="center">
                            <div style="padding: 5%;">
                                <?php echo html_entity_decode($model->content3); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="3">
                            <div style="padding: 5%;">
                                <?php echo html_entity_decode($model->content2); ?>
                            </div>
                        </td>
                    </tr>
                </table>
     <?php endif; ?>
    <?php if($model->category_id == 2): ?>
            <table style="width: 100%;">
                <tr>
                    <td align="center">
                        <div style="padding: 5%;">
                            <?php echo html_entity_decode($model->content1); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <div style="padding: 5%;">
                            <?php echo html_entity_decode($model->content2); ?>
                        </div>
                    </td>
                </tr>
            </table>
    <?php endif; ?>
     <?php if($model->category_id == 3): ?>
            <table style="width: 100%;">
                <tr>
                    <td align="center" width="50%">
                        <div style="padding: 5%;">
                            <?php echo html_entity_decode($model->content1); ?>
                        </div>
                    </td>
                    <td align="center" width="50%">
                        <div style="padding: 5%;">
                            <?php echo html_entity_decode($model->content2); ?>
                        </div>
                    </td>
                </tr>
            </table>
    <?php endif; ?>
        </div>
</div>

<?php endforeach; ?>
</div>
