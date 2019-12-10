<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Введите полученный в смс код';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="for_enter fix_height">

    <?php $form = ActiveForm::begin([
        'id' => 'registration-step-2',
        'options' => [
            'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
        ]
    ]); ?>

    <p>
        Вы не зарегистрированы. Для прохождения регистрации на ваш номер <?= $model->mobile_phone ?> была отправлена смс с кодом.<br />
    </p>
    <br />

    <?php /*
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'check_code')
                ->textInput(['maxlength' => true])
                ->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '9999',
                    'clientOptions' => [
                        'placeholder' => '*'
                    ]
                ])
                ->label('Введите полученный код');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6" id="resend-code-block" style="display: none;">
            <?= Html::button('Запросить повторно код', ['class' => 'btn btn-success', 'id' => 'resend-code-button', 'access_code' => $model->access_code, ]) ?>
        </div>
        <div class="col-sm-3">
            <?= Html::button('Далее', ['class' => 'btn btn-primary', 'id' => 'check-code-button', 'access_code' => $model->access_code]) ?>
        </div>
    </div>
    <br />
    <p id="error" class="text-danger"></p>
    */ ?>

    <?= $form->field($model, 'check_code')
        ->textInput(['maxlength' => true])
        ->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '9999',
            'clientOptions' => [
                'placeholder' => '*'
            ],
            'options' => [
                'class' => 'for_enter__input',
                'placeholder' => 'Введите полученный код'
            ]
        ])
        ->label(false);
    ?>
    <br />
    <button id="resend-code-button" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" style="width: 100%;" type="button">Запросить повторно код</button>
    <button id="check-code-button" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" type="button">Продолжить</button>
    <br />
    <p id="error" class="text-danger"></p>

    <?php ActiveForm::end(); ?>
</div>