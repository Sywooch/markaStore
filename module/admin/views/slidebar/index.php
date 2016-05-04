<?php

use yii\helpers\Html;
use yii\grid\GridView;
    use yii\helpers\Url;
    use app\module\admin\models\Slidebar;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\SlidebarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдер';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slidebar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новый слайд', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'head:ntext',
            'description:ntext',
            [
                'content'  => function ($model) {
                    return '<img height="100px" src="' . Url::base() . '/images/' . $model->image_url . '">';
                },
                'label' => 'img'
            ],

            [
                'content'  => function ($model) {

                    if ($model->display == 0){
                        return Html::a('Опубликовать', ["/admin/slidebar/display?id=$model->id"], ['class'=>'btn btn-success']);
                    }else{
                        return Html::a('Скрыть', ["/admin/slidebar/hide?id=$model->id"], ['class'=>'btn btn-danger']);
                    }

                },
                'label' => 'Видимость',
            ],
           // 'image_url:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<h2>Предпросмотр</h2>
</br></br>
<div align="center">
    <div id="carousel-example-generic"  style="margin-left: -2%; margin-right: -2%; margin-top: -2%;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $item = -1;
                foreach (Slidebar::find()->
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
                foreach (Slidebar::find()->orderBy(['id' => SORT_DESC])->all() as $slide): ?>
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

