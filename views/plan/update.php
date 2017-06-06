<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Plan */

$this->title = 'Update Plan: ' . $model->idPlan;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPlan, 'url' => ['view', 'id' => $model->idPlan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
