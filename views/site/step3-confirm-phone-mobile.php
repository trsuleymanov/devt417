<?php
use yii\helpers\Html;

$this->title = 'Подтверждение телефона';
$this->params['breadcrumbs'][] = $this->title;

?>

	<div class="modal_global">
		<div class="modal_global__name">
			<button class="prev modal-prev" type="button" data-izimodal-open="#enter-mobile">
				<svg class="icon icon-right-arrow close__svg">
					<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
				</svg>
			</button>
			<a class="modal_global__login text_20" href="">
				<svg class="icon icon-phone header__icon">
					<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#phone"></use>
				</svg>Подтвердите телефон
			</a>
			<button class="close" type="button" name="close" data-izimodal-close="">
				<svg class="icon icon-close close__svg">
					<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
				</svg>
			</button>
		</div>
		<div class="modal_global__enter">
			<div class="modal_global__content" style = "padding: 20px;">

				<p class = "text_16">Для регистрации в личном кабинете необходимо позвонить с указанного вами телефона на <b><?=$reg_number_pretty;?></b>.</p>
				<p class = "text_16" style = "color: #999">Это бесплатно и займет несколько секунд. Ваш звонок будет автоматически сброшен.</p>

			</div>
			<div class = "modal_global__btn">

				<button id = "confirm_phone_link" class = "modal_global__submit text_16" href="tel:<?=$reg_number;?>">
					<svg class="icon icon-phone">
						<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#phone"></use>
					</svg>
					<?=$reg_number_pretty;?>
				</button>

			</div>
		</div>
	</div>