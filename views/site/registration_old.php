<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-registration">

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
    ]); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true])
                ->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+7-999-999-9999',
                    'clientOptions' => [
                        'placeholder' => '*'
                    ]
                ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        </div>
    </div>

    <?php /*
    <div class="row">
        <div class="col-sm-10">
            <?= $form->field($model, 'rememberMe')->checkbox([])->label('Запомнить') ?>
        </div>
    </div>*/ ?>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
