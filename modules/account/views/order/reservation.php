<?php
use app\components\Helper;

$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
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
            <div class="active__order">
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
                        <div class = "order__price__title"><?= ($order->is_paid == true ? 'Оплачено:' : 'К оплате:') ?></div>
                        <div class = "order__price__value"><?= $order->price ?><span>р.</span>
                        </div>
                    </div>
                </div>
                <div class = "order__detail">
                    <a href="" order-id="<?= $order->id ?>">Подробнее ></a>
                </div>
                <div class = "order__actions">
                    <a class = "order__actions__edit" href="/site/create-order?c=<?= $order->access_code ?>">Изменить</a>
                    <a class = "order__actions__cancel cancel-order" href="" access-code="<?= $order->access_code ?>">Отменить</a>
                </div>
            </div>
        <?php }
    }else { ?>
        <div class="empty-text">У вас нет активных заказов</div>
    <?php } ?>
</div>
<div id="order-detail-container">

</div>
<?php /*
<div class = "order-detail">
    <div class="order-detail__topline">
        <div class="order-detail__topline-title">Информация о заказе</div>
        <div class="order-detail__actions">
            <a class="order-detail__actions__edit" href="#">Изменить</a>
            <a class="order-detail__actions__cancel" href="#">Отменить</a>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11px" height="11px" class="order-detail__topline-close">
            <image x="0px" y="0px" width="11px" height="11px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAQAAAADpb+tAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfjCgwRHwH725PaAAAAx0lEQVQI1zXPvS6DUQCA4ec46XcDxuMKXIArsDYxuQIJ8RMiSLRputDoYCASBg0mkyuwGlS6kFRil6aDjRCNfMdQ3ht484SZnutwlH/8V1FXjVOTdg08KyEUltScxHRnpG2grwxFXrYXNpzFRNfIvlcvFkPTtg4xIdz7tGXafGjowEQQ5OxYz4LbfDH+xgSFVXNuzIYPfSUxCYU1DTWtkPOBN0/KmAormmHTFR58aRnqx7Sjbt3lH6brXdt3TIdOnY8x4FFF9RfiuD2T4K923QAAAABJRU5ErkJggg=="></image>
        </svg>
    </div>
    <div class = "order-detail__content">
        <div class="reservation-step reservation-step--first">
            <div class="reservation-step-line reservation-step-line_departure">
                <div class="reservation-step-line-row">
                    <span></span>
                </div>
                <div class="reservation-step-line-content">
                    <div class="reservation-step-line-content-top">
                        <div id="city-from-block" class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready1 d-b">
                        <div class="reservation-step-line-wrap">
                            <div class="reservation-step-line-title">
                            Казань</div>
                        </div>
                        <div class="reservation-step-line-confirmed">время посадки подтверждено</div>
                    </div>
                    <div class="reservation-step-line-content-top-right">
                        <div class="reservation-step-line-time">18:40</div>
                            <div class="reservation-step-line-date">18 янв</div>
                        </div>
                    </div>
                    <div class="reservation-step-line-map reservation-step-line-map--address">
                        <div id="ya-map-from-static"></div>
                    </div>
                </div>
            </div>
            <div class="reservation-step-line reservation-step-line_arrival">
                <div class="reservation-step-line-row reservation-step-line-row2">
                    <span></span>
                </div>
                <div class="reservation-step-line-content">
                    <div class="reservation-step-line-content-top">
                        <div id="city-to-block" class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready2 d-b">
                            <div class="reservation-step-line-wrap">
                                <div class="reservation-step-line-title">Альметьевск...</div>
                            </div>
                            <div class="reservation-step-line-undertitle reservation-step-line-dest reservation-step-line-dest-address">Валентина, Герцена</div>
                        </div>
                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-time">~ 22:00</div>
                            <div class="reservation-step-line-date">18 янв</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reservation-step-hatch"></div>
        </div>
        <div class="reservation-step">
            <div class="reservation-step-info d-b">
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Заказчик:</div>
                    <div class="reservation-step-info_value">Ахмадиев Артур, +7-917-939-7393</div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Пассажиры:</div>
                    <div class="reservation-step-info_value">ВЗР - 1, ДЕТИ - 2, свое детское кресло</div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Информация о багаже:</div>
                    <div class="reservation-step-info_value">Нет</div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Сообщение для оператора:</div>
                    <div class="reservation-step-info_value">Нет</div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_deadline">Прибытие поезда в 14:00</div>
                </div>
            </div>
        </div>
        <div class="reservation-step">
            <div class="reservation-prices">
                <div class="container">
                    <div class="reservation-price d-b">
                        <div class="reservation-price__title"><b class="reservation-price__one-price">2</b> рублей за место</div>
                        <div class="reservation-price__subtitle">Итого: <b class="reservation-price__price">2</b> р.</div>
                        <div id="make-simple-payment-checkorderpage" class="reservation-price__button" access_code="2joaJpSzwFPW7pzFvCl2MY3PwI3gSaLl">Оплатить сейчас</div>
                    </div>
                </div>

                <div class="container">
                    <div class="reservation-price reservation-price--cash d-b">
                        <div class="reservation-price__title"><b class="reservation-price__cash-price">500</b> рублей</div>
                        <div class="reservation-price__subtitle">При оплате наличными</div>
                        <div id="but_reservation" class="reservation-price__button" access_code="2joaJpSzwFPW7pzFvCl2MY3PwI3gSaLl">Продолжить без оплаты</div>
                        <div class="reservation-price__label">Доступно авторизованным пользователям</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 */ ?>