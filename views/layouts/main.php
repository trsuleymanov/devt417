<?php
use app\assets\NewAppAsset;

use app\models\InputPhoneForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

NewAppAsset::register($this);


$settings = \app\models\Setting::find()->where(['id' => 1])->one();

// $current_module = Yii::$app->controller->module->id;
$current_controller = Yii::$app->controller->id;
$current_route = $this->context->route;

$model = new InputPhoneForm();

if(Yii::$app->user->isGuest):
    $addClass = 'guest';
else:
    $addClass = 'user';
endif;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="utf-8">
    <title>Главная страница</title><!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE = edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <!-- Favicon-->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSS-->
    <?php /*
    <link rel="stylesheet" type="text/css" href="/css/libs.min.css">
    <link rel="stylesheet" type="text/css" href="/css/main_new.css">*/ ?><!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
    <?php $this->head() ?>
    <script>
        window.client_ext_id = '<?= (isset($client_ext) && $client_ext != null ? $client_ext->id : 0); ?>';
    </script>
</head>
<body class="index-page <?=$addClass?>">
<?php $this->beginBody() ?>
<div class="wrapper">
    <?php /*
    <header style="<?= (!in_array($current_route, ['site/index', 'site/create-order', 'site/create-order-step2', 'site/check-order']) ? 'display: none;' : '') ?>">
    */ ?>
    <header>
        <div class="container">
            <div class="header">
                <a class="header__logo" href = "/">
                    <img src = "/images_new/svg/logo.svg">
                </a>
                <div class="header__menu">
                    <ul class="nav">
                        <li class="nav__item"><a class="nav__link text_16" href="/#new-order">новый заказ</a></li>
                        <li class="nav__item"><a class="nav__link text_16" href="/#terms">условия</a></li>
                        <li class="nav__item"><a class="nav__link text_16" href="/#information">правовая информация</a></li>
                        <li class="nav__item"><a class="nav__link text_16" href="/">417417.ru</a></li>
                    </ul>
                    <a class="header__login text_14" href="#">
                        <svg class="icon icon-user header__icon">
                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                        </svg>
                        Войти
                    </a>
                </div>
                <div class="header__enter">
                <?php if(Yii::$app->user->isGuest) { ?>
                    <a class="header__login text_14" href="#">
                        <svg class="icon icon-user header__icon">
                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                        </svg>
                        Войти
                    </a>
                    <div id="modal_enter_phone" class="for_enter_wrap">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'inputphone-form',
                            'options' => [
                                // 'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
                            ]
                        ]);
                        ?>
                        <div class="for_enter">
                            <p class="for_enter__title text_16">
                                Для входа в личный кабинет
                                введите номер телефона
                            </p>
                            <?php

                            if($settings->disable_number_validation == false) {
                                echo $form->field($model, 'mobile_phone')->textInput(['maxlength' => true])
                                    ->widget(\yii\widgets\MaskedInput::class, [
                                        'mask' => '+7 (999) 999 99 99',
                                        'clientOptions' => [
                                            'placeholder' => '–',
                                        ],
                                        'options' => [
                                            'class' => 'for_enter__input'
                                        ]
                                    ])
                                    ->label(false);
                            }else {
                                $model->mobile_phone = '+7';
                                echo $form->field($model, 'mobile_phone')
                                    ->textInput([
                                        'maxlength' => true,
                                        'class' => 'use_imask'
                                    ])
                                    ->label(false);
                            }
                            ?>
                            <button id="submit-login-phone" class="for_enter__submit text_16" type="button" disabled>Продолжить</button>
                        </div>
                        <?php
                        ActiveForm::end();
                        ?>
                    </div>
                    <div id="modal_confirm_phone" class="for_enter_wrap"></div>
                    <div id="modal_enter_password" class="for_enter_wrap"></div>
                    <div id="modal_restorepassword" class="for_enter_wrap"></div>
                    <div id="modal_entersmscode" class="for_enter_wrap"></div>
                    <div id="modal_registration" class="for_enter_wrap"></div>
                <?php }else { ?>
                    <a class="header__login text_14" href="#" onclick="">
                        <i>
                            <svg class="icon icon-user header__icon">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                            </svg>
                        </i>
                        Я, <?= (mb_strlen(Yii::$app->user->identity->fio) > 11 ? mb_substr(Yii::$app->user->identity->fio, 0, 11) : Yii::$app->user->identity->fio) ?>
                    </a>
                    <div class="for_enter_wrap modal_enter" style="display: none;">
                     <div class="for_enter">
                       <ul>
                         <li><a href="/account/personal">Личный кабинет</a></li>
                         <hr>
                         <li><a href="#">t417.ru</a></li>
                         <hr>
                         <li><a href="/site/logout">Выход</a></li>
                       </ul>
                     </div>
                  </div>
                <?php } ?>
                </div>
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
    <?php // if(in_array($current_route, ['site/index', 'site/create-order', 'site/create-order-step2', 'site/check-order'])) { ?>
        <div class="content main-content" style="">
    <?php /*}else { ?>
        <div class="content" style="padding-top: 0 !important;" >
    <?php }*/ ?>
        <?php
        // echo 'current_controller='.$current_controller.'<br />';
        // echo 'current_route='.$current_route.'<br />';
        ?>
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
                            <div class="footer_menu__link__wrap">
                                <a class="footer_menu__link text_16" href="#">Политика конфиденциальности</a>
                                <a class="footer_menu__link text_16" href="#">Договор оферты</a>
                                <a class="footer_menu__link text_16" href="/">417417.ru</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_menu">
                            <?php if($current_route == 'site/index') { ?>
                                <div class="footer_menu__link__wrap">
                                    <a class="footer_menu__link text_16" href="/#new-order">Новый заказ</a>
                                    <a class="footer_menu__link text_16" href="/#">Наши преимущества</a>
                                    <a class="footer_menu__link text_16" href="/#information">Правовая информация</a>
                                    <a class="footer_menu__link text_16" href="/#terms">Условия предоставления услуг</a>
                                    <a class="footer_menu__link text_16" href="/#gallary">Галерея</a>
                                </div>
                            <?php }else { ?>
                                <div class="footer_menu__link__wrap">
                                    <a class="footer_menu__link text_16" href="/#new-order">Новый заказ</a>
                                    <a class="footer_menu__link text_16" href="/#">Наши преимущества</a>
                                    <a class="footer_menu__link text_16" href="/#information">Правовая информация</a>
                                    <a class="footer_menu__link text_16" href="/#terms">Условия предоставления услуг</a>
                                    <a class="footer_menu__link text_16" href="/#gallary">Галерея</a>
                                </div>
                            <?php } ?>

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
                            <p class="footer_copyright__text text_16">Мы используем информацию, зарегистрированную в файлах «cookies», в частности, в рекламных и статистических целях, а также для того, чтобы адаптировать наши сайты к индивидуальным потребностям Пользователей. Вы можете изменить настройки касающиеся «cookies» в вашем браузере. Изменение настроек может ограничить функциональность сайта.</p>
                            <p class="footer_copyright__text text_16">© 2019, OOO «417». Все права защищены.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php if($current_route == 'site/index') { ?>
    <!-- <ul class="social_box">
        <li class="social_box__item"><a class="social_box__link" href="#">
                <svg class="icon icon-facebook social_box__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#facebook"></use>
                </svg></a></li>
        <li class="social_box__item"><a class="social_box__link" href="#">
                <svg class="icon icon-twitter social_box__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#twitter"></use>
                </svg></a></li>
        <li class="social_box__item"><a class="social_box__link" href="#">
                <svg class="icon icon-instagram social_box__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#instagram"></use>
                </svg></a></li>
        <li class="social_box__item"><a class="social_box__link" href="#">
                <svg class="icon icon-youtube social_box__icon">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#youtube"></use>
                </svg></a></li>
    </ul> -->
    <?php } ?>
    <div id="modal-video"></div>
    <div class="iziModal" id="modal1">
        <div class="modal_global">
            <picture>
                <source class="modal_global__img" srcset="/images_new/content/mersedes1.webp" type="image/webp"><img class="modal_global__img" src="/images_new/content/mersedes1.jpg" alt="img">
            </picture>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
    </div>
    <div class="iziModal" id="modal2">
        <div class="modal_global">
            <picture>
                <source class="modal_global__img" srcset="/images_new/content/mersedes2.webp" type="image/webp"><img class="modal_global__img" src="/images_new/content/mersedes2.jpg" alt="img">
            </picture>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
    </div>
    <div class="iziModal" id="modal3">
        <div class="modal_global">
            <picture>
                <source class="modal_global__img" srcset="/images_new/content/mersedes3.webp" type="image/webp"><img class="modal_global__img" src="/images_new/content/mersedes3.jpg" alt="img">
            </picture>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
    </div>
    <div class="iziModal" id="modal4">
        <div class="modal_global">
            <picture>
                <source class="modal_global__img" srcset="/images_new/content/mersedes4.webp" type="image/webp"><img class="modal_global__img" src="/images_new/content/mersedes4.jpg" alt="img">
            </picture>
            <button class="close" type="button" name="close" data-izimodal-close>
                <svg class="icon icon-close close__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                </svg>
            </button>
        </div>
    </div>
    <div id="menu" class="mobile_menu">
        <div class="modal_global">
            <div class="modal_global__name"><span class="text_22">Главное меню</span>
                <button class="close" type="button" name="close" data-izimodal-close>
                    <svg class="icon icon-close close__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#close"></use>
                    </svg>
                </button>
            </div>
            <div class="modal_global__menu">
                <?php if(Yii::$app->user->isGuest) { ?>
                <a class="modal_global__login text_20" href="#" data-izimodal-open="#enter-mobile">
                    <svg class="icon icon-user header__icon">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                    </svg>Войти</a>
                <?php }else { ?>
                    <a class="modal_global__link text_20" href="/account/personal">
                        <svg class="icon icon-user header__icon">
                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#user"></use>
                        </svg>
                        Личный кабинет
                    </a>
                <?php } ?>
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
                <li class="nav__item"><a class="nav__link text_16" href="/#new-order">Новый заказ</a></li>
                <li class="nav__item"><a class="nav__link text_16" href="/#terms">Условия предоставления услуг</a></li>
                <li class="nav__item"><a class="nav__link text_16" href="/#information">Правовая информация</a></li>
                <li class="nav__item"><a class="nav__link text_16" href="/#contact">Контакты</a></li>
                <li class="nav__item"><a class="nav__link text_16" href="/">t417417.ru</a></li>
            </ul>
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
                            <div class="num_package">
                                <button class="num_package__btn btn_prev text_24" type="button" name="minus">-</button>
                                <input class="num_package__counter text_18" type="text" name="counter" value="0" readonly>
                                <button class="num_package__btn btn_next text_24" type="button" name="plus">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal_global__input children_append">
                        <div class="select__wrap">
                            <div class="select__title"><span class="text_18">Ребенок до 10 лет</span></div>
                            <div class="num_package last">
                                <button class="num_package__btn btn_prev text_24" type="button" name="minus">-</button>
                                <input name="ClientExt[child_count]" class="num_package__counter text_18" type="text" value="0" readonly>
                                <button class="num_package__btn btn_next text_24" type="button" name="plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal_global__bottom">
                    <button id="close-peoples-mobile" data-izimodal-close="" class="modal_global__submit text_16" type="button" disabled>Продолжить</button>
                </div>
            </div>
        </div> 
    </div>
    <div id="enter-mobile" class="mobile_menu">
        <?php
        $form = ActiveForm::begin([
            'id' => 'inputphone-form-mobile',
            'options' => [
                // 'client-ext-id' => ($client_ext != null ? $client_ext->id : 0),
            ]
        ]);
        ?>
        <div class="modal_global">
            <div class="modal_global__name">
                <button class="prev modal-prev" prev-modal="close" type="button" name="prev" data-izimodal-close>
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
                    <p class="modal_global__title text_16">Для входа в личный кабинет<br>введите номер телефона</p>
                    <!--
                    <input class="modal_global__input" type="tel" name="phone" placeholder="+7 (000) 000 - 00 - 00" autocomplete="off">
                    -->
                    <?php
                    echo $form->field($model, 'mobile_phone2')->textInput(['maxlength' => true])
                        ->widget(\yii\widgets\MaskedInput::class, [
                            'mask' => '+7 (999) 999 99 99',
                            'clientOptions' => [
                                'placeholder' => '–',
                            ],
                            'options' => [
                                'class' => 'modal_global__input'
                            ]
                        ])->label(false);
                    ?>
                </div>
                <div class="modal_global__btn">
                    <button id="submit-login-phone-mobile" class="modal_global__submit text_16 test" type="button" disabled>Продолжить</button>
                </div>
            </div>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
    <div style = "display: none">
        <div id="enter_password-mobile"></div>
        <div id="confirm_phone-mobile"></div>
        <div id="restorepassword-mobile"></div>
    </div>
    <div id="entersmscode-mobile" class="mobile_menu"></div>
    <div id="registration-mobile" class="mobile_menu"></div>
    <!--include ../modules/menuGlobal-->

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
</div>
<!--
<script src="/js/libs.min.js"></script>
<script src="/js/main.min.js"></script>
-->
<!--
<script src="/js/libs.js"></script>
<script src="/js/main_new.js"></script>
-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>