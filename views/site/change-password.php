<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменение пароля';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-change-password">

    <?php $form = ActiveForm::begin([
        'id' => 'change-password-form'
    ]); ?>

    <div class="row">
        <div class="col-sm-9">
            <?= $form->field($model, 'new_password')->textInput(['autofocus' => true]) ?>
        </div>
    </div>


    <br />
    <div class="form-group">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>