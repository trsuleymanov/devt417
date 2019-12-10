<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Завершение регистрации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-end-registration">

    <?php $form = ActiveForm::begin([
        'id' => 'end-registration-form',
    ]); ?>

    <?php /*
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
    </div>*/

    echo $form->field($model, 'mobile_phone')->hiddenInput()->label(false);
    ?>

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
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'confirm_password')->passwordInput() ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'id' => 'submit-end-registration']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
