<script>
    function actionMinCost() {
        document.getElementById('minCost').setAttribute('max', document.getElementById('maxCost').value);
        document.getElementById('minCostLabel').value = document.getElementById('minCost').value;
    }
    function actionMaxCost() {
        document.getElementById('maxCost').setAttribute('min', document.getElementById('minCost').value);
        document.getElementById('maxCostLabel').value = document.getElementById('maxCost').value;
    }
    function actionMinLabelCost() {
        if (document.getElementById('minCostLabel').value > document.getElementById('maxCostLabel').value){
            document.getElementById('minCost').setAttribute('value',document.getElementById('maxCost').value);
        }else {}
        document.getElementById('minCost').setAttribute('value',document.getElementById('minCostLabel').value);
        document.getElementById('minCost').setAttribute('max', document.getElementById('maxCost').value);
    }
    function actionMaxLabelCost() {
        if (document.getElementById('minCostLabel').value > document.getElementById('maxCostLabel').value){
            document.getElementById('maxCost').setAttribute('value',document.getElementById('minCost').value);
        }else {}
        document.getElementById('maxCost').setAttribute('value',document.getElementById('maxCostLabel').value);
        document.getElementById('maxCost').setAttribute('min', document.getElementById('minCost').value);
    }
</script>
<?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\LinkPager;
    use app\module\admin\models\Images;
    use app\module\admin\models\Sizesofproduct;
    use yii\helpers\ArrayHelper;
    use app\models\Product;
    use app\module\admin\models\Genus;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $searchModel app\models\WomanSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = isset($genus) ? strtoupper($genus->genus) : 'Всі';
    $this->params['breadcrumbs'][] = $this->title;
?>
<center><?= LinkPager::widget(['pagination' => $pagination]) ?></center>

<div class="product-index">
    <div class="row">
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <form id="filter">
                            <ul class="list-unstyled" style="padding-left: 4%;">

                                <?php if (empty($_GET['type'])) { $_GET['type'] = NULL; } ?>
                                <?php foreach ($itemList as $item): ?>
                                    <li>
                                        <input onclick="this.form.submit()" type="checkbox"
                                               value="<?= Html::encode($item->type->id); ?>"
                                               name="type[<?= Html::encode($item->type->type); ?>]"
                                            <?= Html::encode(isset($filter_type[$item->type->type]) ? 'checked' : '');  ?>>
                                        <label><?= Html::encode($item->type->type); ?>
                                            <small>
                                                <?/*= Html::encode(Product::getCountByBrand($item->type_id, $_GET['brand'])); */?>
                                            </small>
                                        </label>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                            <!--<input type="hidden" name="brand" value="<?/*= Html::encode(isset($_GET['brand']) ? $_GET['brand'] : NULL); */?>">-->
                    </div>
                </div>
            </div>




            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <small><span class="glyphicon glyphicon-filter"></span></small>
                        Бренд
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                            <ul class="list-unstyled" style="padding-left: 4%;">


                                <?php foreach ($brandList as $brands): ?>
                                    <li>
                                        <input onclick="this.form.submit()" type="checkbox"
                                               value="<?= Html::encode($brands->brand->id); ?>"
                                               name="brand[<?= Html::encode($brands->brand->brand); ?>]"
                                            <?= Html::encode(isset($filter_brand[$brands->brand->brand]) ? 'checked' : '');  ?>>
                                        <label class="text-uppercase"><?= Html::encode($brands->brand->brand); ?></label>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                       <!-- <input type="hidden" name="type" value="<?/*= Html::encode(isset($_GET['type']) ? $_GET['type'] : NULL); */?>">
-->
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <small><span class="glyphicon glyphicon-filter"></span></small>
                        Цiна
                    </h3>
                </div>
                <div class="panel-body" align="center">
                    <div class="input-group">
                        <span class="input-group-addon">Вiд: </span>
                        <input onchange="actionMinLabelCost();" name="cost[min]" value="<?php echo isset($filter_cost['min']) ? $filter_cost['min'] : $mincost; ?>"
                               type="text"  id="minCostLabel"  class="form-control text-center" style="color:#d9534f;">
                        <span style="background-color: white;" class="input-group-addon">Грн.</span>
                    </div>
                    <input style=" border-radius: 20px;" role="progressbar" onchange="actionMinCost();"
                           type="range" min="<?php echo $mincost; ?>" max="<?php echo isset($filter_cost['max']) ? $filter_cost['max'] : $maxcost; ?>" step="1"
                           value="<?php echo isset($filter_cost['min']) ? $filter_cost['min'] : $mincost; ?>" id="minCost">
                    </br>
                    <div class="input-group">
                        <span class="input-group-addon">До: </span>
                        <input onchange="actionMaxLabelCost();" name="cost[max]" value="<?php echo isset($filter_cost['max']) ? $filter_cost['max'] : $maxcost; ?>"
                               type="text" id="maxCostLabel" class="form-control text-center"
                               style="color:#d9534f; ">
                        <span style="background-color: white;" class="input-group-addon">Грн.</span>
                    </div>
                    <input style=" border-radius: 20px;" role="progressbar" onchange="actionMaxCost();"
                           type="range" min="<?php echo isset($filter_cost['min']) ? $filter_cost['min'] : $mincost; ?>"
                           max="<?php echo $maxcost; ?>" step="1" value="<?php echo isset($filter_cost['max']) ? $filter_cost['max'] : $maxcost; ?>" id="maxCost">
                    <button class="btn btn-default" onclick="this.form.submit()">Ok</button>
                    </form>

                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body" align="center">
                    <a class="btn btn-default" href="<?= Url::toRoute('/all/sale') ?>">Очистити фільтри</a>
                </div>
            </div>

        </div>

        <div class="col-md-9">

            <div class="row">

                <?php if (count($products) < 1): ?>
<div align="center">
                    <h3>Наразі товари зі знижкою відсутні.</h3>
</div>
                <?php else: ?>

                <?php foreach ($products as $product): ?>
                    <div class="col-xs-6 col-md-4" style="padding-left: 1px; padding-right: 1px;">
                        <div>
                            <?php foreach (Images::find()->
                            select('color_id')->
                            where(['product_id' => $product->product_id])->limit(1)->all() as $color): ?>

                            <?php foreach (Sizesofproduct::find()->
                            select('size_id')->
                            where(['product_id' => $product->product_id])->andWhere(['color_id' => $color->color_id])->limit(1)->all() as $size): ?>

                            <a class="thumbnail" href="view?id=<?= Html::encode($product->product_id); ?>&color=<?= Html::encode($color->color_id); ?>&size=<?= Html::encode($size->size_id); ?>">
                                <img style="height: 400px;" src="<?php echo Url::base() . '/images/' . Html::encode(ArrayHelper::getValue(Images::find()->
                                    select('img_file')->
                                    where(['product_id' => $product->product_id])->
                                    one(), 'img_file')); ?>"
                                     alt="<?= Html::encode(Yii::$app->name . ': ' . $product->genus->genus . ' ' . $product->name->name . ' ' . $product->brand->brand); ?>">
                            </a>

                            <div class="caption">
                                <a data-toggle="tooltip" data-placement="top" title=""
                                   href="view?id=<?= Html::encode($product->product_id); ?>&color=<?= Html::encode($color->color_id); ?>&size=<?= Html::encode($size->size_id); ?>"
                                   class="text-muted"><h5 class="text-uppercase text-center">
                                        <?php endforeach ?>
                                        <?php endforeach ?>
                                        <?= Html::encode($product->name->name); ?>

                                        <?= Html::encode($product->brand->brand); ?>
                                    </h5></a>

                                <p></p>
                                <?php if ($product->sale > 0): ?>
                                    <strong>
                                        <p class="text-center"><?= Html::encode($product->sale); ?> грн. <s>
                                                <small style="color: #959595;"><?= Html::encode($product->cost); ?>
                                                    грн.
                                                </small>
                                            </s></p>
                                    </strong>
                                <?php else: ?>
                                    <strong><p class="text-center"><?= Html::encode($product->cost); ?> грн.</p>
                                    </strong>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php endif; ?>

            </div>
            <center><?= LinkPager::widget(['pagination' => $pagination]) ?></center>
        </div>
    </div>
</div>


