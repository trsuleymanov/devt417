<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Заполните электронную почту и установите пароль для входа на сайт';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modal_global__enter"  style="height: auto;">

    <div class="modal_global">

        <?php $form = ActiveForm::begin([
            'id' => 'registration-step-3',
            'options' => [
                'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
            ]
        ]); ?>

        <div class="modal_global__name">
            <button class="prev modal-prev" prev-modal="entersmscode-mobile" reg_code="<?= $reg_code ?>" client_ext_id="<?= ($client_ext != null ? $client_ext->id : 0) ?>">
                <svg class="icon icon-right-arrow close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </button>
            <a class="modal_global__login text_20" href="">Регистраций - шаг 3/3</a>
            <button class="close modal-close" type="button">
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
        <div class="modal_global__enter">
            <div class="modal_global__content">

                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Для регистрации введите Email', 'class' => 'modal_global__input'])->label(false); ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Для регистрации введите пароль', 'autocomplete' => "off", 'class' => 'modal_global__input', ])->label(false) ?>

            </div>
            <div class="modal_global__btn">
                <button id="send-email-password-button-mobile" access_code="<?= $model->access_code ?>" class="modal_global__submit text_16 test" type="button" style="width: 100%;" name="submit">Зарегистрироваться</button>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php /*
    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Для регистрации введите Email'])->label(false); ?>

    <br />
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Для регистрации введите пароль', 'autocomplete' => "off"])->label(false) ?>

    <br />
    <button id="send-email-password-button" access_code="<?= $model->access_code ?>" class="for_enter__submit text_18" style="width: 100%;" type="button">Зарегистрироваться</button>
    */ ?>
</div>