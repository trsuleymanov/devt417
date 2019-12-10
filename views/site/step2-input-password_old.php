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
    ]); ?>

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
            <!--
            <div class="col-sm-3" style="padding-left: 0; margin-top: 30px;">
                <a id="open-restore-password-form" href="#">Забыли ?</a>
            </div>-->

            <?= Html::button('Восстановить пароль', ['class' => 'btn btn-info', 'id' => 'open-restore-password-form']) ?>
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
        <?= Html::button('Войти', ['class' => 'btn btn-primary', 'id' => 'input-password-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
