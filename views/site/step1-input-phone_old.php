<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'inputphone-form',
//        'enableAjaxValidation' => false,
//        'enableClientValidation' => false,
        'options' => [
            'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
        ]
    ]); ?>

    <?php if($client_ext != null) {

        $model->mobile_phone = $client_ext->phone;
        ?>
        <div class="row">
            <div class="col-sm-12">Чтобы забронировать заказ без оплаты необходимо вначеле авторизоваться.</div>
        </div>
        <br />
    <?php } ?>

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
        <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'name' => 'inputphone-button']) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>
