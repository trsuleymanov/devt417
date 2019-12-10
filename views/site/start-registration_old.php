<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-start-registration">

    <?php $form = ActiveForm::begin([
        'id' => 'start-registration-form',
//        'enableAjaxValidation' => false,
//        'enableClientValidation' => false,
    ]); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true])
                ->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+7-999-999-9999',
                    'clientOptions' => [
                        'placeholder' => '*'
                    ]
                ]);
            ?>
        </div>
    </div>

    <br />
    <div class="form-group">
        <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'id' => 'submit-start-registration']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
