<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ClientExt */

$this->title = 'Create Client Ext';
$this->params['breadcrumbs'][] = ['label' => 'Client Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-ext-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
