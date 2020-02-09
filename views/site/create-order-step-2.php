<?php

use app\models\ClientExtChild;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/create-order.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);



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
        border: 1px solid #dfdfdf;
        border-radius: 0 0 10px 10px;
        background: #fff;
        z-index: 40;
        height: 70px;
        overflow: hidden;
    }
</style>

<div id="order-step-2">
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        'client-ext-code' => $model->access_code,
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
                    //'mask' => '+7-999-999-99-99',
                    'mask' => '+7 (999) 999 99 99',
                    'value' => $model->phone,
                    'clientOptions' => [
                        //'placeholder' => '*',
                        'placeholder' => '–',
                    ],
                    'options' => [
                        //'placeholder' => '+7 999 999 99 99',
                        //'mask' => '+7 (999) 999 99 99',
                        'class' => "reservation-step__input-input required-input-step-2",
                        'style' => [
                            'width' => "200px;"
                        ]
                    ]
                ]);
                ?>
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

            </div>
        </div>
    </div>
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

<?php /*
<div id="reservation-calc" class="reservation-calc">
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
        <button id="submit-create-order-step-2" class="reservation-calc__button reservation-calc__button--disabled">Продолжить</button>
    </div>
</div>*/ ?>

<!-- Окно пассажиров(десктопная версия) + мест/стоимость + кнопка "Продолжить" -->
<?= $this->render('_reservation-calc', [
    'model' => $model,
    'client_ext_childs' => $client_ext_childs,
    'step' => 2
]) ?>

<!-- Окно пассажиров - мобильная версия -->
<?= $this->render('_peoples-mobile', [
    'client_ext_childs' => $client_ext_childs,
    'model' => $model,
]) ?>

<?php ActiveForm::end(); ?>
</div>