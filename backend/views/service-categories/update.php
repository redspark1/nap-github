<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategories */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Service Categories',
]) . $model->service_category_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->service_category_id, 'url' => '#'];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="service-categories-update">

    <h1><?php // echo Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
