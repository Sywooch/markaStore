<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
    use app\module\admin\models\Sizesofproduct;
    use app\module\admin\models\Images;
    use app\module\admin\models\Materialproduct;
    use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Product */

$this->title = 'Товар №' . $model->product_id . ', ' . $model->name->name . ' ' . $model->brand->brand;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
        </div>
    <div class="col-md-10" >
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a('Редактировать', ['update', 'id' => $model->product_id], ['class' => 'order-button-large-wide']) ?>
        <?= Html::a('Удалить товар', ['delete', 'id' => $model->product_id], [
            'class' => 'cancel-button-large-wide',
            'data' => [
                'confirm' => 'Вы уверены что ходите уданить данный товар?',
                'method' => 'post',
            ],
        ]) ?>

        <button type="button" class="primary-button-large-wide" onclick="window.location.href='<?= Url::toRoute('/admin/sizesofproduct/create?product_id=' . $model->product_id) ?>'">Добавить связку размер / цвет товара</button>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            'name.name',
            'brand.brand',
            'genus.genus',
            'type.type',
           // 'size_id',
            //'quantity',
            'cost',
            'description:ntext',
            'date',
            'date_change',
        ],
    ]) ?>


    <?php

$sop =  Sizesofproduct::find()->select('color_id')->where(['product_id' => $model->product_id])->count();

        ?>

</div>
        <?php if($sop > 0): ?>

        <?php

        $sop =  Sizesofproduct::find()->select('color_id')->where(['product_id' => $model->product_id])->limit(1)->one();


          $_GET['color'] = $sop->color_id;

         $sop =  Sizesofproduct::find()->
        select('size_id')->
        where(['product_id' => $model->product_id])->andWhere(['color_id' => $_GET['color']])->limit(1)->one();

        $_GET['size'] = $sop->size_id;
         ?>
    </div>

    <div>

        <div class="woman-view">
            <table class="table" border="0">
                <tr>
                    <td width="60%">
                        <div class="row">

                            <?php if (!empty($color)): ?>

                                <?php foreach (Images::find()->select('img_file')->where(['product_id' => $model->product_id])->andWhere(['color_id' => $color])->all() as $img): ?>

                                    <?php
                                    $imgs = 'images/' . Html::encode($img->img_file);
                                    list($width, $height) = getimagesize($imgs); ?>
                                    <div class="col-md-<?php echo $width > $height ? '9' : '5'; ?>">
                                        <img style="padding-bottom: 5px; padding-top: 5px;" height="450px" src="<?php echo '/images/' . Html::encode($img->img_file) ?>"
                                             alt="<?php echo $model->name->name . '-' . $model->brand->brand; ?>">
                                    </div>
                                <?php endforeach; ?>

                            <?php else: ?>

                                <?php foreach (Images::find()->
                                select('img_file')->
                                where(['product_id' => $model->product_id])->
                                andWhere(['color_id' => $_GET['color']])->
                                all() as $img): ?>
                                    <?php
                                    $imgs = 'images/' . Html::encode($img->img_file);
                                    list($width, $height) = getimagesize($imgs); ?>
                                    <div class="col-md-<?php echo $width > $height ? '9' : '5'; ?>">
                                        <img style="padding-bottom: 5px; padding-top: 5px;" height="450px" src="<?echo '/images/' . Html::encode($img->img_file) ?>"
                                             alt="<?php echo $model->name->name . '-' . $model->brand->brand; ?>">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </div>
        </div>


        </td>
        <td width="40%">
            <p> <h4 class="text-uppercase"><?= Html::encode($model->name->name); ?> <small></br><?= Html::encode($model->brand->brand); ?> </small></br><small>арт. <?=
                        Html::encode(substr($model->genus->genus,0, 1 ));
                    ?><?php echo $model->product_id; ?>
                    <?php
                        if (isset($_GET['size'])): ?>
                            <?php echo '- S'.$_GET['size']; ?>
                        <?php else: ?>
                            <?php echo ''; ?>
                        <?php endif ?>- C<?php echo $_GET['color']; ?>
                </small> </h4>
            </p>
            <?php if ($model->sale > 0): ?>
                <h2><?= Html::encode($model->sale); ?> грн. </br><s style="padding-left: 5px;"><small style="color: #959595;"><?= Html::encode($model->cost); ?> грн.</small></s></h2>
            <?php else: ?>
                <h2><?= Html::encode($model->cost); ?> грн.</h2>
            <?php endif ?>
            <div class="btn-group">
                <?php foreach(Sizesofproduct::find()->
                select('size_id')->
                where(['product_id' => $model->product_id])->
                andWhere(['color_id' => $_GET['color']])->andWhere(['>', 'availability', 0])->
                orderBy('size_id')->distinct()->all() as $search ): ?>

                    <a style="
                    <?php if ($search->size_id == 0): ?>
                        width:90px;
                    <?php else: ?>
                        width:40px;
                    <?php endif ?>
                        height: 40px; border-radius: 3px;
                        transition: opacity 0.3s ease-out 0s;
                        border: 1px solid #000;
                        padding: 10px 10px;

                    <?php if ($_GET['size'] == $search->size_id): ?>
                        <?php echo 'color: #FFF;  background-color: #1a1a1a;'; ?>
                    <?php else: ?> <?php echo 'color: #1a1a1a;'; ?>
                    <?php endif ?>

                        " class="btn btn-link active" href="<?= Url::canonical(); ?>&size=<?= Url::to($search->size_id) ?>"><strong><?= Html::encode($search->size->size); ?></strong></a>
                <?php endforeach; ?>
            </div>
            </br></br>

            <div class="btn-group">
                <?php foreach(Sizesofproduct::find()->
                select(['color_id'])->
                where(['product_id' => $model->product_id])->
                distinct('color_id')->all() as $searchcolor ): ?>
                    <?php if($searchcolor->color->id > 0): ?>
                        <button type="button"
                                class="btn btn-link"
                                id="i-have-a-tooltip"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                data-description="<?= Html::encode($searchcolor->color->color_name); ?>"
                                onclick="window.location.href='view?id=<?= Html::encode($model->product_id); ?>&color=<?=
                                    Html::encode($searchcolor->color_id); ?>&size=<?php
                                    echo ArrayHelper::getValue(Sizesofproduct::find()->
                                    select('size_id')->
                                    where(['product_id' => $model->product_id])->
                                    andWhere(['color_id' => $searchcolor->color_id])->
                                    one(), 'size_id'); ?>'"
                                style="width:40px; height: 40px; border-radius: 3px;
                                    transition: opacity 0.3s ease-out 0s;
                                    border: 1px solid #000;
                                    padding: 10px 10px; background-color: #<?= Html::encode($searchcolor->color->color); ?>;">
                            <?php if($_GET['color'] == $searchcolor->color_id): ?>
                                <?php if($searchcolor->color->color == 'ffffff' or $searchcolor->color->color == 'cccccc'): ?>
                                    <span style="color: #1a1a1a" class="glyphicon glyphicon-ok"></span>
                                <?php else: ?>
                                    <span style="color: #fff" class="glyphicon glyphicon-ok"></span>
                                <?php endif ?>
                            <?php else: ?>
                            <?php endif ?>
                        </button>


                        <!--<a href="view?id=<?/*= Html::encode($model->product_id); */?>&color=<?/*= Html::encode($searchcolor->color_id); */?>&size=<?php /*echo $_GET['size']; */?>" style="width:40px; border-radius: 3px;
                    transition: opacity 0.3s ease-out 0s;
                    border: 1px solid #000;
                    padding: 10px 10px; background-color: #<?/*= Html::encode($searchcolor->color->color); */?>;" class="btn btn-link active">

                </a>-->

                    <?php endif ?>
                <?php endforeach; ?>
            </div></br></br>
            <div style="padding-right: 10%;">
                <p class="text-uppercase">
                    <?php foreach(Materialproduct::find()->
                    where(['product_id' => $model->product_id])->
                    distinct('material_id')->all() as $searchmaterial ): ?>

                        <?= Html::encode($searchmaterial->materials->material); ?> <?= Html::encode($searchmaterial->procent); ?>%

                    <?php endforeach; ?>
                </p></div>
            </br>
            <button type="button" class="nap-wishlist-button" data-toggle="modal" data-target="#myModal">
                Таблиця розмірів <span class="glyphicon glyphicon-resize-small"></span>
            </button>
            </br></br>
            <?php
                $getCount = Sizesofproduct::find()->
                select(['availability'])->
                where(['product_id' => $model->product_id, 'size_id' => $_GET['size'], 'color_id' => $_GET['color']])->one();
                if($getCount->availability < 1): ?>
                    <button style="color: #3c3c3c;" disabled="disabled" type="button" class="btn btn-link btn-lg disabled">Немає в наявності</button>
                <?php else: ?>
                    <button onclick="window.location.href='<?= Url::toRoute('#'); ?>'" type="button" class="primary-button-large-wide">Додати у кошик</button>
                <?php endif; ?>

            </br></br>
            <p>
                <?= Html::encode($model->description); ?>
            </p>

            <!-- SIZE TABLE -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Таблиця розмірів</h4>
                        </div>
                        <div class="modal-body">

                            <table class="taltable taltablecont">
                                <tr class="taltr talhide">
                                    <td class="taltd talhide">
                                        <div class="tallogo text-center">
                                            <img width="35%" src="http://artsemenishch.inf.ua/markalogo3.png"/>
                                        </div>
                                    </td>
                                    <td class="talnotd talhide">
                                    </td>
                                    <td class="taltd talhide">
                                        <div class="taltitle">
                                            Size Guide. Women
                                        </div>
                                    </td>
                                </tr>
                                <tr class="talnotr talhide">
                                    <td class="taltd talhide">
                                        <table class="taltable">
                                            <th class="taltr talth" colspan="11">
                                                TROUSERS, BERMUDAS, SHORTS, SKIRTS, MINI SKIRTS, SWIMMING COSTUMES...
                                            </th>
                                            <tr class="taltr">
                                                <td class="taltd taladjust">
                                                    <b>Size</b><br>
                                                    Waist (cm)<br>
                                                    Hips (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>30</b><br>
                                                    52<br>
                                                    82
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>32</b><br>
                                                    56<br>
                                                    86
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>34</b><br>
                                                    60<br>
                                                    90
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>36</b><br>
                                                    64<br>
                                                    94
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>38</b><br>
                                                    68<br>
                                                    98
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>40</b><br>
                                                    72<br>
                                                    102
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>42</b><br>
                                                    76<br>
                                                    106
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>44</b><br>
                                                    80<br>
                                                    110
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>46</b><br>
                                                    84<br>
                                                    114
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>48</b><br>
                                                    88<br>
                                                    118
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="taltd taladjust">
                                                    <b>Size</b><br>
                                                    Waist (cm)<br>
                                                    Hips (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>XS</b><br>
                                                    50-58<br>
                                                    80-88
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>S</b><br>
                                                    58-66<br>
                                                    88-96
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>M</b><br>
                                                    66-74<br>
                                                    96-104
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>L</b><br>
                                                    74-82<br>
                                                    104-112
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>XL</b><br>
                                                    82-90<br>
                                                    112-120
                                                </td>
                                                <td colspan="5" class="taltd talhide">
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="taltable">
                                            <th class="talth taltr" colspan="6">
                                                SHIRTS, T-SHIRTS, JERSEYS, JACKETS, COATS, BLAZERS...
                                            </th>
                                            <tr>
                                                <td class="taltd taladjust2">
                                                    <b>Size</b><br>
                                                    Chest (cm)<br>
                                                    Waist (cm)<br>
                                                    Hips (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>XS</b><br>
                                                    70-78<br>
                                                    50-58<br>
                                                    80-88
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>S</b><br>
                                                    78-86<br>
                                                    58-66<br>
                                                    88-96
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>M</b><br>
                                                    86-94<br>
                                                    66-74<br>
                                                    96-104
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>L</b><br>
                                                    94-102<br>
                                                    74-82<br>
                                                    104-112
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>XL</b><br>
                                                    102-110<br>
                                                    82-90<br>
                                                    112-120
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="taltable">
                                            <th class="talth taltr" colspan="13">
                                                FOOTWEAR
                                            </th>
                                            <tr>
                                                <td class="taltd taladjust">
                                                    <b>Size</b><br>
                                                    Foot lenght (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>35</b><br>
                                                    22,35
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>36</b><br>
                                                    22,99
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>36/37</b><br>
                                                    23,63
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>37</b><br>
                                                    23,63
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>38</b><br>
                                                    24,27
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>38/39</b><br>
                                                    24,90
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>39</b><br>
                                                    24,90
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>40</b><br>
                                                    25,54
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>40/41</b><br>
                                                    26,18
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>41</b><br>
                                                    26,18
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>42</b><br>
                                                    26,82
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="taltable">
                                            <th class="taltr talth" colspan="3">
                                                BELTS
                                            </th>
                                            <tr>
                                                <td class="taltd taladjust">
                                                    <b>Size</b><br>
                                                    Waist (cm)<br>
                                                    Hips (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>75</b><br>
                                                    65-70-75<br>
                                                    85-90-95
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>85</b><br>
                                                    75-80-85<br>
                                                    90-95-100
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <table class="taltable">
                                            <th class="taltr talth" colspan="2">
                                                HATS
                                            </th>
                                            <tr>
                                                <td class="taltd taladjust">
                                                    <b>Size</b><br>
                                                    Head measurement (cm)
                                                </td>
                                                <td class="taltd talnotd">
                                                    <b>1</b><br>
                                                    58
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
				<span class="talsubt">
					* This sizing is based on the exact measurements of the body.
				</span>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>



    </div>
</div>
</td>
</tr>
</table>

</div>
<?php endif; ?>
</div>