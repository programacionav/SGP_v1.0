<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Facultad;

/* @var $this yii\web\View */
/* @var $model app\models\Departamento */

$this->title = $model['nombre'];
$this->params['breadcrumbs'][] = ['label' => 'Departamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departamento-view">

    <h1><?= Html::encode($model['nombre']) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->idDepartamento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idDepartamento], [
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
            'nombre',
			[
             'attribute' => 'idFacultad',
             'label' => 'Facultad',
             'value'=> function ($model) {
						$item = ArrayHelper::map(Facultad::find()->all(),
							'idFacultad',
							function($model) {
								return $model['nombre'];
							}
							);
							return $item[$model->idFacultad];
                      },
			],
        ],
    ]) ?>

</div>
