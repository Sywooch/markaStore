<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Slidebar */

$this->title = 'Create Slidebar';
$this->params['breadcrumbs'][] = ['label' => 'Slidebars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slidebar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
