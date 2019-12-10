<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Passenger */

$this->title = 'Create Passenger';
$this->params['breadcrumbs'][] = ['label' => 'Passengers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="passenger-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
