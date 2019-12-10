<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientExt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="client-ext-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'main_server_order_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_setting_time')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'direction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_confirm')->textInput() ?>

    <?= $form->field($model, 'trip_name')->textInput(['maxlength' => true]) ?>

    <?php /*
    <?= $form->field($model, 'street_from')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'point_from')->textInput(['maxlength' => true]) ?>
    */ ?>

    <?= $form->field($model, 'yandex_point_from_id')->textInput() ?>

    <?= $form->field($model, 'yandex_point_from_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yandex_point_from_lat')->textInput() ?>

    <?= $form->field($model, 'yandex_point_from_long')->textInput() ?>
    <?php /*
    <?= $form->field($model, 'street_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'point_to')->textInput(['maxlength' => true]) ?>
    */ ?>
    <?= $form->field($model, 'yandex_point_to_id')->textInput() ?>

    <?= $form->field($model, 'yandex_point_to_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yandex_point_to_lat')->textInput() ?>

    <?= $form->field($model, 'yandex_point_to_long')->textInput() ?>

    <?= $form->field($model, 'places_count')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_car_reg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transport_color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'friend_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'sync_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
