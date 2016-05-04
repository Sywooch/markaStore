<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\module\admin\models\Genus */

$this->title = Yii::t('app', 'Create Genus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Genuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="genus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
