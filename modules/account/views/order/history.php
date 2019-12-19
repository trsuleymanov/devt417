<?php

use app\components\Helper;
use yii\web\ForbiddenHttpException;

$this->registerCssFile('css/account/lk.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('js/account/order.js', ['depends'=>'app\assets\NewAppAsset']);
?>

<div class="reservation__menu">
    <div class = "reservation_menu__title">История заказов</div>
    <?php
    if(count($orders) > 0) {
        foreach ($orders as $order) {

            if (in_array($order->status, ['canceled_by_client', 'canceled_by_operator', 'canceled_auto'])) {
                $order_class = 'history__order__canceled';
            } elseif ($order->status == 'sended') {

                if ($order->is_paid == true && $order->yandexPointFrom != null && $order->yandexPointFrom->super_tariff_used == true) {
                    $order_class = 'history__order__action';
                } else {
                    $order_class = 'history__order__finished';
                }
            }

            $aTime = explode(':', $order->time);
            $datetime = $order->data + 3600 * intval($aTime[0]) + 60 * intval($aTime[1]);

            $trip = $order->trip;
            $tariff = $trip->tariff;
            ?>


            <div class="history__order <?= $order_class ?>">
                <div class="order__direction">
                    <span>
                        <?= $order->direction_id == 1 ? 'Альметьевск-Казань' : 'Казань-Альметьевск' ?>
                    </span>
                </div>
                <div class="order__info">
                    <div class="order__date">
                        <?= Helper::getMainDate($datetime, 1) ?>
                    </div>
                    <div class="order__tickets">
                        /мест: <?= $order->places_count ?>
                    </div>
                </div>
                <div class="order__departure">
                    <div class="order__departure__title">
                        Место посадки
                    </div>
                    <div class="order__departure__value">
                        <?= $order->yandex_point_from_name ?>
                    </div>
                </div>
                <div class="order__price">
                    <?php if ($order_class == 'history__order__action') { ?>
                        <?php if($tariff != null) { ?>
                            <div class="order__price__row order__price__row_total">
                                <div class="order__price__title">
                                    Цена за место:
                                </div>
                                <div class="order__price__value">
                                    <?= ($tariff->superprepayment_common_price + $tariff->superprepayment_reservation_cost) ?><span>р.</span>
                                </div>
                            </div>
                            <div class="order__price__row">
                                <div class="order__price__title">
                                    Общая скидка:
                                </div>
                                <div class="order__price__value">
                                    0<span>р.</span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } elseif ($order_class == 'history__order__canceled') { ?>
                        <div class="order__price__row order__price__row_total">
                            <div class="order__price__title">
                                Поездка отменена
                            </div>
                        </div>
                        <div class="order__price__row">
                            <div class="order__price__title">
                                Кэш-бек:
                            </div>
                            <div class="order__price__value">
                                <?= $order->accrual_cash_back ?><span>р.</span>
                            </div>
                        </div>
                    <?php } elseif ($order_class == 'history__order__finished') { ?>
                        <div class="order__price__row order__price__row_total">
                            <div class="order__price__title">
                                Цена за место:
                            </div>
                            <div class="order__price__value">
                                <?= $order->price ?><span>р.</span>
                            </div>
                        </div>
                        <div class="order__price__row">
                            <div class="order__price__title">
                                Кэш-бек:
                            </div>
                            <div class="order__price__value">
                                <?= $order->accrual_cash_back ?><span>р.</span>
                            </div>
                        </div>
                    <?php } ?>
                 </div>
            </div>
        <?php }
    }else { ?>

        <?php /*
        <div class="history__order history__order__canceled"> 
            <div class="order__direction">
                <span>Альметьевск-Казань</span>
            </div>
            <div class="order__info">
                <div class="order__date">
                    вт, 19 ноября, 12:33
                </div>
                <div class="order__tickets">
                    /мест: 1
                </div>
            </div>
            <div class="order__departure">
                <div class="order__departure__title">Место посадки</div>
                <div class="order__departure__value">После мечети ост, мкр. Урсала</div>
            </div>
            <div class="order__price">
                <div class="order__price__row order__price__row_total">
                    <div class="order__price__title">Поездка отменена</div>
                </div>
                <div class="order__price__row">
                    <div class="order__price__title">Кэш-бек:</div>
                    <div class="order__price__value">0.00<span>р.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="history__order history__order__action"> 
            <div class="order__direction">
                <span>Альметьевск-Казань</span>
            </div>
            <div class="order__info">
                <div class="order__date">
                    вт, 19 ноября, 12:33
                </div>
                <div class="order__tickets">
                    /мест: 1
                </div>
            </div>
            <div class="order__departure">
                <div class="order__departure__title">Место посадки</div>
                <div class="order__departure__value">После мечети ост, мкр. Урсала</div>
            </div>
            <div class="order__price">
                <div class="order__price__row order__price__row_total">
                    <div class="order__price__title">Цена за место:</div>
                    <div class="order__price__value">420<span>р.</span>
                    </div>
                </div>
                <div class="order__price__row">
                    <div class="order__price__title">Кэш-бек:</div>
                    <div class="order__price__value">0.00<span>р.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="history__order history__order__finished"> 
            <div class="order__direction">
                <span>Альметьевск-Казань</span>
            </div>
            <div class="order__info">
                <div class="order__date">
                    вт, 19 ноября, 12:33
                </div>
                <div class="order__tickets">
                    /мест: 1
                </div>
            </div>
            <div class="order__departure">
                <div class="order-_departure__title">Место посадки</div>
                <div class="order__departure__value">После мечети ост, мкр. Урсала</div>
            </div>
            <div class="order__price">
                <div class="order__price__row order__price__row_total">
                    <div class="order__price__title">Цена за место:</div>
                    <div class="order__price__value">420<span>р.</span>
                    </div>
                </div>
                <div class="order__price__row">
                    <div class="order__price__title">Кэш-бек:</div>
                    <div class="order__price__value">0.00<span>р.</span>
                    </div>
                </div>
            </div>
        </div>*/ ?>

        <div class="empty-text">У вас нет в истории заказов</div>
    <?php } ?>
</div>