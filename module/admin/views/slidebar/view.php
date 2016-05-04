<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Slidebar */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slidebars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slidebar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php echo '<img height="100px" src="' . Url::base() . '/images/' . $model->image_url . '">'; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'head:ntext',
            'description:ntext',
            'image_url:ntext',
        ],
    ]) ?>

</div>
