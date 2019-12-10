<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserRole;

$this->registerJsFile('js/admin/user.js', ['depends'=>'app\assets\AdminAsset']);
?>

<div id="user-page" user-id="<?= $model->id ?>">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border scroller-header">
            <button type="button" id="change-password" class="btn btn-sm btn-success">
                Изменить пароль
            </button>
        </div>
    </div>


    <div class="row">

        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'phone')
                ->textInput(['maxlength' => true])
                ->widget(\yii\widgets\MaskedInput::class, [
                    'mask' => '+7-999-999-9999',
                    'clientOptions' => [
                        'placeholder' => '*'
                    ]
                ]);
            ?>
        </div>

        <?php
        /*
        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        */
        ?>
    </div>

    <div class="row">


        <?php /*
        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'role_id')->dropDownList(
                ArrayHelper::map(UserRole::find()->all(), 'id', 'name')
            ); ?>
        </div>
        */ ?>

        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'blocked')->dropDownList(
                [0 => 'Нет', 1 => 'Да']
            ); ?>
        </div>
    </div>


    <?php /*
    <div class="row">
        <div class="col-sm-4 form-group form-group-sm">
            <?= $form->field($model, 'seans_duration_finish')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    */ ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
