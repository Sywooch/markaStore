<?php

    use yii\helpers\Html;
    use yii\grid\GridView;
    use app\module\admin\models\Order;
    use app\module\admin\models\Followers;

    /* @var $this yii\web\View */
    /* @var $searchModel app\module\admin\models\MessagesSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'E-mail рассылка';
    $this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin/']];
    $this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-2" ><?php include (__DIR__ . ('/../default/menu.php'));  ?>
    </div>
    <div class="col-md-10" >
<div class="messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новый шаблон рассылки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'to',
            ['content' => function ($model){
                return !empty($model->customers) ? Order::find()->select('email')->distinct()->count() : 'Не выбрано';
            },  'label' => 'Заказчики',],
            ['content' => function ($model){
                return !empty($model->followers) ? Followers::find()->select('email')->where(['mailing' => 1])->distinct()->count() : 'Не выбрано';
            },  'label' => 'Подписчики',],
            'subject',
            'message:ntext',
            'date_sent:ntext',
            ['content' => function ($model){

                $send =  Html::a('Отправить',\yii\helpers\Url::toRoute(['send', 'id' => $model->id]),['class' => 'btn btn-success', 'data' => [
                    'confirm' => 'Отправить рассылку сейчас?',
                ]]);
                if ($model->active != 1){
                    return $send . Html::a('Активировать', ["/admin/messages/active?id=$model->id"], ['class'=>'btn btn-success']);
                }else{
                    return $send . Html::a('Деактивировать', ["/admin/messages/deactive?id=$model->id"], ['class'=>'btn btn-danger']);
                }
            },  'label' => 'Действие',],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
</div>
