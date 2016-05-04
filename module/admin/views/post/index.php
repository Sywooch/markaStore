<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\module\admin\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content1:ntext',
            'content2:ntext',
            'content3:ntext',
            'content4:ntext',
            'category_id',
            [
                'content'  => function ($model) {

                    if ($model->status == 0){
                        return Html::a('Опубликовать', ["/admin/post/display?id=$model->id"], ['class'=>'btn btn-success']);
                    }else{
                        return Html::a('Скрыть', ["/admin/post/hide?id=$model->id"], ['class'=>'btn btn-danger']);
                    }

                },
                'label' => 'Видимость',
            ],
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<div class="row" style="width: 100%;" align="center">
<?php foreach(\app\module\admin\models\Post::find()->all() as $model): ?>
    <div style="width: 100%;">
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

</br>
</br>
<?php endforeach; ?>
</div>
