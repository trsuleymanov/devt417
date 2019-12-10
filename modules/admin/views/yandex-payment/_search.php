<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\YandexPaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yandex-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'yandex_payment_id') ?>

    <?= $form->field($model, 'source_yandex_payment_id') ?>

    <?= $form->field($model, 'source_payment_id') ?>

    <?php // echo $form->field($model, 'client_ext_id') ?>

    <?php // echo $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'payment_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'pending_at') ?>

    <?php // echo $form->field($model, 'waiting_for_capture_at') ?>

    <?php // echo $form->field($model, 'succeeded_at') ?>

    <?php // echo $form->field($model, 'canceled_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
