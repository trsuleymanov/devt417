<?php
use yii\helpers\Html;

$this->title = 'Подтвердите номер';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class = "for_enter">

	<p class = "text_14">Для регистрации в личном кабинете необходимо позвонить с указанного вами телефона на <b><?=$reg_number_pretty;?></b>.</p>
	<p class = "text_13" style = "color: #999">Это бесплатно и займет несколько секунд. Ваш звонок будет автоматически сброшен.</p>
	<div id = "modal_confirm_actions">
		<a id = "confirm_phone_link" href="tel:<?=$reg_number;?>">
			<svg class="icon icon-phone">
				<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#phone"></use>
			</svg>
			<?=$reg_number_pretty;?>
		</a>
	</div>

</div>