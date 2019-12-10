<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Введите полученный в смс код';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal_global__enter">

    <div class="modal_global">
        <div class="modal_global__name">
            <button class="prev modal-prev" type="button" prev-modal="enter-mobile">
                <svg class="icon icon-right-arrow close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </button><a class="modal_global__login text_20" href="">Регистрация - шаг 2/3</a>
            <button class="close modal-close" type="button">
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>

        <div class="modal_global__enter">
            <div class="modal_global__content" style="padding: 20px;">

                <?php $form = ActiveForm::begin([
                    'id' => 'registration-step-2',
                    'options' => [
                        'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
                    ]
                ]); ?>

                <br />
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
                            'class' => 'modal_global__input',
                            'placeholder' => 'Введите полученный код'
                        ]
                    ])
                    ->label(false);
                ?>
                <br />
                <button id="resend-code-button-mobile" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" style="width: 100%;" type="button">Запросить повторно код</button>
                <br /><br />
                <button id="check-code-button-mobile" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" type="button">Продолжить</button>
                <br />
                <p id="error" class="text-danger"></p>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>