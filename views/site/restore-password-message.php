<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restore-password-form for_enter" style="min-height: auto;">

    <p>Для восстановления пароля пройдите по ссылке, отправленной на адрес вашей электронной почты <?= Helper::setMaskToEmail($email) ?></p>
	<button id="close-restore-password-form" class="for_enter__submit text_16" type="button">Принимаю</button>

</div>
