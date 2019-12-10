<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientExt */

$this->title = 'Update Client Ext: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Client Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-ext-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
