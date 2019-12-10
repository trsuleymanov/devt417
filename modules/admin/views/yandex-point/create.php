<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\YandexPoint */

$this->title = 'Create Yandex Point';
$this->params['breadcrumbs'][] = ['label' => 'Yandex Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yandex-point-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
