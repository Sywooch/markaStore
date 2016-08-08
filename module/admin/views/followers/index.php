<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\FollowersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подписчики';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="followers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать подписчика вручную', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fio',
            'email:email',
            'genus.genus',
            'date_subscription',
            ['content' => function($model){
                return Html::a($model->mailing == 1 ? 'Отписать' : 'Подписать',
                    Url::toRoute(['mailing','id' => $model->id, 'mailing' => $model->mailing == 1 ? 0 : 1]),
                    ['class' => 'btn btn-' . ($model->mailing == 1 ? 'danger' : 'success'),
                        'data' => $model->mailing == 1 ? [
                            'confirm' => 'Вы уверены что хотите отписать ' . $model->fio . '?'
                        ] : '']);
            }],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
