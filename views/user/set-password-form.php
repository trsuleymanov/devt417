<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Восстановление доступа';
?>

<?php $form = ActiveForm::begin(['id' => 'set-password-form']); ?>

<div class="row">
    <div class="col-sm-4 form-group form-group-sm">
        <?= $form->field($model, 'password')->textInput(['autofocus' => true])->label('Введите новый пароль') ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('Установить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
</div>

<?php ActiveForm::end(); ?>


