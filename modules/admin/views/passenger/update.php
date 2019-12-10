<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Passenger */

$this->title = 'Update Passenger: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Passengers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="passenger-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
