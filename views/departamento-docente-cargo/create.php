<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DepartamentoDocenteCargo */

$this->title = 'Create Departamento Docente Cargo';
$this->params['breadcrumbs'][] = ['label' => 'Departamento Docente Cargos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departamento-docente-cargo-create">

    <h1>Asignar departamento y cargo al docente </h1>

    <?= $this->render('_form', [
        'model' => $model 
    ]) ?>

</div>
