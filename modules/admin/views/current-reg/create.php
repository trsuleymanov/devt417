<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CurrentReg */

$this->title = 'Create Current Reg';
$this->params['breadcrumbs'][] = ['label' => 'Current Regs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="current-reg-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
