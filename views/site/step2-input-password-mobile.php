<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile('js/login.js', ['depends'=>'app\assets\AppAsset']);
Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;

?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'input-password-form',
        'fieldConfig' => [
          'errorOptions' => [
               'encode' => false
           ],
        ]
    ]); ?>


    <div class="modal_global">
        <div class="modal_global__name">
            <button class="prev modal-prev" type="button" data-izimodal-open="#enter-mobile">
                <svg class="icon icon-right-arrow close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </button><a class="modal_global__login text_20" href="">
                <svg class="icon icon-user header__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                </svg>Войти</a>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
        <div class="modal_global__enter">
            <div class="modal_global__content">
                <!--
                <input class="modal_global__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
                -->
                <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'disabled' => true, 'class' => 'modal_global__input'])->label(false); ?>

                <!--
                <input class="modal_global__input" type="email" name="email" placeholder="Введите Email" autocomplete="off">
                -->
                <?php
//                $length = strlen($model->email) - 3;
//                $stars = '';
//                for($i = 0; $i < $length; $i++) {
//                    $stars .= '*';
//                }
//                $model->email = substr($model->email, 0, 3).$stars;
                $model->email = Helper::setMaskToEmail($model->email);

                echo $form->field($model, 'email')->textInput(['autofocus' => true, 'disabled' => true, 'placeholder' => 'Введите Email', 'class' => 'modal_global__input'])->label(false);
                ?>

                <!--
                <input class="modal_global__input" type="password" name="phone" placeholder="Введите пароль" autocomplete="off">
                -->
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль', 'autocomplete' => "off", 'class' => 'modal_global__input', ])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['template' => '{input}<label for = "user-rememberme" class = "modal_global__checkbox text_20">Запомнить меня</label>']); ?>

            </div>
            <div class="modal_global__btn">
                <button id="input-password-submit" class="modal_global__submit text_20 test" type="button" name="submit">Продолжить</button>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
