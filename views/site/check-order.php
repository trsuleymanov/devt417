<?php
use app\models\ClientExt;
use yii\widgets\ActiveForm;


//$aTripEndTime = explode(':', $model->trip->end_time);
//$trip_end_time = 3600*intval($aTripEndTime[0]) + 60*intval($aTripEndTime[1]);
//$travel_time = 2*$model->trip->date + $trip_end_time - $model->time_confirm + 10800;

$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('/js/check-order.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);

$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
?>
<div class="reservation-top">
    <div class="container">
        <div class="reservation-title-main">
            <a href="/site/create-order-step2?c=<?= $model->access_code ?>"><img src="/images_new/back-top.svg" alt="" class="reservation-back"></a>

            <div class="reservation-title-wrap">
                <div class="reservation-title">Бронирование мест</div>
                <div class="reservation-undertitle reservation-undertitle--3 d-b">Шаг 3 из 3 - Подтверждение заказа</div>
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

<form action="" class="reservation-form reservation-form--step1 reservation-form--step3">
    <div class="container">
        <div class="reservation-step reservation-step--first">
            <div class="reservation-step-line js-showMap">
                <div class="reservation-step-line-row">
                    <span></span>
                </div>
                <div class="reservation-step-line-content">
                    <div class="reservation-step-line-content-top">
                        <?php /*
                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--empty1 d-n">
                            <div class="reservation-step-line-title">
                                Казань
                            </div>
                            <div class="reservation-step-line-undertitle">
                                Выберите наиболее удобное место посадки в автобус
                            </div>
                        </div> */ ?>

                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready1 d-b">
                            <div class="reservation-step-line-wrap">
                                <div class="reservation-step-line-title">
                                    <?= $model->cityFrom->name ?>
                                </div>
                                <!--
                                <div class="reservation-step-line-showmap">на карте</div>
                                -->
                            </div>
                            <div class="reservation-step-line-confirmed">время посадки подтверждено</div>
                            <div class="reservation-step-line-content-top-left reservation-step-line-address-wrap">
                                <div class="reservation-step-line-address"><?= $model->yandexPointFrom->name.($model->yandexPointFrom->description != "" ? ', '.$model->yandexPointFrom->description : '') ?></div>
                                <!--
                                <div class="reservation-step-line-change">Изменить адрес посадки</div>
                                -->
                            </div>
                        </div>

                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-title">
                                <?= $model->time ?>
                            </div>
                            <div class=" reservation-step-line-time">
                                <?= intval(date('d', $model->data)) ?> <?= $aMonths[intval(date('m', $model->data))] ?>
                            </div>
                        </div>
                    </div>

                    <?php /*
                    <div class="reservation-step-line-selecte reservation-step-line-selecte--1 d-n">
                        <input type="text" placeholder="Начните вводить адрес...">
                    </div>

                    <div class="reservation-step-line-map reservation-step-line-map--address d-n">
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                    </div>
                    */ ?>
                </div>
            </div>
            <div class="reservation-step-line">
                <div class="reservation-step-line-row reservation-step-line-row2">
                    <span></span>
                </div>
                <div class="reservation-step-line-content">
                    <div class="reservation-step-line-content-top">
                        <?php /*
                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--empty2 d-n">
                            <div class="reservation-step-line-title">
                                Альтемьевск
                            </div>
                            <div class="reservation-step-line-undertitle">
                                Укажите пункт назначения
                            </div>
                        </div>*/ ?>
                        <div class="reservation-step-line-content-top-left reservation-step-line-content-top-left--ready2 d-b">
                            <div class="reservation-step-line-wrap">
                                <div class="reservation-step-line-title">
                                    <?= $model->cityTo->name ?>
                                </div>
                                <!--
                                <div class="reservation-step-line-showmap">на карте</div>
                                -->
                            </div>
                            <div class="reservation-step-line-undertitle reservation-step-line-dest reservation-step-line-dest-address">
                                <?= $model->yandexPointTo->name.($model->yandexPointTo->description != "" ? ', '.$model->yandexPointTo->description : '') ?>
                            </div>
                            <!--
                            <div class="reservation-step-line-change2">Изменить</div>
                            -->
                        </div>
                        <div class="reservation-step-line-content-top-right">
                            <div class="reservation-step-line-title">
                                <?= $model->time ?>
                            </div>
                            <div class=" reservation-step-line-time">
                                <?= intval(date('d', $model->data)) ?> <?= $aMonths[intval(date('m', $model->data))] ?>
                            </div>
                        </div>
                    </div>

                    <?php /*
                    <div class="reservation-step-line-selecte reservation-step-line-selecte--2 input-arrow d-n">
                        <input type="text" placeholder="Выберите из списка">
                    </div>*/ ?>

                    <div class="reservation-step-line-map reservation-step-line-map--dest">
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
            <div class="reservation-step-hatch reservation-step-hatch--long"></div>
            <div class="reservation-step-info d-b">
                <div class = "reservation-step-info_row">
                    <div class = "reservation-step-info_title">Заказчик:</div>
                    <div class = "reservation-step-info_value">Ахмадиев Артур, +7-917-939-7393</div>
                </div>
                <div class = "reservation-step-info_row">
                    <div class = "reservation-step-info_title">Пассажиры:</div>
                    <div class = "reservation-step-info_value">ВЗР - 1, ДЕТИ - 2, свое детское кресло</div>
                </div>
                <div class = "reservation-step-info_row">
                    <div class = "reservation-step-info_title">Информация о багаже:</div>
                    <div class = "reservation-step-info_value">Нет</div>
                </div>
                <div class = "reservation-step-info_row">
                    <div class = "reservation-step-info_title">Сообщение для оператора:</div>
                    <div class = "reservation-step-info_value">Нет</div>
                </div>
                <div class = "reservation-step-info_row">
                    <div class = "reservation-step-info_deadline">Прибытие поезда в 14:00</div>
                </div>
            </div>
            <div class = "reservation-step-actions">
                <a href="/site/create-order?c=<?= $model->access_code ?>">Изменить данные заказа</a>
            </div>


                <?php if(!empty($model->time_air_train_arrival)) { ?>
                    <div class="reservation-step-info__arrival">Прибытие поезда / посадка в самолет в <?= $model->time_air_train_arrival ?></div>
                <?php } ?>
                <div class="reservation-step-info__name">Пассажир: <?= $model->fio ?></div>
                <?php
                $aPlaces = [];
                $grown_count = $model->places_count - $model->student_count - $model->child_count;
                if($grown_count > 0) {
                    $aPlaces[] = $grown_count.' взр.';
                }
                if($model->student_count > 0) {
                    $aPlaces[] = $model->student_count.' ст.';
                }
                if($model->child_count > 0) {
                    $aPlaces[] = $model->child_count.' дет.';
                }
                ?>
                <div class="reservation-step-info__places">Кол-во мест: <?= $model->places_count ?> (<?= implode(',', $aPlaces) ?>)</div>
                <?php if($model->suitcase_count > 0 || $model->bag_count > 0) { ?>
                    <div class="reservation-step-info__luggage">Багаж: чемоданы - <?= $model->suitcase_count ?>, ручная кладь - <?= $model->bag_count ?></div>
                <?php } ?>
                <a href="/site/create-order?c=<?= $model->access_code ?>" class="reservation-step-info__change">Изменить</a>
            </div>
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
                            <div class="reservation-drop-offer__cover-title">Совершите...<br>поездку за <b>417</b> руб.</div>
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
                </div>*/ ?>
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
                        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="reservation-prices">
    <div class="container">
        <div class="reservation-price d-b">
            <div class="reservation-price__title"><b class="reservation-price__one-price"><?= $model->getCalculatePrice('prepayment', 1) ?></b> рублей за место</div>
            <div class="reservation-price__subtitle">Итого: <b class="reservation-price__price"><?= $model->getCalculatePrice('prepayment') ?></b> р.</div>
            <div id="make-simple-payment-checkorderpage" class="reservation-price__button" access_code="<?= $model->access_code ?>">Оплатить сейчас</div>
        </div>
    </div>

    <div class="container">
        <div class="reservation-price reservation-price--cash d-b">
            <div class="reservation-price__title"><b class="reservation-price__cash-price"><?= $model->getCalculatePrice('unprepayment') ?></b> рублей</div>
            <div class="reservation-price__subtitle">При оплате наличными</div>
            <div id="but_reservation" class="reservation-price__button" access_code="<?= $model->access_code ?>">Продолжить без оплаты</div>
            <div class="reservation-price__label">Доступно авторизованным пользователям</div>
        </div>
    </div>
</div>
