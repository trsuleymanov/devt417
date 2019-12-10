<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile('js/login.js', ['depends'=>'app\assets\AppAsset']);
?>
<div class="site-login">

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
//        'enableAjaxValidation' => false,
//        'enableClientValidation' => false,
    ]); ?>

    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-sm-3" style="padding-left: 0; margin-top: 30px;">
            <a id="open-restore-password-form" href="#">Забыли ?</a>
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
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


