<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заполните электронную почту и установите пароль для входа на сайт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="for_enter">

    <?php $form = ActiveForm::begin([
        'id' => 'registration-step-3',
        'options' => [
            'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
        ]
    ]); ?>

    <?php /*
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'maxlength' => true]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'id' => 'send-email-password-button', 'access_code' => $model->access_code]) ?>
    </div>
    */ ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Для регистрации введите Email'])->label(false); ?>

    <br />
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Для регистрации введите пароль', 'autocomplete' => "off"])->label(false) ?>

    <br />
    <button id="send-email-password-button" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" style="width: 100%;" type="button">Зарегистрироваться</button>


    <?php ActiveForm::end(); ?>
</div>