<?php

use yii\web\JsExpression;
use app\widgets\SelectWidget;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/create-order.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);

// echo "model:<pre>"; print_r($model); echo "</pre>";
//echo "errors:<pre>"; print_r($model->getErrors()); echo "</pre>";

$aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
?>
<style type="text/css">
    #search-place-from {
        width: 600px;
        color: #000000;
    }

    .select_gen_wrap {
        display: none;
        width: 120px;
        position: absolute;
        top: 100%;
        /* left: -1px; */
        border: 1px solid #dfdfdf;
        border-radius: 0 0 10px 10px;
        background: #fff;
        z-index: 40;
        height: 70px;
        /*overflow-y: scroll;*/
        overflow: hidden;
    }
    /*
    @media (max-width: 992px) {
        .select_gen_wrap {
            top: 121%;
            height: 52vw;
        }
    }*/
</style>
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        'client-ext-code' => $model->access_code,
        //'direction-id' => $model->direction_id,
        //'time' => $model->time
    ]
]);
?>

<input name="ClientExt[trip_id]" type="hidden" value="<?= $model->trip_id ?>" />
<input name="ClientExt[yandex_point_from_id]" type="hidden" value="<?= $model->yandex_point_from_id ?>" />
<input name="ClientExt[yandex_point_to_id]" type="hidden" value="<?= $model->yandex_point_to_id ?>" />

<div class="reservation-top">
    <div class="container">
        <div class="reservation-title-main">
            <a href="/site/create-order?c=<?= $model->access_code ?>"><img src="/images_new/back-top.svg" alt="" class="reservation-back"></a>

            <div class="reservation-title-wrap">
                <div class="reservation-title">Бронирование мест</div>
                <div class="reservation-undertitle reservation-undertitle--2 d-b">Шаг 2 из 3 - инф. о заказчике</div>
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


<div class="reservation-form reservation-form--step2 d-b">
<!--<form action="" class="reservation-form reservation-form--step2">-->
    <div class="container">
        <div class="reservation-step reservation-step--bordered">
            <div class="reservation-step__top">
                <div class="reservation-step__title">Заказчик</div>
                <div class="reservation-step__subtitle">Необходимо ввести, как минимум, фамилию - чтобы водитель смог идентифицировать вас при посадке</div>
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-name" class="reservation-step__input-label">Фамилия</label>
                <input type="text" name="ClientExt[last_name]" value="<?= $model->last_name ?>" class="reservation-step__input-input required-input-step-2" placeholder="Иванов">
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-name" class="reservation-step__input-label">Имя</label>
                <input type="text" name="ClientExt[first_name]" value="<?= $model->first_name ?>" class="reservation-step__input-input required-input-step-2" placeholder="Сергей">
            </div>
            <?php /*
            <label class="reservation-step__input-wrap welcome__col gen_select">
                <input name="ClientExt[gen]" type="hidden" value="<?= $model->gen ?>" />
                <label for="reservation-gen" class="reservation-step__input-label">Пол</label>
                <?php
                $gender = '';
                if($model->gen == 'female') {
                    $gender = 'Женский';
                }elseif($model->gen == 'male') {
                    $gender = 'Мужской';
                }
                ?>
                <input type="text" id="reservation-gen" class="reservation-step__input-input" placeholder="Мужской" autocomplete="off" value="<?= $gender ?>">
                <div class="select_gen_wrap" style="display: none;">
                    <div class="select_gen">
                        <button class="select_gen__item text_18" type="button" name="gen" data-gen="Женский" data-val="female">Женский</button>
                        <button class="select_gen__item text_18" type="button" name="gen" data-gen="Мужской" data-val="male">Мужской</button>
                    </div>
                </div>
            </label>
            */ ?>
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
                <?php
                echo MaskedInput::widget([
                    'id' => 'reservation-phone',
                    'name' => 'ClientExt[phone]',
                    'mask' => '+7-999-999-99-99',
                    'value' => $model->phone,
                    'clientOptions' => [
                        'placeholder' => '*',
                    ],
                    'options' => [
                        'placeholder' => '+7 999 999 99 99',
                        'class' => "reservation-step__input-input required-input-step-2",
                        'style' => [
                            'width' => "200px;"
                        ]
                    ]
                ]);
                ?>
                <!--
                <input type="text" id="reservation-phone" class="reservation-step__input-input required-input-step-2" placeholder="+7 999 999-99-99">
                -->
            </div>
            <div class="reservation-step__input-wrap">
                <label for="reservation-mail" class="reservation-step__input-label">E-mail</label>
                <?php
                echo $form->field($model, 'email')
                    ->textInput([
                        'id' => 'reservation-mail',
                        'class' => "reservation-step__input-input required-input-step-2",
                        'placeholder' => "sergei@gmail.com",
                        'style' => [
                            'width' => "100%"
                        ]

                    ])->label(false)
                ?>
                <!--
                <input type="text" id="reservation-mail" class="reservation-step__input-input required-input-step-2" placeholder="sergei@gmail.com">
                -->
            </div>
        </div>
    </div>
<!--</form>-->
</div>
<div class="container">
    <div class="reservation-average">
        <div class="reservation-average__title">Расчетное время в пути</div>
        <div class="reservation-average__time">3 ч 10 мин</div>
        <div class="reservation-average__small">в хороших погодных условиях</div>
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
                        <div class="reservation-popup__counter-minus btn_prev" field-type="child">-</div>
                        <div class="reservation-popup__counter-num"><?= $model->child_count ?></div>
                        <div class="reservation-popup__counter-plus btn_next" field-type="child">+</div>
                    </div>
                </div>
                <div class="reservation-popup__child-item">
                    <div class="reservation-popup__input-wrap input-arrow reservation-popup__input-child-wrap">
                        <input type="text" class="reservation-item__input reservation-popup__input reservation-popup__input-child" placeholder="Выберите возраст ребенка на момент поездки">
                    </div>
                    <div class="reservation-popup reservation-popup-child">
                        <ul class="reservation-popup__list">
                            <li class="reservation-popup__item-small">Меньше года</li>
                            <li class="reservation-popup__item-small">От 1 до 2 лет</li>
                            <li class="reservation-popup__item-small">От 3 до 6 лет</li>
                            <li class="reservation-popup__item-small">От 7 до 10 лет</li>
                        </ul>
                    </div>
                </div>
                <?php if(count($client_ext_childs) > 0) {
                    foreach ($client_ext_childs as $client_ext_child) { ?>
                        <div class="children_wrap">
                            <div class="children">
                                <div class="children__placeholder">
                                    <button class="children__title text_14" type="button" name="age" value="">
                                        <!--<span>Выберите возраст ребенка</span>-->
                                        <span class="children_complete"><?= $client_ext_child->getAgeName() ?></span>
                                        <svg class="icon icon-right-arrow children__icon">
                                            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                                        </svg>
                                    </button>
                                    <div class="children__list">
                                        <button class="children__item text_16" type="button" name="select">Меньше года</button><br>
                                        <button class="children__item text_16" type="button" name="select">От 1 до 2 лет</button><br>
                                        <button class="children__item text_16" type="button" name="select">От 3 до 6 лет</button><br>
                                        <button class="children__item text_16" type="button" name="select">От 7 до 10 лет</button>
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
            <li class="reservation-popup__item-big">
                <div class="reservation-popup__item-wrap">
                    <input name="ClientExt[student_count]" type="hidden" value="<?= $model->student_count ?>">
                    <div class="reservation-popup__item-text">Студент</div>
                    <div class="reservation-popup__counter">
                        <div class="reservation-popup__counter-minus" field-type="student">-</div>
                        <div class="reservation-popup__counter-num"><?= $model->student_count ?></div>
                        <div class="reservation-popup__counter-plus" field-type="student">+</div>
                    </div>
                </div>
            </li>
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
                <div class="reservation-calc__label-price">Стоимость</div>
                <div class="reservation-calc__price"><?= $model->getCalculatePrice('unprepayment'); ?></div>
            </div>
            <div class="reservation-calc__subline">при оплате банковской картой</div>
        </div>
    </div>
    <div class="reservation-calc__button-wrap">
        <div class="reservation-calc__button-price">0</div>
        <button id="submit-create-order-step-2" class="reservation-calc__button reservation-calc__button--disabled">Продолжить</button>
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
