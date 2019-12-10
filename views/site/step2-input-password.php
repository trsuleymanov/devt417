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
        'options' => [
            'autocomplete' => "off"
        ],
        'fieldConfig' => [
          'errorOptions' => [
               'encode' => false,
               'class' => 'help-block'
           ],
        ]
    ]); ?>


    <div class="for_enter fix_height">
        <!--
        <input class="for_enter__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
        -->
        <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'disabled' => true, 'class' => 'for_enter__input'])->label(false); ?>
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
        echo $form->field($model, 'email')->textInput(['autofocus' => true, 'disabled' => true, 'class' => 'for_enter__input'])->label(false);
        ?>

        <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Введите пароль',
                'autocomplete' => "false",  // не работает, хоть убейся
                'class' => 'for_enter__input',
                //'onblur' => "this.setAttribute('readonly', 'readonly');",
                //'onfocus' => "this.removeAttribute('readonly');",
                //'readonly' => true
        ])->label(false) ?>

        <?= $form->field($model, 'rememberMe')->checkbox(['template' => '{input}<label for = "user-rememberme">Запомнить меня</label>']);
        ?>

        <button id="input-password-submit" class="for_enter__submit text_18" type="button" name="submit">Продолжить</button>
    </div>

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
