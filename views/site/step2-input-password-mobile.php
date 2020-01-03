<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile('js/login.js', ['depends'=>'app\assets\AppAsset']);
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
            <button class="prev modal-prev" type="button" prev-modal="enter-mobile">
                <svg class="icon icon-right-arrow close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </button><a class="modal_global__login text_20" href="">
                <svg class="icon icon-user header__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                </svg>Войти</a>
            <button class="close modal-close" type="button">
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
                $length = strlen($model->email) - 3;
                $stars = '';
                for($i = 0; $i < $length; $i++) {
                    $stars .= '*';
                }
                $model->email = substr($model->email, 0, 3).$stars;

                echo $form->field($model, 'email')->textInput(['autofocus' => true, 'disabled' => true, 'placeholder' => 'Введите Email', 'class' => 'modal_global__input'])->label(false);
                ?>

                <!--
                <input class="modal_global__input" type="password" name="phone" placeholder="Введите пароль" autocomplete="off">
                -->
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль', 'autocomplete' => "off", 'class' => 'modal_global__input', ])->label(false) ?>

                <div class="children__checkbox">
                    <button class="children__btn" type="button" name="check" data-name="Запомнить меня"></button>
                    <!--
                    <input type="checkbox" name="checkbox" hidden="">
                    -->
                    <?php
                    echo $form->field($model, 'rememberMe')->hiddenInput()->label(false);
                    ?>
                </div>

            </div>
            <div class="modal_global__btn">
                <button id="input-password-submit" class="modal_global__submit text_16 test" type="button" name="submit">Продолжить</button>
            </div>
        </div>
    </div>

<?php /*
    <div class="for_enter fix_height">
        <!--
        <input class="for_enter__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
        -->
        <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'disabled' => true])->label(false); ?>
        <!--
        <input class="for_enter__input" type="email" name="email" placeholder="Введите Email" autocomplete="off">
        -->
        <?php

        $length = strlen($model->email) - 3;
        $stars = '';
        for($i = 0; $i < $length; $i++) {
            $stars .= '*';
        }
        $model->email = substr($model->email, 0, 3).$stars;
        echo $form->field($model, 'email')->textInput(['autofocus' => true, 'disabled' => true])->label(false);
        ?>

        <!--
        <input class="for_enter__input" type="password" name="phone" placeholder="Введите пароль" autocomplete="off">
        -->
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль', 'autocomplete' => "off"])->label(false) ?>

        <div class="children__checkbox">
            <!--
            <input type="checkbox" name="checkbox" hidden="">
            -->
            <button class="children__btn" type="button" name="check" data-name="Запомнить меня"></button>
            <?php
            echo $form->field($model, 'rememberMe')->hiddenInput()->label(false);
            ?>
        </div>

        <a id="open-restore-password-form" href="">Восстановить пароль</a>

        <button id="input-password-submit" class="for_enter__submit text_18" type="button" name="submit">Продолжить</button>
    </div>
*/ ?>

    <?php /*
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'disabled' => true])->label('Ваш телефон'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php

            $length = strlen($model->email) - 3;
            $stars = '';
            for($i = 0; $i < $length; $i++) {
                $stars .= '*';
            }
            $model->email = substr($model->email, 0, 3).$stars;
            echo $form->field($model, 'email')->textInput(['autofocus' => true, 'disabled' => true])->label('Ваш email');
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'password')->passwordInput()->label('Введите пароль') ?>
        </div>

        <div class="col-sm-3" style="margin-top:28px;">
            <?= Html::button('Восстановить пароль', ['class' => 'btn btn-info', 'id' => 'open-restore-password-form']) ?>
        </div>
    </div>



    <!--
    <div class="row">
        <div class="col-sm-10">
            <?php
            // echo $form->field($model, 'rememberMe')->checkbox([])->label('Запомнить');
             ?>
        </div>
    </div>-->

    <br />
    <div class="form-group">
        <?= Html::button('Войти', ['class' => 'btn btn-primary', 'id' => 'input-password-submit']) ?>
    </div>*/ ?>

    <?php ActiveForm::end(); ?>
</div>
