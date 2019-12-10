<?php

/* @var $this yii\web\View */

use app\components\Helper;
use app\models\City;
use app\models\ClientExt;
use app\models\Direction;
use app\models\Passenger;
use app\models\Trip;
use app\models\User;
use app\widgets\SelectWidget;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Рейс '.$trip->mid_time.'';
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends' => 'app\assets\AppAsset']);

$search_form_is_submitted = true;

$direction = $trip->direction;
$city_from = $direction->cityFrom;
$city_to = $direction->cityTo;

$point_from = $city_from->name;
$point_to = $city_to->name;
$point_from_error = '';
$point_to_error = '';
$date = date('d-m-Y', $trip->date);

$direction_id = $trip->direction_id;

?>
<?= $this->render('/layouts/header', [
    'search_form_is_submitted' => $search_form_is_submitted,
    'point_from' => $point_from,
    'point_from_error' => '',
    'point_to' => $point_to,
    'point_to_error' => '',
    'date' => $date,
    'date_error' => ''
]) ?>

<?php


$passenger = new Passenger();

?>

<div id="page-content">
    <form id="trip-form" class="trip" trip-id="<?= $trip->id ?>" direction-id="<?= $trip->direction_id ?>" target="autofill_save" method="post">
        <?php /*
        <section class="page-section trip-ride-section">
            <div class="ride-preview">
                <div class="ride-preview-col">
                    <div class="ride-thread  ride-preview-thread">
                        <div class="ride-thread-row ride-thread-row_first">
                            <div class="ride-thread-col ride-thread-col_time">
                                <div class="ride-thread-time">16:00</div>
                                <div class="ride-thread-date">25 окт.</div>
                            </div>
                            <div class="ride-thread-col ride-thread-col_title">
                                <a target="_blank" data-index="0" type="" class="y-link y-link_theme_normal ride-thread-title ride-thread-title_link" href="#">Москва, автостанция Красногвардейская</a>
                                <div class="ride-thread-subtitle">авт.вкз. Москва, автостанция Красногвардейская, Москва, Москва и Московская область, Россия</div>
                            </div>
                        </div>
                        <div class="ride-thread-row ">
                            <div class="ride-thread-col ride-thread-col_time">
                                <div class="ride-thread-time">03:30</div>
                                <div class="ride-thread-date">26 окт.</div>
                            </div>
                            <div class="ride-thread-col ride-thread-col_title">
                                <div class="ride-thread-title">Санкт-Петербург</div>
                            </div>
                        </div>
                    </div>
                    <div class="ride-local-time-label ride-preview-local-time-label">Время отправления и прибытия <span class="ride-local-time-label-wide">—</span> местное</div>
                </div>
                <div class="ride-description">
                    <div class="ride-facts ">
                        <div><span class="ride-facts-label">Рейс:</span>Красногвардейская АС — Санкт-Петербург</div>
                        <div><span class="ride-facts-label">Перевозчик:</span><span>ООО "Беркут"</span></div>
                        <div><span class="ride-facts-label">Транспорт:</span>Автобус 53 места ( Баг: 106, Стоя: 0 )  </div>
                        <div><span class="ride-facts-label">Партнер:</span>Е-траффик</div>
                    </div>
                    <div class="ride-expandable-refund-info ride-description-refund-info">
                        <span class="y-link y-link_theme_normal ride-expandable-refund-info-toggle">Прочие условия</span>
                    </div>
                </div>
            </div>
        </section>
        */ ?>

        <div class="trip-section-wrap">
            <div class="page">
                <div class="trip-section">
                    <h1 class="page-title">Заполните данные пассажиров</h1>
                    <div class="trip-tickets-body">
                        <?php
                        echo $this->render('passenger-form', [
                            'passenger' => $passenger,
                        ]);
                        echo Html::submitButton('Добавить пассажира', ['class' => 'btn btn-default', 'id' => 'add-passenger']);
                        ?>
                    </div>
                </div>
            </div>
        </div>



        <div class="trip-section-wrap">
            <div class="page">
                <div class="trip-section">
                    <h1 class="page-title">Укажите контактные данные</h1>
                    <div class="trip-contacts-body">
                        <div class="form-input  trip-contact-phone">
                            <label class="form-input-label">Телефон</label>
                            <div class="y-input y-input_theme_normal y-input_clearable y-input_size_m">
                                <?php
//                                echo Html::activeTextInput($user, 'phone', ['class' => "form-control"])
//                                    ->widget(\yii\widgets\MaskedInput::class, [
//                                        'mask' => '+7-999-999-9999',
//                                        'options' => [],
//                                        'clientOptions' => [
//                                            'placeholder' => '*',
//                                        ]
//                                    ]);

                                echo MaskedInput::widget([
                                    'name' => 'User[phone]',
                                    'mask' => '+7-999-999-9999',
                                    'value' => $user->phone,
                                    'clientOptions' => [
                                        'placeholder' => '*',
                                    ]
                                ]);

                                ?>
                            </div>
                            <?php /*
                            <span class="form-input-label-below">Это телефон, который вы привязали к аккаунту на Яндексе.</span>
                            */ ?>
                        </div>
                        <div class="form-input  trip-contact-email">
                            <label class="form-input-label" for="contact-email">Email</label>
                            <div class="y-input y-input_theme_normal y-input_clearable y-input_size_m">
                                <?php
                                $options = ['class' => "form-control"];
                                if(!empty($user->email)) {
                                    $options['disabled'] = true;
                                }
                                echo Html::activeTextInput($user, 'email', $options);
                                ?>
                            </div>
                        </div>
                        <?php /*
                        <div class="trip-contacts-label">На e-mail будут отправлены данные о заказе.</div>
                        */ ?>
                    </div>


                    <br />
                    <div class="trip-contacts-body">
                        <div class="form-input">
                            <label class="form-input-label">Откуда</label>
                            <a id="select-yandex-point-from" href="#" class="label-vertical">выбрать на карте</a>
                            <div class="y-input y-input_theme_normal y-input_clearable y-input_size_m">
                                <?php
                                echo SelectWidget::widget([
                                    'model' => $client_ext,
                                    'attribute' => 'yandex_point_from_id',
                                    //'attribute' => 'yandex_point_from',
                                    'name' => 'yandex_point_from_id',
                                    'options' => [
                                        'name' => 'ClientExt[yandex_point_from]',
                                        'placeholder' => 'Выберите точку',
                                        //'style' => 'padding-top: 0;'
                                    ],
                                    'ajax' => [
                                        'url' => '/yandex-point/ajax-yandex-points?is_from=1',
                                        'data' => new JsExpression('function(params) {
                                            return {
                                                search: params.search,
                                                direction_id: "'.$direction_id.'"
                                            };
                                        }'),
                                    ],
                                ]);

//                                echo $form->field($client_ext, 'yandex_point_from_id')->widget(SelectWidget::className(), [
//                                    //'value' => $value,
//                                    'options' => [
//                                        //'id' => 'clientext-yandex_point_from',
//                                        //'name' => 'ClientExt[yandex_point_from]',
//                                        'placeholder' => 'Введите название...',
//                                        //'id' => 'yandex_point_from',
//                                    ],
//                                    'ajax' => [
//                                        'url' => '/yandex-point/ajax-yandex-points?is_from=1',
//                                        'data' => new JsExpression('function(params) {
//                                            return {
//                                                search: params.search,
//                                                direction_id: "'.$direction_id.'"
//                                            };
//                                        }'),
//                                    ],
//                                ])->label(false);

                                //echo $form->field($client_ext, 'yandex_point_from_id', [])->textInput();
                                ?>
                            </div>
                        </div>
                        <div class="form-input">
                            <label class="form-input-label" for="contact-email">Куда</label>
                            <a id="select-yandex-point-to" href="#" class="label-vertical">выбрать на карте</a>
                            <div class="y-input y-input_theme_normal y-input_clearable y-input_size_m">
                                <?php
                                echo SelectWidget::widget([
                                    'model' => $client_ext,
                                    'attribute' => 'yandex_point_to_id',
                                    //'id' => 'clientext-yandex_point_to',
                                    'name' => 'yandex_point_to_id',
                                    'options' => [
                                        'name' => 'ClientExt[yandex_point_to]',
                                        'placeholder' => 'Выберите точку',
                                    ],
                                    'ajax' => [
                                        'url' => '/yandex-point/ajax-yandex-points?is_from=0',
                                        'data' => new JsExpression('function(params) {
                                            return {
                                                search: params.search,
                                                direction_id: "'.$direction_id.'"
                                            };
                                        }')
                                    ],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div id="final-text" class="trip-contacts-body">
                        Вам нужно быть в точке «<span id="point-from-name">АК БАРС</span>»&nbsp;<?= date("d", $trip->date) ?> <?= Helper::$awMonths[date("m", $trip->date)] ?> в&nbsp;<span id="time-confirm">10:20</span>
                    </div>

                    <br />
                    <div class="agreement">
                        <label for="agreement-checkbox" class="agreement-title">
                            <?= Html::checkbox('agreement-checkbox', false, []) ?> <span id="agreement-label">Я даю согласие на обработку персональных данных</span>
                        </label>
                        <div class="agreement-content">
                            <div class="agreement-text">Я даю свое согласие на передачу в ООО «Яндекс.Автобусы» (ОГРН: 1177746347591) моих персональных данных и согласен с тем, что они будут обрабатываться в соответствии с Федеральным законом от 27.07.2006 N 152-ФЗ «О персональных данных» на условиях и для целей, определенных <a tabindex="-1" target="_blank" type="" class="y-link y-link_theme_normal " href="https://yandex.ru/legal/confidential/">Политикой конфиденциальности</a>, в том числе для целей реализации (оформления) автобусных билетов, а также я даю свое согласие на передачу моих персональных данных третьим лицам исключительно для целей реализации (оформления) автобусных билетов.</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="trip-section-wrap">
            <div class="page">
                <div class="pay-form">
                    <div class="pay-form-table">
                        <div class="pay-form-total">
                            <div class="pay-form-item pay-form-item_total">
                                <span class="pay-form-item-name">К оплате:</span>&nbsp;&nbsp;&nbsp;<span id="total-price" class="pay-form-item-value"></span>
                            </div>
                        </div>
                    </div>
                    <div class="pay-form-action">
                        <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                            <span class="y-button-text">Забронировать и оплатить</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <?php /*
        <div class="trip-section-wrap">
            <div class="page">
                <div class="trip-section">
                    <div class="trip-promocode">
                        <div class="form-input  trip-promocode-input">
                            <label class="form-input-label">Промокод, если есть</label>
                            <div class="y-input y-input_theme_normal y-input_size_m y-input_width_ y-input_empty ">
                                <div class="y-input-box">
                                    <input spellcheck="false" aria-invalid="false" cols="10" class="y-input-control" value="" type="text">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="y-button y-button_theme_action y-button_size_m y-button_type_button trip-promocode-button" role="button" aria-haspopup="true">
                            <span class="y-button-text">Применить</span>
                        </button>
                    </div>
                    <div class="pay-form">
                        <div class="pay-form-table">
                            <div class="pay-form-total">
                                <div class="pay-form-item pay-form-item_total">
                                    <span class="pay-form-item-name">К оплате:</span>
                                    <span class="pay-form-item-whitespace"></span>
                                    <span class="pay-form-item-value">1&nbsp;100&nbsp;₽</span>
                                </div>
                            </div>
                            <div class="pay-form-item">
                                <span class="pay-form-item-name">Включая сервисные сборы</span>
                                <span class="pay-form-item-whitespace"></span>
                                <span class="pay-form-item-value">0&nbsp;₽</span>
                            </div>
                        </div>
                        <div class="pay-form-action">
                            <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                                <span class="y-button-text">Забронировать и оплатить</span>
                            </button>
                            <div>
                                <div class="pay-form-action-info">Оплата банковскими картами</div>
                                <span class="pay-form-card pay-form-card_maestro"></span>
                                <span class="pay-form-card pay-form-card_mastercard"></span>
                                <span class="pay-form-card pay-form-card_visa"></span>
                                <span class="pay-form-card pay-form-card_mir"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        */ ?>
    </form>


</div>

<?= $this->render('/layouts/footer') ?>
