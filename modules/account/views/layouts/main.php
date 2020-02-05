<?php

use app\models\ClientExt;
use app\models\Tariff;
use yii\web\ForbiddenHttpException;
use app\components\Helper;
use app\assets\NewAppAsset;

NewAppAsset::register($this);

$cookie = Yii::$app->getRequest()->getCookies();

$current_route = $this->context->route;

$user = Yii::$app->user->identity;

if( $current_route == 'account/order/history' ):
    $addClass = 'personal-page';
else:

endif;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="utf-8">
    <title>Главная страница</title>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE = edge"><![endif]-->
    <meta name="viewport" content="width=device-width, minimum-scale=0.5, maximum-scale=1, initial-scale=1.0" />
    <meta name="keywords" content="">
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSS-->
    <?php /*<link rel="stylesheet" type="text/css" href="static/css/libs.min.css"> */ ?>
    <!-- <link rel="stylesheet" type="text/css" href="static/css/main.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/account/lk.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/account/menuReservetion.css"> -->
    <!--[if lt IE 9]>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
    <?php $this->head() ?>
</head>

<body class="<?= (isset($addClass) ? $addClass : '') ?>">
<?php $this->beginBody() ?>
<div class="wrapper">
    <header>
        <div class="container">
            <div class="header">
                <a class="header__logo" href = "/">
                    <img src = "/images_new/svg/logo.svg">
                </a>
                <div></div>
                <div class="navigation text_16">

                    <a href="/#new-order">Новый заказ</a>
                    <a href="/#terms">Условия</a>
                    <a href="/#information">Правовая информация</a>
                    <a href="/">417417.ru</a>
                </div>

                <?php if($user != null) {
                    $fio = $user->last_name.' '.$user->first_name;
                    ?>
                    <div class="header__enter text_16">
                        <a class="header__login text_14" href="#" onclick="">
                            <i>
                                <svg class="icon icon-user header__icon">
                                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                                </svg>
                            </i>
                            Я, <?= (mb_strlen($fio) > 11 ? mb_substr($fio, 0, 11) : $fio) ?>
                        </a>
                        <div class="for_enter_wrap modal_enter">
                            <div  class="for_enter">
                                <ul>
                                    <li><a href="/account/personal">Личный кабинет</a></li>
                                    <hr>
                                    <li><a href="#">t417.ru</a></li>
                                    <hr>
                                    <li><a href="/site/logout">Выход</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="header__burger">
                    <button class="burger" type="button" name="burger" data-izimodal-open="#menu">
                        <svg class="icon icon-menu burger__icon">
                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#menu"></use>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

    </header>

    <div class="content">

        <div class="content_menu">
            <ul>
                <li class="hover__menu <?= $current_route == 'account/order/reservation' ? 'active' : ''; ?>"><a href="/account/order/reservation">АКТИВНЫЕ ЗАКАЗЫ</a></li>

                <li class="hover__menu <?= $current_route == 'account/order/history' ? 'active' : ''; ?>"><a href="/account/order/history">ИСТОРИЯ ЗАКАЗОВ</a></li>

                <li class="hover__menu <?= $current_route == 'account/personal/index' ? 'active' : ''; ?>"><a href="/account/personal" >МОЙ ПРОФИЛЬ</a></li>

                <li class="hover__menu <?= $current_route == 'account/questions/index' ? 'active' : ''; ?>"><a href="/account/questions" >ОТВЕТЫ НА ВОПРОСЫ</a></li>

                <li class="hover__menu"><a href="/site/logout">ВЫХОД ИЗ ЛИЧНОГО КАБИНЕТА</a></li>

                <button class="button__menu">Устроиться водителем</button>
            </ul>

        </div>

        <?php
            $not_ready_orders = [];
            if($user != null) {

                $not_ready_orders = ClientExt::find()
                    ->where(['user_id' => $user->getId()])
                    ->andWhere(['status' => ''])
                    ->all();
                // echo "count=".count($not_ready_orders)."<br />";
            }
        ?>

        <?php if($user != null && ($user->email_is_confirmed == false || count($not_ready_orders) > 0)) { ?>
            <div class="center__info">


                <?php if($user->email_is_confirmed == false) { ?>
                    <div class="message__block">
                        <div class = "message__title">Подтвердите e-mail</div>
                        <div class = "message__text">Необходимо ввести, как минимум, фамилию чтобы водитель мог идентифицировать вас при посадке</div>
                    </div>
                <?php }

                if(count($not_ready_orders) > 0) {
                    foreach ($not_ready_orders as $order) {

                        $aTime = explode(':', $order->time);
                        $datetime = $order->data + 3600*intval($aTime[0]) + 60*intval($aTime[1]);

                        $tariff = Tariff::find()
                            ->where(['<=', 'start_date', $order->data])
                            ->andWhere(['commercial' => 0])
                            ->orderBy(['start_date' => SORT_DESC])
                            ->one();
                        if($tariff == null) {
                            throw new ForbiddenHttpException('Тариф не найден');
                        }

                        if(!empty($order->fio)) {
                            $link = '/site/check-order?c='.$order->access_code;
                        }elseif($order->trip_id > 0) {
                            $link = '/site/create-order-step2?c='.$order->access_code;
                        }else {
                            $link = '/site/create-order?c='.$order->access_code;
                        }
                        ?>

                        <div class="complete__order">
                            <a href="#" class="order__close cancel-not-ready-order" access-code="<?= $order->access_code ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="11px" height="11px" class="svg_order">
                                    <image x="0px" y="0px" width="11px" height="11px" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAQAAAADpb+tAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QA/4ePzL8AAAAHdElNRQfjCgwRHwH725PaAAAAx0lEQVQI1zXPvS6DUQCA4ec46XcDxuMKXIArsDYxuQIJ8RMiSLRputDoYCASBg0mkyuwGlS6kFRil6aDjRCNfMdQ3ht484SZnutwlH/8V1FXjVOTdg08KyEUltScxHRnpG2grwxFXrYXNpzFRNfIvlcvFkPTtg4xIdz7tGXafGjowEQQ5OxYz4LbfDH+xgSFVXNuzIYPfSUxCYU1DTWtkPOBN0/KmAormmHTFR58aRnqx7Sjbt3lH6brXdt3TIdOnY8x4FFF9RfiuD2T4K923QAAAABJRU5ErkJggg=="></image>
                                </svg>
                            </a>
                            <div class = "order__title">
                                <a href="<?= $link ?>">Завершите оформление заказа</a>
                            </div>
                            <div class = "order__info">
                                <p>
                                    <?= $order->direction_id == 1 ? 'Альметьевск-Казань' : 'Казань-Альметьевск' ?>
                                </p><p>
                                    <?= Helper::getMainDate($datetime, 1) ?>, <?= $order->places_count ?> <?= Helper::getNumberString($order->places_count, 'место', 'места', 'мест') ?>
                                </p>
                            </div>
                            <div class = "order__price">
                                <?php if($order->yandexPointFrom != null && $order->yandexPointFrom->super_tariff_used == true) { ?>
                                    ОТ <?= ($tariff->superprepayment_common_price + $tariff->superprepayment_reservation_cost) ?> РУБЛЕЙ ЗА МЕСТО
                                <?php }else { ?>
                                    ОТ <?= ($tariff->prepayment_common_price + $tariff->prepayment_reservation_cost) ?> РУБЛЕЙ ЗА МЕСТО
                                <?php } ?>
                            </div>

                        </div>
                    <?php }
                } ?>
            </div>
        <?php } ?>

        <?= $content ?>

    </div>

    <footer class="footer">
        <div class="footer_menu_wrap">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="footer_menu">
                            <div class="footer_menu__logo">
                                <div class="footer_menu__logo__img">
                                    <img src = "/images_new/svg/logo_mini.svg">
                                </div>
                                <p class="footer_menu__logo__text text_20">современный стандарт<br>ЗАКАЗных перевозок</p>
                            </div>
                            <div class="footer_menu__link__wrap"><a class="footer_menu__link text_18" href="#">Политика
                                    конфиденциальности</a><a class="footer_menu__link text_18" href="#">Договор оферты</a><a
                                        class="footer_menu__link text_18" href="#">417417.ru</a></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_menu">
                            <div class="footer_menu__link__wrap"><a class="footer_menu__link text_18" href="#">Новый
                                    заказ</a><a class="footer_menu__link text_18" href="#">Наши преимущества</a><a
                                        class="footer_menu__link text_18" href="#">Правовая информация</a><a
                                        class="footer_menu__link text_18" href="#">Условия предоставления услуг</a><a
                                        class="footer_menu__link text_18" href="#">Галерея</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_copyright_wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer_copyright">
                            <p class="footer_copyright__text text_16">Мы используем информацию, зарегистрированную в файлах
                                «cookies», в частности, в рекламных и статистических целях, а также для того, чтобы
                                адаптировать наши сайты к индивидуальным потребностям Пользователей. Вы можете изменить
                                настройки касающиеся «cookies» в вашем браузере. Изменение настроек может ограничить
                                функциональность сайта.</p>
                            <p class="footer_copyright__text text_16">© 2019, OOO «417». Все права защищены.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="mobile_menu" id="menu">
        <div class="modal_global">
            <div class="modal_global__name"><span class="text_22" >Меню личного кабинета</span>
                <button class="close" type="button" name="close" data-izimodal-close>
                    <svg class="icon icon-close close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <ul class="reservation-menu__list">

                <li class="nav__item reservation-menu__item text_18" id="active__reservation"><a class="nav__link <?= $current_route == 'account/order/reservation' ? 'active' : ''; ?>" href="/account/order/reservation">АКТИВНЫЕ ЗАКАЗЫ</a></li>
                <li class="nav__item reservation-menu__item text_18" id="pass_reservation"><a class="nav__link <?= $current_route == 'account/order/history' ? 'active' : ''; ?>" href="/account/order/history">ИСТОРИЯ ЗАКАЗОВ</a></li>
                <li class="nav__item reservation-menu__item text_18" id="pass_reservation"><a class="nav__link <?= $current_route == 'account/personal/index' ? 'active' : ''; ?>" href="/account/personal">МОЙ ПРОФИЛЬ</a></li>
                <li class="nav__item reservation-menu__item text_18" id="pass_reservation"><a class="nav__link <?= $current_route == 'account/questions/index' ? 'active' : ''; ?>" href="/account/questions">ОТВЕТЫ НА ВОПРОСЫ</a></li>
                <li class="nav__item reservation-menu__item text_18" id="pass_reservation"><a class="nav__link" href="/site/logout">ВЫХОД ИЗ ЛИЧНОГО КАБИНЕТА</a></li>
                <li class="nav__item reservation-menu__item text_18" id=""><a class="nav__link menu_mobile" href="#" data-izimodal-open="#menus">ГЛАВНОЕ МЕНЮ</a></li>
            </ul>
        </div>
    </div>
    <div class="mobile_menu" id="menus">
        <div class="modal_global">
            <div class="modal_global__name"><span class="text_22">Главное меню</span>
                <button class="close" type="button" name="close" data-izimodal-close>
                    <svg class="icon icon-close close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <div class="modal_global__menu">
                <a class="modal_global__login text_20" href="/site/logout">
                    <svg class="icon icon-user header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                    </svg>
                    Выйти
                </a>
                <button class="modal_global__login text_20" type="button" name="help">
                    <svg class="icon icon-phone header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#phone"></use>
                    </svg>Служба поддержки
                    <svg class="icon icon-right-arrow header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                    </svg>
                </button>
            </div>
            <ul class="nav">
                <li class="nav__item"><a class="nav__link text_18" href="/#new-order">Новый заказ</a></li>
                <li class="nav__item"><a class="nav__link text_18" href="/#terms">Условия предоставления услуг</a></li>
                <li class="nav__item"><a class="nav__link text_18" href="/#information">Правовая информация</a></li>
                <li class="nav__item"><a class="nav__link text_18" href="/#">Галерея</a></li>
                <li class="nav__item"><a class="nav__link text_18" href="/#">Контакты</a></li>
                <li class="nav__item"><a class="nav__link menu_mobile text_18"  href="/#" data-izimodal-open="#menu">Меню личного кабинета</a></li>
            </ul>
        </div>
    </div>
    <div class="mobile_menu" id="enter-mobile">
        <div class="modal_global">
            <div class="modal_global__name">
                <button class="prev" type="button" name="prev" data-izimodal-close>
                    <svg class="icon icon-right-arrow close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                    </svg>
                </button>
                <a class="modal_global__login text_20" href="#">
                    <svg class="icon icon-user header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                    </svg>
                    Войти
                </a>
                <button class="close" type="button" name="close" data-izimodal-close>
                    <svg class="icon icon-close close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <div class="modal_global__enter">
                <div class="modal_global__content">
                    <p class="modal_global__title text_18">Для входа в личный кабинет<br>введите номер телефона</p>
                    <input class="modal_global__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
                </div>
                <div class="modal_global__btn">
                    <button class="modal_global__submit text_18 test" type="button" name="submit" data-izimodal-open="#registration-mobile">Продолжить</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_menu" id="registration-mobile">
        <div class="modal_global">
            <div class="modal_global__name">
                <button class="prev" type="button" name="prev" data-izimodal-close>
                    <svg class="icon icon-right-arrow close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                    </svg>
                </button><a class="modal_global__login text_20" href="#">
                    <svg class="icon icon-user header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                    </svg>Войти</a>
                <button class="close" type="button" name="close" data-izimodal-close>
                    <svg class="icon icon-close close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <div class="modal_global__enter">
                <div class="modal_global__content">
                    <input class="modal_global__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
                    <input class="modal_global__input" type="email" name="email" placeholder="Введите Email" autocomplete="off">
                    <input class="modal_global__input" type="password" name="phone" placeholder="Введите пароль" autocomplete="off">
                    <div class="children__checkbox">
                        <button class="children__btn" type="button" name="check" data-name="Запомнить меня"></button>
                        <input type="checkbox" name="checkbox" hidden="" checked="true">
                    </div>
                </div>
                <div class="modal_global__btn">
                    <button class="modal_global__submit text_18 test" type="button" name="submit">Продолжить</button>
                </div>
            </div>
        </div>
    </div>
    <? if( !isset($_COOKIE["use-cookie"]) || $_COOKIE["use-cookie"] != 'true'): ?>
        <div id = "use-cookie" class = "fixed__block">
            <div class="container">
                <div class = "fixed__block__content">
                    Мы используем информацию, зарегистрированную в файлах «cookies», в частности, в рекламных и статистических целях, а также для того, чтобы адаптировать наши сайты к индивидуальным потребностям Пользователей. Вы можете изменить настройки касающиеся «cookies» в вашем браузере. Изменение настроек может ограничить функциональность сайта.
                </div>
                <div class = "fixed__block__actions">
                    <a class = "fixed__block__btn cookie-trigger" href = "#">Принимаю. Больше не показывать</a>
                </div>
            </div>
        </div>
    <? endif; ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
