<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientExtSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-ext-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'main_server_order_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'status_setting_time') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'direction') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'time_confirm') ?>

    <?php // echo $form->field($model, 'trip_name') ?>

    <?php // echo $form->field($model, 'street_from') ?>

    <?php // echo $form->field($model, 'point_from') ?>

    <?php // echo $form->field($model, 'yandex_point_from_id') ?>

    <?php // echo $form->field($model, 'yandex_point_from_name') ?>

    <?php // echo $form->field($model, 'yandex_point_from_lat') ?>

    <?php // echo $form->field($model, 'yandex_point_from_long') ?>

    <?php // echo $form->field($model, 'street_to') ?>

    <?php // echo $form->field($model, 'point_to') ?>

    <?php // echo $form->field($model, 'yandex_point_to_id') ?>

    <?php // echo $form->field($model, 'yandex_point_to_name') ?>

    <?php // echo $form->field($model, 'yandex_point_to_lat') ?>

    <?php // echo $form->field($model, 'yandex_point_to_long') ?>

    <?php // echo $form->field($model, 'places_count') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'transport_car_reg') ?>

    <?php // echo $form->field($model, 'transport_model') ?>

    <?php // echo $form->field($model, 'transport_color') ?>

    <?php // echo $form->field($model, 'friend_code') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'sync_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
