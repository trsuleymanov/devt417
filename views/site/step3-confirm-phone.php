<?php
use yii\helpers\Html;

$this->title = 'Подтверждение телефона';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class = "for_enter">

	<p>Для подтверждения номера и регистрации в личном кабинете необходимо позвонить с указанного вами телефона на <call><?=$reg_number_pretty;?></call>.</p>
	<p>Это бесплатно и займет несколько секунд. Ваш звонок будет автоматически сброшен.</p>
	<div id = "modal_confirm_actions">
		<button id = "confirm_phone_link" href="tel:<?=$reg_number;?>"><?=$reg_number_pretty;?></button>
	</div>

</div>