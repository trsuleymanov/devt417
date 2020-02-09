<?php

use app\models\ClientExtChild;
use yii\web\JsExpression;
use app\widgets\SelectWidget;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=5c7acdc8-48c9-43d9-9f44-2e6b9e178101', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/libs/bscroll.min.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/libs/rolltime.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/create-order.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);

$this->registerCssFile('/libs/rolltime.css', ['depends'=>'app\assets\NewAppAsset']);



$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
?>
<div id="order-step-1">
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        'client-ext-code' => $model->access_code,
        'direction-id' => $model->direction_id,
        'time' => $model->time,
    ]
]);
?>
<input name="ClientExt[trip_id]" type="hidden" value="<?= $model->trip_id ?>" />
<div class="reservation-top">
    <div class="container">
        <div class="reservation-title-main">
            <a href="/"><img src="/images_new/back-top.svg" alt="" class="reservation-back"></a>

            <div class="reservation-title-wrap">
                <div class="reservation-title">Бронирование мест</div>
                <div class="reservation-undertitle reservation-undertitle--1">Шаг 1 из 3 - Создание заказа</div>
            </div>
        </div>
        <div class="mobile-burger">
            <button class="burger" type="button" name="burger" data-izimodal-open="#menu">
                <div class="burger-line"></div>
                <div class="burger-line"></div>
                <div class="burger-line"></div>
            </button>
        </div>
        <div class="reservation-menu">
            <ul class="reservation-menu__list">
                <li class="nav__item reservation-menu__item"><a class="nav__link" href="/#new-order">новый заказ</a></li>
                <li class="nav__item reservation-menu__item"><a class="nav__link" href="/#terms">условия</a></li>
                <li class="nav__item reservation-menu__item"><a class="nav__link" href="/#information">правовая информация</a></li>
                <li class="nav__item reservation-menu__item"><a class="nav__link" href="/">417417.ru</a></li>
            </ul>
            <div class="header__enter header__enter--mob"><a class="header__login text_20" href="#">
                    <svg class="icon icon-user header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                    </svg>Войти</a>
                <div class="for_enter_wrap for_enter_wrap--mob modal_enter">
                    <div class="for_enter">
                        <p class="for_enter__title">Для входа в личный кабинет введите номер телефона</p>
                        <input class="for_enter__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00"
                               autocomplete="off">
                        <button class="for_enter__submit test" type="button" name="submit">Продолжить</button>
                    </div>
                </div>
                <div class="for_enter_wrap for_enter_wrap--mob modal_registration">
                    <div class="for_enter fix_height">
                        <input class="for_enter__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00"
                               autocomplete="off">
                        <input class="for_enter__input" type="email" name="email" placeholder="Введите Email"
                               autocomplete="off">
                        <input class="for_enter__input" type="password" name="phone" placeholder="Введите пароль"
                               autocomplete="off">
                        <div class="children__checkbox">
                            <button class="children__btn" type="button" name="check" data-name="Запомнить меня"></button>
                            <input type="checkbox" name="checkbox" hidden="">
                        </div>
                        <button class="for_enter__submit test-next" type="button"
                                name="submit">Продолжить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="reservation-form reservation-form--step1">
    <div class="container">
        <div class="reservation-step reservation-step--first">
            <div class="reservation-step-line reservation-step-line_departure js-showMap">
                <div class="reservation-step-line-row">
                    <span></span>
                </div>
                <div class="reservation-step-line-content">
                    <div class="reservation-step-line-content-top">

                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--empty1 <?= $model->yandexPointFrom != null ? 'd-n' : '' ?>">
                            <div id="city-from" city-id="<?= $model->city_from_id ?>" class="reservation-step-line-title">
                                <?= $model->cityFrom->name ?>
                            </div>
                            <div class="reservation-step-line-undertitle">
                                <?php if($model->yandexPointFrom != null) { ?>
                                    <input name="ClientExt[yandex_point_from_id]" critical-point="<?= $model->yandexPointFrom->critical_point ?>" alias="<?= $model->yandexPointFrom->alias ?>"  type="hidden" value="<?= $model->yandexPointFrom->id ?>" />
                                <? }else { ?>
                                    <input name="ClientExt[yandex_point_from_id]"  type="hidden" value="" />
                                <? } ?>
                                Выберите наиболее удобное место посадки в автобус
                            </div>
                        </div>

                        <div id="city-from-block" class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready1 <?= $model->yandexPointFrom != null ? 'd-b' : '' ?>">
                            <div class="reservation-step-line-wrap">
                                <div class="reservation-step-line-title">
                                    <?= $model->cityFrom->name ?>
                                </div>
                                <div class="reservation-step-line-showmap">на карте</div>
                            </div>
                            <div class="reservation-step-line-confirmed">время посадки подтверждено</div>
                            <div class="reservation-step-line-content-top-left reservation-step-line-address-wrap">
                                <?php if($model->yandexPointFrom != null) { ?>
                                    <div class="reservation-step-line-address"><?= $model->yandexPointFrom->name.($model->yandexPointFrom->description != "" ? ', '.$model->yandexPointFrom->description : '') ?></div>
                                    <div class="reservation-step-line-change">Изменить адрес посадки</div>
                                <?php }else { ?>
                                    <div class="reservation-step-line-address">---</div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-time">
                                <?= $model->time ?>
                            </div>
                            <div class="reservation-step-line-date">
                                <?= intval(date('d', $model->data)) ?> <?= $aMonths[intval(date('m', $model->data))] ?>
                            </div>
                        </div>
                    </div>

                    <? if( $model->cityFrom->extended_external_use ): ?>
                        <div class="reservation-step-line-selecte reservation-step-line-selecte--1 input-arrow <?= $model->yandexPointFrom != null ? 'd-n' : '' ?>">
                            <input id="open-select-point-from" data-external-use = "<?=$model->cityFrom->extended_external_use;?>" type="text" placeholder="Начните вводить адрес..." readonly>
                        </div>
                    <? else: ?>
                        <div class="reservation-step-line-selecte reservation-step-line-selecte--1 input-arrow <?= ($model->yandexPointTo != null ? 'd-n' : '') ?>">
                            <input id="open-select-point-from" data-external-use = "<?=$model->cityFrom->extended_external_use;?>" type="text" placeholder="Выберите из списка" readonly>
                        </div>
                    <? endif; ?>

                    <div class="reservation-step-line-map reservation-step-line-map--address">
                        <?php /*
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                        */ ?>
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
                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--empty2 <?= ($model->yandexPointTo != null ? 'd-n' : '') ?>">
                            <div id="city-to" city-id="<?= $model->city_to_id ?>" class="reservation-step-line-title">
                                <?= $model->cityTo->name ?>
                            </div>
                            <div class="reservation-step-line-undertitle">
                                <input name="ClientExt[yandex_point_to_id]" type="hidden" value="<?= ($model->yandexPointTo != null ? $model->yandexPointTo->id : '') ?>" />
                                Укажите пункт назначения
                            </div>
                        </div>
                        <div id="city-to-block" class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready2 <?= ($model->yandexPointTo != null ? 'd-b' : '') ?>">
                            <div class="reservation-step-line-wrap">
                                <div class="reservation-step-line-title">
                                    <?= $model->cityTo->name ?>
                                </div>
                                <div class="reservation-step-line-showmap">на карте</div>
                            </div>
                            <div class="reservation-step-line-undertitle reservation-step-line-dest reservation-step-line-dest-address">
                                пос. Кульшарипово
                            </div>
                            <div class="reservation-step-line-change2">Изменить</div>
                        </div>
                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-time">
                                <?
                                    $time = explode(':', $model->time);
                                    $date = $model->data + $time[0] * 3600 + $time[1] * 60 + 12000; // 12000 - длительность поездки в секундах
                                    $arrival = DateTime::createFromFormat('U', $date);
                                    $arrival->setTimeZone( new DateTimeZone( date_default_timezone_get() ) );
                                ?>
                                ~ <?= $arrival->format('H:i'); ?>
                            </div>
                            <div class="reservation-step-line-date">
                                <?= $arrival->format('j') ?> <?= $aMonths[intval($arrival->format('m'))] ?>
                            </div>
                        </div>
                    </div>

                    <div class="reservation-step-line-selecte reservation-step-line-selecte--2 input-arrow <?= ($model->yandexPointTo != null ? 'd-n' : '') ?>">
                        <input id="open-select-point-to" type="text" placeholder="Выберите из списка" readonly>
                    </div>

                    <div class="reservation-step-line-map reservation-step-line-map--dest">
                        <div id="ya-map-to-static"></div>
                    </div>
                </div>
            </div>
            <div class="reservation-step-hatch"></div>
        </div>

    </div>
    <div class="container container-drop--1">
        <div class="reservation-drop reservation-drop--1">
            <div class="reservation-drop__topline">
                <div class="reservation-drop__topline-title">Адрес и время посадки</div>
                <img src="/images_new/cancel.svg" alt="" class="reservation-drop__topline-cancel">
            </div>
            <div class="reservation-drop__content"></div>
        </div>
    </div>
    <div class="container container-drop--2">
        <div class="reservation-drop reservation-drop--2">
            <div class="reservation-drop__topline">
                <div class="reservation-drop__topline-title">Пункт назначения</div>
                <img src="/images_new/cancel.svg" alt="" class="reservation-drop__topline-cancel">
            </div>
            <div class="reservation-drop__content"></div>
        </div>
    </div>
</div>


<div class="container">
    <div class="reservation-average d-n">
        <div class="reservation-average__title">Расчетное время в пути</div>
        <div class="reservation-average__time">3 ч 10 мин</div>
        <div class="reservation-average__small">в хороших погодных условиях</div>
    </div>
</div>


<?php
if(($model->yandexPointFrom != null && $model->yandexPointFrom->critical_point == 1) || ($model->yandexPointTo != null && $model->yandexPointTo->critical_point == 1)) { ?>
    <div id="dop-data" class="reservation-form reservation-form--step1">
<? }else { ?>
    <div id="dop-data" style="display: none;" class="reservation-form reservation-form--step1">
<? } ?>
    <div class="container">
        <div class="reservation-step reservation-step--second">
            <ul class="reservation-tabs">
                <li class="reservation-tab reservation-tab--first reservation-tab--active">Доп. данные</li>
                <li class="reservation-tab reservation-tab--second">Условия бронирования<img src="/images_new/arrow-tab.png" alt="" class="reservation-tab__icon"></li>
            </ul>
            <div class="reservation-content">
                <ul class="reservation-list">

                    <? if($model->yandexPointFrom != null && $model->yandexPointFrom->critical_point == 1) { ?>
                        <li id="time-air-train-arrival-block" class="reservation-item">
                    <? }else { ?>
                        <li id="time-air-train-arrival-block" class="reservation-item" style="display: none;">
                    <? } ?>
                        <div class="reservation-item__checkbox-wrap">
                            <?php if(!empty($model->time_air_train_arrival)) { ?>
                                <input type="checkbox" id="reservation-item__checkbox-1" class="reservation-item__checkbox" checked >
                            <?php }else { ?>
                                <input type="checkbox" id="reservation-item__checkbox-1" class="reservation-item__checkbox" >
                            <?php } ?>
                            <label id="time-air-train-arrival-text" for="reservation-item__checkbox-1" class="reservation-item__checkbox-label">
                                <?  if($model->yandexPointFrom != null) { ?>
                                    <? if($model->yandexPointFrom->alias == 'airoport') { ?>
                                        Время прилета самолета
                                    <? }else { ?>
                                        Прибытие поезда
                                    <? } ?>
                                <? } ?>
                            </label>
                        </div>
                        <?php /*
                        <div class="reservation-popup reservation-popup-time">
                            <div class="reservation-popup__text">Время прибытия поезда</div>
                        </div>*/ ?>
                        <?php
                        echo $form->field($model, 'time_air_train_arrival', [
                                'options' => [
                                    'class' => 'reservation-item__input reservation-item__input-time',
                                    'style' => 'padding-top: 8px; padding-bottom: 9px;'
                                ],
                                'template' => '{input}'
                            ]
                        )
                            ->widget(\yii\widgets\MaskedInput::className(),
                                [
                                    'mask' => 'h:m',
                                    'definitions' => [
                                        'h' => [
                                            'cardinality' => 2,
                                            'prevalidator' => [
                                                ['validator' => '^([0-2])$', 'cardinality' => 1],
                                                ['validator' => '^([0-9]|0[0-9]|1[0-9]|2[0-3])$', 'cardinality' => 2],
                                            ],
                                            'validator' => '^([0-9]|0[0-9]|1[0-9]|2[0-3])$'
                                        ],
                                        'm' => [
                                            'cardinality' => 2,
                                            'prevalidator' => [
                                                ['validator' => '^(0|[0-5])$', 'cardinality' => 1],
                                                ['validator' => '^([0-5]?\d)$', 'cardinality' => 2],
                                            ]
                                        ]
                                    ],
                                    'options' => [
                                        'class' => 'form-control_ form-masked-input_ ',
                                        'style' => 'border: none; ',
                                        'disabled' => empty($model->time_air_train_arrival)
                                    ]
                                ])
                            ->label(false);
                        ?>
                    </li>


                    <? if($model->yandexPointTo != null && $model->yandexPointTo->critical_point == 1) { ?>
                        <li id="time-air-train-departure-block" class="reservation-item">
                    <? }else { ?>
                        <li id="time-air-train-departure-block" class="reservation-item" style="display: none;">
                    <? } ?>
                        <div class="reservation-item__checkbox-wrap">
                            <?php if(!empty($model->time_air_train_departure)) { ?>
                                <input type="checkbox" id="reservation-item__checkbox-2" class="reservation-item__checkbox" checked >
                            <?php }else { ?>
                                <input type="checkbox" id="reservation-item__checkbox-2" class="reservation-item__checkbox" >
                            <?php } ?>
                            <label id="time-air-train-departure-text" for="reservation-item__checkbox-2" class="reservation-item__checkbox-label">
                                <?  if($model->yandexPointTo != null) { ?>
                                    <? if($model->yandexPointTo->alias == 'airoport') { ?>
                                        Начало регистрации вылета
                                    <? }else { ?>
                                        Отправление поезда
                                    <? } ?>
                                <? } ?>
                            </label>
                        </div>
                        <?php
                        echo $form->field($model, 'time_air_train_departure', [
                                'options' => [
                                    'class' => 'reservation-item__input reservation-item__input-time',
                                    'style' => 'padding-top: 8px; padding-bottom: 9px;'
                                ],
                                'template' => '{input}'
                            ]
                        )
                            ->widget(\yii\widgets\MaskedInput::className(),
                                [
                                    'mask' => 'h:m',
                                    'definitions' => [
                                        'h' => [
                                            'cardinality' => 2,
                                            'prevalidator' => [
                                                ['validator' => '^([0-2])$', 'cardinality' => 1],
                                                ['validator' => '^([0-9]|0[0-9]|1[0-9]|2[0-3])$', 'cardinality' => 2],
                                            ],
                                            'validator' => '^([0-9]|0[0-9]|1[0-9]|2[0-3])$'
                                        ],
                                        'm' => [
                                            'cardinality' => 2,
                                            'prevalidator' => [
                                                ['validator' => '^(0|[0-5])$', 'cardinality' => 1],
                                                ['validator' => '^([0-5]?\d)$', 'cardinality' => 2],
                                            ]
                                        ]
                                    ],
                                    'options' => [
                                        'class' => 'form-control_ form-masked-input_ ',
                                        'style' => 'border: none; ',
                                        'disabled' => empty($model->time_air_train_departure)
                                    ]
                                ])
                            ->label(false);
                        ?>
                    </li>


                    <li class="reservation-item reservation-item-luggage">
                        <div class="reservation-item__checkbox-wrap">
                            <?php if($model->suitcase_count > 0 || $model->bag_count > 0) { ?>
                                <input type="checkbox" name="" id="reservation-item__checkbox-3" class="reservation-item__checkbox" checked>
                            <?php }else { ?>
                                <input type="checkbox" name="" id="reservation-item__checkbox-3" class="reservation-item__checkbox">
                            <?php } ?>
                            <label for="reservation-item__checkbox-3" class="reservation-item__checkbox-label">Багаж</label>
                        </div>
                        <div class="reservation-popup reservation-popup-luggage">
                            <ul class="reservation-popup__list">
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Чемодан</div>
                                    <div class="reservation-popup__counter">
                                        <div class="reservation-popup__counter-minus" field-type="suitcase">-</div>
                                        <div class="reservation-popup__counter-num"><?=intval($model->suitcase_count);?></div>
                                        <div class="reservation-popup__counter-plus" field-type="suitcase">+</div>
                                    </div>
                                </li>
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Ручная кладь</div>
                                    <div class="reservation-popup__counter">
                                        <div class="reservation-popup__counter-minus" field-type="bag">-</div>
                                        <div class="reservation-popup__counter-num"><?=intval($model->bag_count);?></div>
                                        <div class="reservation-popup__counter-plus" field-type="bag">+</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <?php if($model->suitcase_count > 0 || $model->bag_count > 0) { ?>
                            <input type="text" class="reservation-item__input reservation-item__input-luggage" readonly value="Чемоданы - <?= $model->suitcase_count ?>, ручная кл. - <?= $model->bag_count ?>">
                        <?php }else { ?>
                            <input type="text" class="reservation-item__input reservation-item__input-luggage" disabled="true" readonly value="Чемоданы - 0, ручная кл. - 0">
                        <?php } ?>
                        <input name="ClientExt[suitcase_count]" type="hidden" value="<?= $model->suitcase_count ?>" />
                        <input name="ClientExt[bag_count]" type="hidden" value="<?= $model->bag_count ?>" />
                    </li>
                    <li class = "reservation-item reservation-item_wishes">

                        <?php if(!empty($model->additional_wishes)) { ?>
                            <div class="reservation-item__checkbox-wrap">
                                <input type="checkbox" name="" id="reservation-item__checkbox-4" class="reservation-item__checkbox" checked>
                                <label for="reservation-item__checkbox-4" class="reservation-item__checkbox-label">Дополнительные пожелания</label>
                            </div>
                            <div class="reservation-item__textarea">
                                <textarea id="additional-wishes"><?= $model->additional_wishes ?></textarea>
                            </div>
                        <? }else { ?>
                            <div class="reservation-item__checkbox-wrap">
                            <input type="checkbox" name="" id="reservation-item__checkbox-4" class="reservation-item__checkbox">
                                <label for="reservation-item__checkbox-4" class="reservation-item__checkbox-label">Дополнительные пожелания</label>
                            </div>
                            <div class="reservation-item__textarea">
                                <textarea id="additional-wishes" disabled="true"><?= $model->additional_wishes ?></textarea>
                            </div>
                        <? } ?>

                    </li>
                </ul>
            </div>
            <div class="services reservation-services">
                <h3 class="services__title title_30">Условия предоставления услуг</h3>
                <p class="services__text text_18">Настоящая политика регламентирует порядок сбора и обработки сервисом «Максим» (далее — Сервис) персональных и иных конфиденциальных данных физических лиц с использованием средств автоматизации посредством сети Интернет.</p>
                <p class="services__sub text_18">Общие положения</p>
                <ul class="services__list">
                    <li class="services__item text_18" data-num="1.">В рамках настоящего документа используются следующие термины:</li>
                    <li class="services__item text_18" data-num="1.1">Персональные данные — любая информация, относящаяся прямо или косвенно к определенному или определяемому физическому лицу (субъекту персональных данных).</li>
                    <li class="services__item text_18" data-num="1.2">Сервис — лицо, самостоятельно организующее и (или) осуществляющее обработку персональных данных, а также определяющее цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</li>
                    <li class="services__item text_18" data-num="1.3">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                </ul>
                <ul class="services__list list_hidden">
                    <li class="services__item text_18" data-num="1.4">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="1.5">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="1.6">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="1.7">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="1.8">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="1.9">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                    <li class="services__item text_18" data-num="2.">Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: taximaxim.ru и taximaxim.com, corp.taximaxim.com.</li>
                </ul>
                <div class="services__btn">
                    <button class="services__read text_22" type="button" name="read">Читать полностью
                        <svg class="icon icon-right-arrow services__read__svg">
                            <!<use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="reservation-prices">
    <div class="container">
        <div class="reservation-price">
            <div class="reservation-price__title"><b class="reservation-price__one-price">417</b> рублей за место</div>
            <div class="reservation-price__subtitle">Итого: <b class="reservation-price__price">834</b> р.</div>
            <div class="reservation-price__button">Оплатить сейчас</div>
        </div>
    </div>

    <div class="container">
        <div class="reservation-price reservation-price--cash">
            <div class="reservation-price__title"><b class="reservation-price__cash-price">1 000</b> рублей</div>
            <div class="reservation-price__subtitle">При оплате наличными</div>
            <div class="reservation-price__button">Продолжить без оплаты</div>
            <div class="reservation-price__label">Доступно авторизованным пользователям</div>
        </div>
    </div>
</div>

<div class="hr"></div>

<!-- Окно пассажиров(десктопная версия) + мест/стоимость + кнопка "Продолжить" -->
<?= $this->render('_reservation-calc', [
    'model' => $model,
    'client_ext_childs' => $client_ext_childs,
    'step' => 1
]) ?>

<!-- Окно пассажиров - мобильная версия -->
<?= $this->render('_peoples-mobile', [
    'model' => $model,
    'client_ext_childs' => $client_ext_childs,
]) ?>

<div id="luggage-mobile" class="mobile_menu">
    <div class="modal_global">
        <div class="modal_global__name">
            <span class="text_22">Багаж</span>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
        <div class="modal_global__enter">
            <div class="modal_global__content">
                <div class="modal_global__input">
                    <div class="select__wrap">
                        <div class="select__title text_18">Чемодан</div>
                        <div class="reservation-popup__counter">
                            <div class="reservation-popup__counter-minus text_24" field-type="suitcase">-</div>
                            <div class="reservation-popup__counter-num text_18"><?=intval($model->suitcase_count);?></div>
                            <div class="reservation-popup__counter-plus text_24" field-type="suitcase">+</div>
                        </div>
                    </div>
                </div>
                <div class="modal_global__input">
                    <div class="select__wrap">
                        <div class="select__title text_18">Ручная кладь</div>
                        <div class="reservation-popup__counter">
                            <div class="reservation-popup__counter-minus text_24" field-type="bag">-</div>
                            <div class="reservation-popup__counter-num text_18"><?=intval($model->bag_count);?></div>
                            <div class="reservation-popup__counter-plus text_24" field-type="bag">+</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_global__bottom">
                <button data-izimodal-close="" class="modal_global__submit text_18" type="button">Продолжить</button>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
</div>