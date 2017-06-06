<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Materia */

//$this->title = $model->idMateria;
$this->params['breadcrumbs'][] = ['label' => 'Materias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materia-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idMateria], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idMateria], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'nombre',
            'anio',
            'hora',
            'objetivo',
            'contenidoMinimo',
        		//[ 'attribute'=> 'correlativas',
        		//'label'=>'Correlativa',],
        		
            //'idMateria',
            //'idDepartamento',
        		[ 'attribute'=> 'idDepartamento0.nombre',
        		'label'=>'Departamento'],
            'idPlan',
        ],
    ]) ?>

</div>
