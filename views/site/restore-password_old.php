<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

//$this->registerJsFile('js/login.js', ['depends'=>'app\assets\AppAsset']);
?>
<div class="site-restore-password">

    <?php $form = ActiveForm::begin([
        'id' => 'restore-password-form'
    ]); ?>

    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        </div>
    </div>


    <br />
    <div class="form-group">
        <?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
