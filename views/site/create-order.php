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

$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
?>
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        //'client-ext-id' => $model->id,
        'client-ext-code' => $model->access_code,
        'direction-id' => $model->direction_id,
        'time' => $model->time
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
<!--
<form action="" class="reservation-form reservation-form--step1 reservation-form--step3">
-->
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
                        <?php /*
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                        */ ?>
                        <div id="ya-map-to-static"></div>
                    </div>
                </div>
            </div>
            <div class="reservation-step-hatch"></div>
            <?php /*
            <div class="reservation-step-info">
                <div class="reservation-step-info__arrival">Прибытие поезда в 14:00</div>
                <div class="reservation-step-info__name">Пассажир: Ахмадиев</div>
                <div class="reservation-step-info__places">Кол-во мест: 2 (1 взр., 1 ст.)</div>
                <div class="reservation-step-info__luggage">Багаж: чемоданы - 2, ручная кладь - 3</div>
                <div class="reservation-step-info__change">Изменить</div>
            </div>*/ ?>
        </div>

    </div>
    <div class="container container-drop--1">
        <div class="reservation-drop reservation-drop--1">
            <div class="reservation-drop__topline">
                <div class="reservation-drop__topline-title">Адрес и время посадки</div>
                <img src="/images_new/cancel.svg" alt="" class="reservation-drop__topline-cancel">
            </div>
            <div class="reservation-drop__content">
                <?php /*
                <div class="reservation-drop-offer">
                    <div class="reservation-drop-offer__cover">
                        <div class="reservation-drop-offer__cover-wrap">
                            <div class="reservation-drop-offer__cover-title">Совершите<br>поездку за <b>417</b> руб.</div>
                            <div class="reservation-drop-offer__cover-subtitle">Выберите адрес из опций быстрого выезда. Цена за одно место действует при условии предоплаты.</div>
                        </div>
                        <img src="/images_new/arrow-tab.png" alt="" class="reservation-drop-offer__cover-arrow">
                    </div>
                    <ul class="reservation-drop-offer__list">
                        <li class="reservation-drop-offer__item">
                            <div class="reservation-drop-offer__item-title">«Орион» - <b>417</b> руб.</div>
                            <div class="reservation-drop-offer__item-subtitle">ул. Ленина, 92</div>
                        </li>
                        <li class="reservation-drop-offer__item">
                            <div class="reservation-drop-offer__item-title">«Лента» - <b>417</b> руб.</div>
                            <div class="reservation-drop-offer__item-subtitle">ул. Ленина, 105</div>
                        </li>
                        <li class="reservation-drop-offer__item">
                            <div class="reservation-drop-offer__item-title">«Сбербанк» - <b>417</b> руб.</div>
                            <div class="reservation-drop-offer__item-subtitle">ул. Ленина, 105</div>
                        </li>
                    </ul>
                </div>
                <div class="reservation-drop__search">
                    <div class="reservation-drop__search-text">… или введите адрес вручную для выбора точки посадки рядом с домом</div>
                    <div class="reservation-drop__search-input-wrap">
                        <input type="text" class="reservation-drop__search-input" placeholder="Начните вводить адрес...">
                        <div class="reservation-popup reservation-popup-search">
                            <ul class="reservation-popup__list">
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Пушкина 1</div>
                                </li>
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Проспект Победы 4а</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="reservation-drop__search-geo"><span>использовать мою геопозицию</span></div>
                </div>
                <div class="reservation-drop__map">
                    <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                </div>
                <div class="reservation-drop__selected">
                    <div class="reservation-drop__selected-big">Выбрана точка посадки:</div>
                    <div class="reservation-drop__selected-showmap">
                        <div class="reservation-drop__selected-address">«Лента» ул. Ленина, 105</div>
                        <div class="reservation-drop__selected-showmap-wrap"><span>на карте</span></div>
                    </div>
                    <div class="reservation-drop__selected-map">
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="reservation-drop__time">
                    <div class="reservation-drop__time-paragraph">Указанное вами желаемое время посадки - <span class="reservation-drop__time-time">21:00</span>. На выбранной точке можно сесть в указанное время.</div>
                    <div class="reservation-drop__time-title">Выберите время посадки:</div>
                    <ul class="reservation-drop__time-list">
                        <li class="reservation-drop__time-item">21:00</li>
                        <li class="reservation-drop__time-item">22:00</li>
                        <li class="reservation-drop__time-item">23:00</li>
                    </ul>
                    <div class="reservation-drop__time-back-wrap">
                        <img src="/images_new/back-address.svg" alt="" class="reservation-drop__time-back-arrow">
                        <div class="reservation-drop__time-back-text"><span>Другой адрес?</span></div>
                    </div>
                </div>
                */ ?>
            </div>
        </div>
    </div>
    <div class="container container-drop--2">
        <div class="reservation-drop reservation-drop--2">
            <div class="reservation-drop__topline">
                <div class="reservation-drop__topline-title">Пункт назначения</div>
                <img src="/images_new/cancel.svg" alt="" class="reservation-drop__topline-cancel">
            </div>
            <div class="reservation-drop__content">
                <?php /*
                <div class="reservation-drop__select">
                    <div class="reservation-drop__select-title">Выберите из списка точку высадки, наиболее удобную для вас</div>
                    <div class="reservation-drop__select-select-wrap">
                        <input type="text" class="reservation-drop__select-select">
                        <div class="reservation-popup reservation-popup-select">
                            <ul class="reservation-popup__list">
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Пушкина 1</div>
                                </li>
                                <li class="reservation-popup__item">
                                    <div class="reservation-popup__item-text">Проспект Победы 4а</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="reservation-drop__select-list">
                        <li class="reservation-drop__select-item">РКБ</li>
                        <li class="reservation-drop__select-item">ТЦ «Кольцо»</li>
                        <li class="reservation-drop__select-item">Ж/Д Центр.</li>
                        <li class="reservation-drop__select-item">Аэропорт</li>
                    </ul>
                </div>
                <div class="reservation-drop__dest">
                    <div class="reservation-drop__dest-title">… или укажите на карте:</div>
                    <div class="reservation-drop__dest-map">
                        <!--
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                        -->
                    </div>
                </div>
                */ ?>
            </div>
        </div>
    </div>
</div>
<!--
</form>
-->

<?php /*
<form action="" class="reservation-form reservation-form--step2">
    <div class="container">
        <div class="reservation-step reservation-step--bordered">
            <div class="reservation-step__top">
                <div class="reservation-step__title">Заказчик</div>
                <div class="reservation-step__subtitle">Необходимо ввести, как минимум, фамилию - чтобы водитель смог идентифицировать вас при посадке</div>
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-name" class="reservation-step__input-label">Фамилия Имя Отчество</label>
                <input type="text" id="reservation-name" class="reservation-step__input-input required-input-step-2" placeholder="Иванов Сергей Иванович">
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-gen" class="reservation-step__input-label">Пол</label>
                <input type="text" id="reservation-gen" class="reservation-step__input-input" placeholder="Мужской">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="reservation-step reservation-step--bordered">
            <div class="reservation-step__top">
                <div class="reservation-step__title">Контактные данные</div>
                <div class="reservation-step__subtitle">На почту мы вышлем маршрутную квитанцию, а с помощью телефона мы сможем связаться с вами</div>
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-phone" class="reservation-step__input-label">Телефон</label>
                <input type="text" id="reservation-phone" class="reservation-step__input-input required-input-step-2" placeholder="+7 999 999-99-99">
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-mail" class="reservation-step__input-label">E-mail</label>
                <input type="text" id="reservation-mail" class="reservation-step__input-input required-input-step-2" placeholder="sergei@gmail.com">
            </div>
        </div>
    </div>
</form>
*/ ?>
<div class="container">
    <div class="reservation-average d-n">
        <div class="reservation-average__title">Расчетное время в пути</div>
        <div class="reservation-average__time">3 ч 10 мин</div>
        <div class="reservation-average__small">в хороших погодных условиях</div>
    </div>
</div>

<!--
<form action="" class="reservation-form reservation-form--step1">
-->

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
                        <div class="reservation-item__checkbox-wrap">
                            <input type="checkbox" name="" id="reservation-item__checkbox-4" class="reservation-item__checkbox">
                            <label for="reservation-item__checkbox-4" class="reservation-item__checkbox-label">Дополнительные пожелания</label>
                        </div>
                        <div class = "reservation-item__textarea">
                            <textarea id="additional-wishes" disabled="true"></textarea>
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
<!--
</form>
-->

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
                    <div class="reservation-calc__counter-plus text_24">+</div>
                    <div class="reservation-calc__counter-num"><?= $model->places_count ?></div>
                    <div class="reservation-calc__counter-minus text_24">-</div>
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



<?php /*
 <br />

<span id="city-from" city-id="<?= $model->city_from_id ?>" ><?= $model->cityFrom->name ?></span>
<br /><br />
<div id="point-from-text">Выберите наиболее удобное место посадки</div>
<input name="ClientExt[yandex_point_from_id]" type="hidden" value="" />
<input id="search-place-from" type="text" placeholder="Начните вводить адрес..." />
<div class="search-result-block sw-select-block"></div>
<!--
<div><label id="select-point-from-map" href="">выбрать на карте</label></div>
-->
<div id="map-text"></div>
<div id="select-trip-list" style="display: none;"><div id="trip-time-confirm-1" class="selecting-trip"></div><div id="trip-time-confirm-2" class="selecting-trip"></div><div id="trip-time-confirm-3" class="selecting-trip"></div></div>
<div id="YMapsID" style="width: 600px; height: 400px; margin-top: 5px; display: none;"></div>
<input name="ClientExt[trip_id]" type="hidden" value="" />
<br /><br />
<?= $model->cityTo->name ?>
<div id="point-to-text">Выберите пункт назначения</div>
<!--
<input name="ClientExt[yandex_point_to_id]" type="hidden" value="" />
<input id="search-place-to" type="text" placeholder="Выберите из списка" />
-->

<div class="col-sm-3" style="padding-left: 0;">
    <?= SelectWidget::widget([
        'model' => $model,
        'attribute' => 'yandex_point_to_id',
        'name' => 'yandex_point_to_id',
        'initValueText' => ($model->yandex_point_to_id > 0 ? $model->yandexPointFrom->name : ''),
        'options' => [
            'name' => 'ClientExt[yandex_point_to_id]',
            'placeholder' => 'Выберите точку',
        ],
        'ajax' => [
            'url' => '/yandex-point/ajax-yandex-points?is_from=0&simple_id=1',
            'data' => new JsExpression(
                'function(params) {
                    return {
                        search: params.search,
                        direction_id: "'.$model->direction_id.'"
                    };
                }')
        ],
        'afterChange' => "function(obj, value, text) {

            // alert('value='+value);

            if(value == '') {

                $('#clientext-time_air_train_arrival').val('');
                $('#time_air_train_arrival_label').html('');
                $('#time_air_train_arrival_block').hide();

            }else {

                var critical_point = obj.find('input[type=\"hidden\"]').attr('critical_point');
                var alias = obj.find('input[type=\"hidden\"]').attr('alias');

                $('#clientext-time_air_train_arrival').val('');
                if(critical_point == '1') {
                    var label = '';
                    if(alias == 'airport') {
                        label = 'Окончание регистрации вылета';
                    }else {
                        label = 'Время прибытия поезда';
                    }


                    $('#time_air_train_arrival_label').html(label);
                    $('#time_air_train_arrival_block').show();
                }else {
                    $('#time_air_train_arrival_label').html('');
                    $('#time_air_train_arrival_block').hide();
                }
            }
        }",
    ]); ?>
</div>


<br /><br /><br /><br />
<ul class="nav nav-tabs" style="clear: both;">
    <li class="active"><a data-toggle="tab" href="#panel1">Дополнительные данные</a></li>
    <li><a data-toggle="tab" href="#panel2">Условия бронирования</a></li>
    <!--
    <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            Другие панели
            <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
            <li><a data-toggle="tab" href="#panel3">Панель 3</a></li>
            <li><a data-toggle="tab" href="#panel4">Панель 4</a></li>
        </ul>
    </li>
    -->
</ul>

<div class="tab-content">
    <div id="panel1" class="tab-pane fade in active">

        <div id="time_air_train_arrival_block" style="display: none;">
            <label id="time_air_train_arrival_label"></label>
            <?php
            echo $form->field($model, 'time_air_train_arrival', ['options' => ['class' => 'form-group person_info tel md-form'], 'template' => '{input}{label}{error}'])
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
                            'class' => 'form-control form-masked-input',
                            //'placeholder' => 'Во сколько вас забрать',
                            'style' => 'width: 58px;',
                        ]
                    ])->label(false);
            ?>
        </div>

        <div>
            <input name="ClientExt[bag_count]" type="hidden" value="<?= $model->bag_count ?>" />
            Ручная кладь: <span id="minus-bag-count" class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> <span id="bag-count"><?= intval($model->bag_count) ?></span> <span id="plus-bag-count" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
        </div>
        <div>
            <input name="ClientExt[suitcase_count]" type="hidden" value="<?= $model->suitcase_count ?>" />
            Большой чемодан: <span id="minus-suitcase-count" class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> <span id="suitcase-count"><?= intval($model->suitcase_count) ?></span> <span id="plus-suitcase-count" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
        </div>

        <div>
            <input name="ClientExt[places_count]" type="hidden" value="<?= $model->places_count ?>" />
            Мест: <span id="minus-places-count" class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> <span id="places-count"><?= $model->places_count ?></span> <span id="plus-places-count" class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
        </div>


    </div>
    <div id="panel2" class="tab-pane fade">
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
        Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла. Бла бла бла.
    </div>
    <!--
    <div id="panel3" class="tab-pane fade">
        <h3>Панель 3</h3>
        <p>Содержимое 3 панели...</p>
    </div>
    <div id="panel4" class="tab-pane fade">
        <h3>Панель 4</h3>
        <p>Содержимое 4 панели...</p>
    </div>
    -->

    <br />
    <div id="travel-text" style="display: none;">
        Расчетное время в пути<br />
        <span id="travel-h"></span> ч <span id="travel-m"></span> мин<br />
        в хороших погодных условиях
    </div>
</div>
<br />

<?php

//if(Yii::$app->user->identity != null) {
//    echo "user:<pre>"; print_r(Yii::$app->user->identity); echo "</pre>";
//}
?>

<input type="hidden" name="ClientExt[user_id]" value="<?= (Yii::$app->user->identity == null ? '' : Yii::$app->user->identity->id) ?>" />

<?php
echo MaskedInput::widget([
    'id' => 'phone',
    'name' => 'ClientExt[phone]',
    'mask' => '+7-999-999-99-99',
    'value' => $model->phone,
    'clientOptions' => [
        'placeholder' => '*',
    ],
    'options' => [
        'placeholder' => 'Номер телефона',
        'class' => "input",
        'style' => [
            'width' => "200px;"
        ]
    ]
]);
?>

<?= $form->field($model, 'fio')
    ->textInput([
        'id' => 'fio',
        'class' => "input",
        'placeholder' => "Имя Фамилия",
        'style' => [
            'width' => "200px;"
        ]
    ])->label(false) ?>

<?php
//echo MaskedInput::widget([
//    'name' => 'input-36',
//    'clientOptions' => [
//        'alias' =>  'email'
//    ],
//]);

echo $form->field($model, 'email')
    ->textInput([
        //'id' => 'username',
        'class' => "input",
        'placeholder' => "Электронная почта",
        'style' => [
            'width' => "200px;"
        ]

    ])->label(false)
?>

<br />
<div class="trip-section-wrap">
    <div class="page">
        <div class="pay-form">
            <?php // теперь не понятно как тут будут отображаться 2 цены, пока отключаю эту логику
            <!--
            <div class="pay-form-table">
                <div class="pay-form-total">
                    <div class="pay-form-item pay-form-item_total">
                        <span class="pay-form-item-name">К оплате:</span>&nbsp;&nbsp;&nbsp;<span id="client-ext-unprepayment-price" class="pay-form-item-value"><?= $model->price ?> &#8399;</span> / <span id="client-ext-prepayment-price" class="pay-form-item-value"><?= $model->price ?> &#8399;</span>
                    </div>
                </div>
            </div>
            <div class="pay-form-action">
                <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                    <span class="y-button-text">Купить</span>
                </button>
            </div>
            <div class="pay-form-action" style="<?= (Yii::$app->user->identity == null ? 'display: none;' : '') ?>">
                <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                    <span class="y-button-text">Продолжить без оплаты</span>
                </button>
            </div>
            -->
            <div class="pay-form-action" style="margin-left: 0;">
                <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                    <span class="y-button-text">Бронировать</span>
                </button>
            </div>
        </div>
    </div>
</div>
 */ ?>

<?php ActiveForm::end(); ?>
