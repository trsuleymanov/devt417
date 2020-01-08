<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="restore-password-form modal_global__enter" style="height: auto;">

    <div class="modal_global">
        <div class="modal_global__name">
            <span class="text_22">Восстановление пароля</span>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
        <div class="modal_global__enter">
            <div class="modal_global__content" style="padding: 20px;">
                <p>Для восстановления пароля пройдите по ссылке, отправленной на адрес вашей электронной почты <?= Helper::setMaskToEmail($email) ?></p>
            </div>
            <div class="modal_global__bottom">
                <button id="close-restore-password-form" class="modal_global__submit text_16" type="button">Принимаю</button>
            </div>
        </div>
    </div>
</div>
