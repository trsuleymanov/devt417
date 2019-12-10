<?php
use app\components\Helper;

$this->registerCssFile('css/account/lk.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('js/account/reservation.js', ['depends'=>'app\assets\NewAppAsset']);
?>
<div class="reservation__menu">
    <div class = "reservation_menu__title">АКТИВНЫЕ ЗАКАЗЫ</div>
    <?php /*
    <div class="reservation">
        <p>АЛЬМЕТЬЕВСК - КАЗАНЬ </p>

        <p>25 авг в 10:30 <span class="reserv">/мест:2</span></p>
        <p>Место посадки</p>
        <p>«Магазин Орион», ул. Гафиатуллина, д.19</p>
        <p>Время подтверждено.</p>
        <p>К оплате: <b>1000</b> р.</p>
        <a href="">Подробнее ></a>
        <div class="button__href"><a href="">Изменить</a>  <a href="">Отменить</a></div>
    </div>
    <div class="reservation">
        <p>КАЗАНЬ - АЛЬМЕТЬЕВСК</p>
        <p>27 авг в 21:30 <span class="reserv">/мест:1</span></p>
        <p>Место посадки</p>
        <p>«Магазин Орион», ул. Гафиатуллина, д.19</p>
        <p>Время подтверждено.</p>
        <p>К оплате: <b>500</b> р.</p>
        <a href="">Подробнее ></a>
        <div class="button__href"><a href="">Изменить</a>  <a href="">Отменить</a></div>
    </div>
    */ ?>

    <?php
    if(count($orders) > 0) {
        foreach ($orders as $order) {

            $aTime = explode(':', $order->time);
            $datetime = $order->data + 3600 * intval($aTime[0]) + 60 * intval($aTime[1]);

            ?>
            <div class="active__order" access-code="<?= $order->access_code ?>">
                <div class = "order__direction">
                    <span><?= $order->direction_id == 1 ? 'Альметьевск-Казань' : 'Казань-Альметьевск' ?></span>
                </div>
                <div class = "order__info">
                    <div class = "order__date">
                        <?= Helper::getMainDate($datetime, 1) ?>
                    </div>
                    <div class = "order__tickets">/мест:<?= $order->places_count ?>
                    </div>
                </div>
                <div class = "order__departure">
                    <div class = "order__departure__title">Место посадки</div>
                    <div class = "order__departure__value"><?= $order->yandex_point_from_name ?></div>
                </div>
                <div class = "order__price">
                    <div class = "order__price__row">
                        <div class = "order__price__title">К оплате:</div>
                        <div class = "order__price__value"><?= $order->price ?><span>р.</span>
                        </div>
                    </div>
                </div>
                <div class = "order__detail">
                    <a href="">Подробнее ></a>
                </div>
                <div class = "order__actions">
                    <a class = "order__actions__edit" href="/site/create-order?c=<?= $order->access_code ?>">Изменить</a>
                    <a class = "order__actions__cancel" href="">Отменить</a>
                </div>
            </div>
        <?php }
    }else { ?>
        <div class="empty-text">У вас нет активных заказов</div>
    <?php } ?>
</div>