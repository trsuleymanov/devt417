<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Введите код присланный в смс';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="page-check-registration-code">

    <?php $form = ActiveForm::begin([
        'id' => 'form-check-registration-code',

    ]); ?>

    <?= $form->field($model, 'mobile_phone')->hiddenInput()->label(false); ?>


    <?php if(isset($show_error) && $show_error == true) { ?>

        <div class="row">
            <div class="col-sm-12" style="color: red;"><?= $show_error ?></div>
        </div>

    <?php }else { ?>

        <div class="row">
            <div class="col-sm-12">
                На ваш телефон отправлен смс с кодом подтверждения.
            </div>
        </div>
        <br />

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'check_code')->textInput(['maxlength' => true])->label('Введите полученный в смс код') ?>
            </div>
        </div>

        <br />
        <div class="form-group">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'id' => 'submit-check-registration-code', 'style' => (isset($hide_button_next) && $hide_button_next == true ? 'display: none;' : '')]) ?>
            <?= Html::button('Отправить код еще раз', ['class' => 'btn btn-success', 'id' => 'send-registration-code', 'style' => 'display: none;']) ?>
        </div>
    <?php } ?>


    <?php ActiveForm::end(); ?>
</div>