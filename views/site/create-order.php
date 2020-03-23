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

// echo "model:<pre>"; print_r($model); echo "</pre>";
//echo "errors:<pre>"; print_r($model->getErrors()); echo "</pre>";

$aDays = ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'];

$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];

$aMonthsFull = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
?>
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        //'client-ext-id' => $model->id,
        'client-ext-code' => $model->access_code,
        'direction-id' => $model->direction_id,
        'time' => $model->time .', в '. $aDays[intval(date('w', $model->data))] .'. '. date('d', $model->data) .' '. $aMonthsFull[intval(date('m', $model->data))] .' '. date('Y', $model->data) .' г'
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



<div class="container">
    <div class="reservation-average d-n">
        <div class="reservation-average__title">Расчетное время в пути</div>
        <div class="reservation-average__time">3 ч 10 мин</div>
        <div class="reservation-average__small">в хороших погодных условиях</div>
    </div>
</div>

<div id="dop-data" class="reservation-form reservation-form--step1">
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
                        <div class="reservation-item__checkbox-wrap">
                            <input type="checkbox" name="" id="reservation-item__checkbox-4" class="reservation-item__checkbox">
                            <label for="reservation-item__checkbox-4" class="reservation-item__checkbox-label">Дополнительные пожелания</label>
                        </div>
                        <div class = "reservation-item__textarea">
                            <textarea disabled="true"></textarea>
                        </div>
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
<div class="reservation-calc">
    <div class="reservation-popup reservation-popup-calc">
        <div class="reservation-popup__title">
            <div class="reservation-popup__title-text">Пассажиры</div>
            <img src="/images_new/passengers.png" alt="" class="reservation-popup__title-img">
        </div>
        <ul class="reservation-popup__list">
            <li class="reservation-popup__item-big">
                <div class="reservation-popup__item-wrap">
                    <div class="reservation-popup__item-text">Взрослый</div>
                    <div class="reservation-popup__counter">
                        <div class="reservation-popup__counter-minus" field-type="adult">-</div>
                        <div class="reservation-popup__counter-num"><?= ($model->places_count - $model->child_count - $model->student_count) ?></div>
                        <div class="reservation-popup__counter-plus" field-type="adult">+</div>
                    </div>
                </div>
            </li>
            <li class="reservation-popup__item-big reservation-popup__item-big-child children_append">
                <div class="reservation-popup__item-wrap">
                    <input name="ClientExt[child_count]" type="hidden" value="<?= $model->child_count ?>">
                    <div class="reservation-popup__item-text">Ребенок</div>
                    <div class="reservation-popup__counter reservation-popup__counter-child">
                        <div class="reservation-popup__counter-minus" field-type="child">-</div>
                        <div class="reservation-popup__counter-num"><?= $model->child_count ?></div>
                        <div class="reservation-popup__counter-plus" field-type="child">+</div>
                    </div>
                </div>

                <div id="children_wrap_etalon" style="display: none;">
                    <div class="children">
                        <div class="children__placeholder">
                            <button class="children__title text_14" type="button" name="age" value="">
                                <span>Выберите возраст ребенка</span>
                                <svg class="icon icon-right-arrow children__icon"><use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use></svg>
                            </button>
                            <div class="children__list">
                                <?php foreach (ClientExtChild::getAges() as $age_key => $age_value) { ?>
                                    <button class="children__item text_16" type="button" name="select" value="<?= $age_key ?>"><?= $age_value ?></button>
                                    <?php if($age_key < count(ClientExtChild::getAges()) - 1) { ?>
                                        <br>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="children__checkbox">
                            <button class="children__btn check_active" type="button" name="self_baby_chair"></button>
                            <span class="text_14">Свое детское кресло</span>
                        </div>
                    </div>
                </div>
                <?php if(count($client_ext_childs) > 0) {
                    foreach ($client_ext_childs as $client_ext_child) { ?>
                        <div class="children_wrap">
                            <div class="children">
                                <div class="children__placeholder">
                                    <button class="children__title text_14" type="button" name="age" value="">
                                        <span class="children_complete" value="<?= $client_ext_child->age ?>"><?= $client_ext_child->getAgeName() ?></span>
                                        <svg class="icon icon-right-arrow children__icon">
                                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                                        </svg>
                                    </button>
                                    <div class="children__list">
                                        <?php foreach (ClientExtChild::getAges() as $age_key => $age_value) { ?>
                                            <button class="children__item text_16" type="button" name="select" value="<?= $age_key ?>"><?= $age_value ?></button><br>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="children__checkbox">
                                    <button class="children__btn <?= ($client_ext_child->self_baby_chair == true ? 'check_active' : '') ?>" type="button" name="self_baby_chair"></button>
                                    <input type="checkbox" name="self_baby_chair" hidden><span class="text_14">Свое детское кресло</span>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </li>
        </ul>
    </div>
    <div class="reservation-calc__wrap">
        <div class="reservation-calc__line">
            <div class="reservation-calc__line-wrap">
                <input name="ClientExt[places_count]" type="hidden" value="<?= $model->places_count ?>">
                <div class="reservation-calc__label">Мест:</div>
                <div class="reservation-calc__counter">
                    <div class="reservation-calc__counter-plus">+</div>
                    <div class="reservation-calc__counter-num"><?= $model->places_count ?></div>
                    <div class="reservation-calc__counter-minus">-</div>
                </div>
            </div>
        </div>
        <div class="reservation-calc__line reservation-calc__line--second">
            <div class="reservation-calc__line-wrap">
                <div class="reservation-calc__label">Стоимость</div>
                <div class="reservation-calc__price"><?= $model->getCalculatePrice('unprepayment'); ?></div>
            </div>
            <div class="reservation-calc__subline text_22">при оплате банковской картой</div>
        </div>
    </div>
    <div class="reservation-calc__button-wrap">
        <div class="reservation-calc__button-price">0</div>
        <button id="submit-create-order-step-1" class="reservation-calc__button reservation-calc__button--disabled text_24">Продолжить</button>
    </div>
</div>

<div id="peoples-mobile" class="mobile_menu">
    <div class="modal_global">
        <div class="modal_global__name">
            <span class="text_22">Пассажиры</span>
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
                        <div class="select__title text_18">Взрослый</div>
                        <div class="reservation-popup__counter">
                            <div class="reservation-popup__counter-minus text_24" field-type="adult">-</div>
                            <div class="reservation-popup__counter-num text_18"><?= ($model->places_count - $model->child_count - $model->student_count) ?></div>
                            <div class="reservation-popup__counter-plus text_24" field-type="adult">+</div>
                        </div>
                    </div>
                </div>
                <div class="modal_global__input children_append">
                    <div class="select__wrap">
                        <div class="select__title text_18">Ребенок до 10 лет</div>
                        <div class="reservation-popup__counter">
                            <div class="reservation-popup__counter-minus text_24" field-type="child">-</div>
                            <div class="reservation-popup__counter-num text_18"><?= $model->child_count ?></div>
                            <div class="reservation-popup__counter-plus text_24" field-type="child">+</div>
                        </div>
                    </div>
                    <?php if(count($client_ext_childs) > 0) {
                        foreach ($client_ext_childs as $client_ext_child) { ?>
                            <div class="children_wrap">
                                <div class="children">
                                    <div class="children__placeholder">
                                        <button class="children__title text_14" type="button" name="age" value="">
                                            <span class="children_complete" value="<?= $client_ext_child->age ?>"><?= $client_ext_child->getAgeName() ?></span>
                                            <svg class="icon icon-right-arrow children__icon">
                                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                                            </svg>
                                        </button>
                                        <div class="children__list">
                                            <?php foreach (ClientExtChild::getAges() as $age_key => $age_value) { ?>
                                                <button class="children__item text_16" type="button" name="select" value="<?= $age_key ?>"><?= $age_value ?></button><br>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="children__checkbox">
                                        <button class="children__btn <?= ($client_ext_child->self_baby_chair == true ? 'check_active' : '') ?>" type="button" name="self_baby_chair"></button>
                                        <input type="checkbox" name="self_baby_chair" hidden><span class="text_14">Свое детское кресло</span>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="modal_global__bottom">
                <button id="close-peoples-mobile" data-izimodal-close="" class="modal_global__submit text_16" type="button">Продолжить</button>
            </div>
        </div>
    </div> 
</div>
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
