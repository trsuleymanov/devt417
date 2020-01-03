<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="restore-password-form modal_global__enter" style="height: auto;">

    <div class="modal_global">
        <div class="modal_global__name">
            <button class="prev modal-prev" prev-modal="enter_password-mobile" phone="<?= $phone ?>">
                <svg class="icon icon-right-arrow close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </button><a class="modal_global__login text_20" href="">Восстановление пароля</a>
        </div>

        <div class="modal_global__enter">
            <div class="modal_global__content" style="padding: 20px;">
                <p>Для восстановления пароля пройдите по ссылке, отправленной на адрес вашей электронной почты {замаскированный e-mail}</p>
            </div>
        </div>
    </div>
</div>
