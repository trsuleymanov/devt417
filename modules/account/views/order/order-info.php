<?php

$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];

use app\components\Helper;
use app\models\ClientExtChild; ?>
<div class="order-detail" order-id="<?= $model->id ?>">
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
    <div class="order-detail__content">
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
                                    <?= $model->cityFrom->name ?></div>
                            </div>
                            <div class="reservation-step-line-confirmed">время посадки подтверждено</div>
                        </div>
                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-time"><?= $model->time ?></div>
                            <div class="reservation-step-line-date"><?= intval(date('d', $model->data)) ?> <?= $aMonths[intval(date('m', $model->data))] ?></div>
                        </div>
                    </div>
                    <?php /*
                    <div class="reservation-step-line-map reservation-step-line-map--address">
                        <div id="ya-map-from-static"></div>
                    </div>*/ ?>
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
                                <div class="reservation-step-line-title"><?= $model->cityTo->name ?></div>
                            </div>
                            <div class="reservation-step-line-undertitle reservation-step-line-dest reservation-step-line-dest-address">
                                <?= $model->yandexPointTo->name.($model->yandexPointTo->description != "" ? ', '.$model->yandexPointTo->description : '') ?>
                            </div>
                        </div>
                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-time">
                                <?php
                                $aTimes = explode(':', $model->time);
                                $hours = intval($aTimes[0]) + 4;

                                if($hours >= 24) {
                                    $hours = $hours - 24;
                                    $model->data += 86400;
                                }
                                if($hours < 10) {
                                    $hours = '0'.$hours;
                                }
                                ?>

                                ~ <?= $hours.':'.$aTimes[1] ?></div>
                            <div class="reservation-step-line-date">
                                <?= intval(date('d', $model->data)) ?> <?= $aMonths[intval(date('m', $model->data))] ?>
                            </div>
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
                    <div class="reservation-step-info_value"><?= $model->last_name ?> <?= $model->first_name ?>, <?= $model->phone ?></div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Пассажиры:</div>
                    <div class="reservation-step-info_value">
                        <?php
                        $adult_count = $model->places_count - $model->student_count - $model->child_count;

                        $aRows = [];

                        if($adult_count > 0) {
                            $aRows[] = 'ВЗР - '.$adult_count;
                        }if($model->student_count > 0) {
                            $aRows[] = 'СТУД - '.$model->student_count;
                        }
                        if($model->child_count > 0) {
                            $self_baby_chair_count = 0;
                            $client_ext_childs = ClientExtChild::find()->where(['clientext_id' => $model->id])->all();
                            if(count($client_ext_childs) > 0) {
                                foreach ($client_ext_childs as $client_ext_child) {
                                    if($client_ext_child->self_baby_chair == true) {
                                        $self_baby_chair_count++;
                                    }
                                }
                            }
                            $row = 'ДЕТИ - '.$model->child_count;
                            if($self_baby_chair_count > 0) {
                                $row .= ', свое детское кресло';
                            }
                            if($self_baby_chair_count > 1) {
                                $row .= '('.$self_baby_chair_count.' шт.)';
                            }
                            $aRows[] = $row;
                        } ?>

                        <?= implode(', ', $aRows) ?>
                    </div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Информация о багаже:</div>
                    <div class="reservation-step-info_value">
                        <?php
                        $aRows = [];
                        if($model->suitcase_count > 0) {
                            $aRows[] = $model->suitcase_count.' '.Helper::getNumberString($model->suitcase_count, 'чемодан', 'чемодана', 'чемоданов');
                        }
                        if($model->bag_count > 0) {
                            $aRows[] = $model->bag_count.' '.Helper::getNumberString($model->bag_count, 'ручная кладь', 'ручные клади', 'ручных клади');
                        }
                        ?>
                        <?= implode(', ', $aRows) ?>
                    </div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_title">Сообщение для оператора:</div>
                    <div class="reservation-step-info_value">Нет</div>
                </div>
                <div class="reservation-step-info_row">
                    <div class="reservation-step-info_deadline">
                        <? if(!empty($model->time_air_train_arrival)) {
                            if($model->yandexPointFrom->alias == 'airoport') { ?>
                                Время прилета самолета <?= $model->time_air_train_arrival ?>
                            <? }else { ?>
                                Прибытие поезда в <?= $model->time_air_train_arrival ?>
                            <? }
                        }
                        if(!empty($model->time_air_train_departure)) {
                            if($model->yandexPointTo->alias == 'airoport') { ?>
                                Начало регистрации вылета <?= $model->time_air_train_departure ?>
                            <? }else { ?>
                                Отправление поезда в <?= $model->time_air_train_departure ?>
                            <? }
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <? if($model->is_paid != 1) { ?>
            <div class="reservation-step">
                <div class="reservation-prices">
                    <div class="container">
                        <div class="reservation-price d-b">
                            <div class="reservation-price__title"><b class="reservation-price__one-price"><?= $model->getCalculatePrice('prepayment', 1) ?></b> рублей за место</div>
                            <div class="reservation-price__subtitle">Итого: <b class="reservation-price__price"><?= $model->getCalculatePrice('prepayment') ?></b> р.</div>
                            <div class="reservation-price__button make-simple-payment-checkorderpage" access_code="<?= $model->access_code ?>">Оплатить сейчас</div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="reservation-price reservation-price--cash d-b">
                            <div class="reservation-price__title"><b class="reservation-price__cash-price"><?= $model->getCalculatePrice('unprepayment') ?></b> рублей</div>
                            <div class="reservation-price__subtitle">При оплате наличными</div>
                            <div class="reservation-price__button but_reservation" access_code="<?= $model->access_code ?>">Продолжить без оплаты</div>
                            <div class="reservation-price__label">Доступно авторизованным пользователям</div>
                        </div>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
</div>
