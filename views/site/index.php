<?php

// $this->registerJsFile('/js/libs.js', ['depends'=>'app\assets\NewAppAsset']);
// $this->registerJsFile('/js/main_new.js', ['depends'=>'app\assets\NewAppAsset']);

//$this->registerCssFile('css/create-order.css', ['depends'=>'app\assets\NewAppAsset']);

?>
<div class="welcome_wrap" id="new-order">
    <div class="container">
        <div class="welcome">
            <div class="welcome__form">
                <h1 class="welcome__title title_36">закажите поездку<span>онлайн</span></h1>
                <div class="welcome__label">

                    <label class="welcome__col city_select"><span class="welcome__sub text_16">Откуда</span>
                        <input name="ClientExt[city_from_id]" type="hidden" />
                        <input id="city-from-text" class="welcome__input text_18" style="font-weight: 400;" type="text" name="out" autocomplete="off">
                        <div class="select_city_wrap city_out">
                            <div class="select_city">
                                <button class="select_city__item text_18" type="button" name="city" data-city="Альметьевск" data-val="2">Альметьевск</button>
                                <button class="select_city__item text_18" type="button" name="city" data-city="Казань" data-val="1">Казань</button>
                            </div>
                        </div>
                    </label>

                    <label class="welcome__col city_select">
                        <button class="welcome__icon btn_reverse" type="button" name="reverse">
                            <svg class="icon icon-exchange welcome__svg">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#exchange"></use>
                            </svg>
                        </button><span class="welcome__sub text_16">Куда</span>
                        <input name="ClientExt[city_to_id]" type="hidden" />
                        <input id="city-to-text" class="welcome__input text_18" style="font-weight: 400;" type="text" name="out" autocomplete="off">
                        <div class="select_city_wrap city_in">
                            <div class="select_city">
                                <button class="select_city__item text_18" type="button" name="city" data-city="Казань" data-val="1">Казань</button>
                                <button class="select_city__item text_18" type="button" name="city" data-city="Альметьевск" data-val="2">Альметьевск</button>
                            </div>
                        </div>
                    </label>
                </div>
                <div class="welcome__label">
                    <div class="welcome__col date_enter"><span class="welcome__sub text_16">Дата поездки</span>
                        <input name="ClientExt[data]" class="datepicker-here welcome__input text_18 fix_cursor" type="text" name="date" autocomplete="off" readonly id="picker-date">
                        <button class="welcome__icon" type="button" name="datepicker">
                            <svg class="icon icon-date welcome__svg">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#date"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="welcome__col date_enter"><span class="welcome__sub text_16">Время посадки</span>
                        <input name="ClientExt[time]" class="welcome__input text_18 fix_cursor" type="text" autocomplete="off" readonly data-position="bottom right" id="picker-time">
                        <button class="welcome__icon" type="button" name="time" id="btn-time">
                            <svg class="icon icon-clock welcome__svg">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#clock"></use>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="welcome__label welcome__label__peoples last_label">

                    <div class="welcome__row" id="peoples"><span class="welcome__sub text_16">Пассажиры</span>

                        <?php /*
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
                                            <div class="reservation-popup__counter-num">0</div>
                                            <div class="reservation-popup__counter-plus" field-type="adult">+</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="reservation-popup__item-big reservation-popup__item-big-child children_append">
                                    <div class="reservation-popup__item-wrap">
                                        <input name="ClientExt[child_count]" type="hidden" value="0">
                                        <div class="reservation-popup__item-text">Ребенок</div>
                                        <div class="reservation-popup__counter reservation-popup__counter-child">
                                            <div class="reservation-popup__counter-minus btn_prev" field-type="child">-</div>
                                            <div class="reservation-popup__counter-num">0</div>
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
                                </li>
                                <li class="reservation-popup__item-big">
                                    <div class="reservation-popup__item-wrap">
                                        <input name="ClientExt[student_count]" type="hidden" value="0">
                                        <div class="reservation-popup__item-text">Студент</div>
                                        <div class="reservation-popup__counter">
                                            <div class="reservation-popup__counter-minus" field-type="student">-</div>
                                            <div class="reservation-popup__counter-num">0</div>
                                            <div class="reservation-popup__counter-plus" field-type="student">+</div>
                                        </div>
                                    </div>
                                </li>
                        </div>
                        */ ?>

                        <input name="ClientExt[places_count]" class="welcome__input text_18 fix_cursor" type="text" autocomplete="off" value="0 человек" readonly>
                        <div class="welcome__icon fix_icon">
                            <svg class="icon icon-users welcome__svg">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#users"></use>
                            </svg>
                        </div>
                    </div>
                    <div class="select">
                        <div class="select__item">
                            <div class="select__title text_18">Взрослый</div>
                            <div class="num_package">
                                <button class="num_package__btn btn_prev text_24" type="button" name="minus">-</button>
                                <input class="num_package__counter text_18" type="text" name="counter" value="0" readonly>
                                <button class="num_package__btn btn_next text_24" type="button" name="plus">+</button>
                            </div>
                        </div>
                        <div class="select__item children_append">
                            <div class="select__wrap">
                                <div class="select__title"><span class="text_18">Ребенок</span><span class="text_16">до 10 лет</span></div>
                                <div class="num_package last">
                                    <button class="num_package__btn btn_prev text_24" type="button" name="minus">-</button>
                                    <input name="ClientExt[child_count]" class="num_package__counter text_18" type="text" value="0" readonly>
                                    <button class="num_package__btn btn_next text_24" type="button" name="plus">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="select__item"><span class="select__title text_18">Студент</span>
                            <div class="num_package">
                                <button class="num_package__btn btn_prev text_24" type="button" name="minus">-</button>
                                <input name="ClientExt[student_count]" class="num_package__counter text_18" type="text" value="0" readonly>
                                <button class="num_package__btn btn_next text_24" type="button" name="plus">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="welcome__btn error__wrapper">
                    <button id="submit-order-form" class="welcome__submit text_24" type="button" name="submit">Заказать</button>
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="list_info_wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="list_info">
                    <div class="list_info__icon">
                        <div class = "list_info__img">
                            <svg viewBox="0 0 612 612"><path d="M306,0.006C137,0.006,0,137,0,306s137,305.994,306,305.994C474.994,611.994,612,475,612,306S474.994,0.006,306,0.006z M306,550.795C171.02,550.795,61.205,440.98,61.205,306S171.02,61.205,306,61.205S550.795,171.02,550.795,306 S440.98,550.795,306,550.795z"/><path d="M471.524,186.754c-3.898-5.532-11.536-6.848-17.068-2.95l-134.594,94.95c-4.168-2.13-8.868-3.348-13.862-3.348 c-2.313,0-4.553,0.282-6.72,0.765l-96.345-81.982c-5.147-4.388-12.864-3.764-17.258,1.389l-7.925,9.314 c-4.388,5.147-3.764,12.87,1.383,17.258l96.357,82c-0.037,0.618-0.092,1.23-0.092,1.854c0,15.483,11.573,28.292,26.524,30.293V510 h8.164V336.293c14.945-2.007,26.517-14.81,26.517-30.293c0-1.328-0.116-2.625-0.282-3.911l134.601-94.95 c5.526-3.898,6.848-11.536,2.95-17.062L471.524,186.754z"/></svg>
                        </div>
                    </div>
                    <div class="list_info__main">
                        <h5 class="list_info__title">Без ожидания<br>на линии</h5>
                        <p class="list_info__text">
                            Оформление заказа
                            происходит без участия
                            оператора онлайн
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="list_info">
                    <div class="list_info__icon">
                        <div class = "list_info__img">
                            <svg viewBox="0 0 612 545.53"><path d="M588.63,80,213.81.64a29.56,29.56,0,0,0-34.93,22.73l-7.12,45.76,432.48,91.52,7.12-45.76A29.56,29.56,0,0,0,588.63,80Z" transform="translate(0)"/><path d="M431,170.36a29.84,29.84,0,0,0-36.61-20.71L323.24,169.4,155.5,133.9,137,221.06l-115.26,32A29.83,29.83,0,0,0,1.08,289.66L66,523.74a29.84,29.84,0,0,0,36.62,20.71L475.26,441A29.84,29.84,0,0,0,496,404.43l-11.15-40.18,41.79,8.83a29.55,29.55,0,0,0,34.93-22.73L588,225.42,437.45,193.56Zm43,119,9.21-43.55a12.17,12.17,0,0,1,14.37-9.35l43.55,9.22A12.16,12.16,0,0,1,550.53,260l-9.22,43.55a12.16,12.16,0,0,1-14.37,9.35L483.4,303.7A12.16,12.16,0,0,1,474,289.33ZM28.27,276.41l103.11-28.61,243.3-67.52L400.86,173a5.45,5.45,0,0,1,1.42-.19,5.62,5.62,0,0,1,5.35,4l3.07,11.07,9.63,34.7L37.15,329l-12.7-45.77A5.58,5.58,0,0,1,28.27,276.41ZM472.6,410.91a5.59,5.59,0,0,1-3.83,6.77L96.17,521.08a5.42,5.42,0,0,1-1.42.2,5.63,5.63,0,0,1-5.35-4L51.52,380.72,434.71,274.38l23.37,84.21Z" transform="translate(0)"/><path d="M156.38,420.25a12.16,12.16,0,0,0-14.93-8.44L97.94,423.89a12.16,12.16,0,0,0-8.44,14.93l12.07,43.51a12.16,12.16,0,0,0,14.93,8.44L160,478.69a12.16,12.16,0,0,0,8.44-14.93Z" transform="translate(0)"/></svg>
                        </div>
                    </div>
                    <div class="list_info__main">
                        <h5 class="list_info__title">Безналичная<br>оплата</h5>
                        <p class="list_info__text">
                            Заказ можно оплатить
                            банковской картой,
                            безопасность гарантирована
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="list_info">
                    <div class="list_info__icon">
                        <div class = "list_info__img">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><style>.cls-1{fill:none;}</style></defs><title>qr-code</title><rect x="360" width="40" height="40"/><rect x="400" width="40" height="40"/><rect x="440" width="40" height="40"/><rect x="520" width="40" height="40"/><rect x="640" width="40" height="40"/><rect x="320" y="40" width="40" height="40"/><rect x="480" y="40" width="40" height="40"/><rect x="560" y="40" width="40" height="40"/><rect x="600" y="40" width="40" height="40"/><rect x="640" y="40" width="40" height="40"/><rect x="440" y="80" width="40" height="40"/><rect x="480" y="80" width="40" height="40"/><rect x="520" y="80" width="40" height="40"/><rect x="560" y="80" width="40" height="40"/><rect x="640" y="80" width="40" height="40"/><rect x="400" y="120" width="40" height="40"/><rect x="480" y="120" width="40" height="40"/><rect x="520" y="120" width="40" height="40"/><rect x="560" y="120" width="40" height="40"/><rect x="600" y="120" width="40" height="40"/><rect x="320" y="160" width="40" height="40"/><rect x="560" y="160" width="40" height="40"/><rect x="360" y="200" width="40" height="40"/><rect x="400" y="200" width="40" height="40"/><rect x="440" y="200" width="40" height="40"/><rect x="480" y="200" width="40" height="40"/><rect x="520" y="200" width="40" height="40"/><rect x="320" y="240" width="40" height="40"/><rect x="400" y="240" width="40" height="40"/><rect x="480" y="240" width="40" height="40"/><rect x="560" y="240" width="40" height="40"/><rect x="640" y="240" width="40" height="40"/><rect x="400" y="280" width="40" height="40"/><rect x="440" y="280" width="40" height="40"/><rect x="520" y="280" width="40" height="40"/><rect x="560" y="280" width="40" height="40"/><rect x="640" y="280" width="40" height="40"/><rect y="320" width="40" height="40"/><rect x="80" y="320" width="40" height="40"/><rect x="160" y="320" width="40" height="40"/><rect x="240" y="320" width="40" height="40"/><rect x="360" y="320" width="40" height="40"/><rect x="400" y="320" width="40" height="40"/><rect x="480" y="320" width="40" height="40"/><rect x="560" y="320" width="40" height="40"/><rect x="600" y="320" width="40" height="40"/><rect x="640" y="320" width="40" height="40"/><rect x="800" y="320" width="40" height="40"/><rect x="920" y="320" width="40" height="40"/><rect x="120" y="360" width="40" height="40"/><rect x="200" y="360" width="40" height="40"/><rect x="280" y="360" width="40" height="40"/><rect x="360" y="360" width="40" height="40"/><rect x="400" y="360" width="40" height="40"/><rect x="480" y="360" width="40" height="40"/><rect x="560" y="360" width="40" height="40"/><rect x="600" y="360" width="40" height="40"/><rect x="720" y="360" width="40" height="40"/><rect x="760" y="360" width="40" height="40"/><rect x="960" y="360" width="40" height="40"/><rect x="80" y="400" width="40" height="40"/><rect x="120" y="400" width="40" height="40"/><rect x="200" y="400" width="40" height="40"/><rect x="240" y="400" width="40" height="40"/><rect x="280" y="400" width="40" height="40"/><rect x="320" y="400" width="40" height="40"/><rect x="400" y="400" width="40" height="40"/><rect x="440" y="400" width="40" height="40"/><rect x="520" y="400" width="40" height="40"/><rect x="680" y="400" width="40" height="40"/><rect x="720" y="400" width="40" height="40"/><rect x="800" y="400" width="40" height="40"/><rect x="880" y="400" width="40" height="40"/><rect x="920" y="400" width="40" height="40"/><rect x="960" y="400" width="40" height="40"/><rect y="440" width="40" height="40"/><rect x="80" y="440" width="40" height="40"/><rect x="120" y="440" width="40" height="40"/><rect x="160" y="440" width="40" height="40"/><rect x="400" y="440" width="40" height="40"/><rect x="480" y="440" width="40" height="40"/><rect x="600" y="440" width="40" height="40"/><rect x="640" y="440" width="40" height="40"/><rect x="680" y="440" width="40" height="40"/><rect x="920" y="440" width="40" height="40"/><rect y="480" width="40" height="40"/><rect x="240" y="480" width="40" height="40"/><rect x="280" y="480" width="40" height="40"/><rect x="320" y="480" width="40" height="40"/><rect x="400" y="480" width="40" height="40"/><rect x="440" y="480" width="40" height="40"/><rect x="480" y="480" width="40" height="40"/><rect x="720" y="480" width="40" height="40"/><rect x="760" y="480" width="40" height="40"/><rect x="840" y="480" width="40" height="40"/><rect x="920" y="480" width="40" height="40"/><rect x="960" y="480" width="40" height="40"/><rect x="40" y="520" width="40" height="40"/><rect x="80" y="520" width="40" height="40"/><rect x="120" y="520" width="40" height="40"/><rect x="160" y="520" width="40" height="40"/><rect x="200" y="520" width="40" height="40"/><rect x="280" y="520" width="40" height="40"/><rect x="360" y="520" width="40" height="40"/><rect x="440" y="520" width="40" height="40"/><rect x="480" y="520" width="40" height="40"/><rect x="520" y="520" width="40" height="40"/><rect x="640" y="520" width="40" height="40"/><rect x="720" y="520" width="40" height="40"/><rect x="840" y="520" width="40" height="40"/><rect x="960" y="520" width="40" height="40"/><rect y="560" width="40" height="40"/><rect x="120" y="560" width="40" height="40"/><rect x="240" y="560" width="40" height="40"/><rect x="280" y="560" width="40" height="40"/><rect x="360" y="560" width="40" height="40"/><rect x="440" y="560" width="40" height="40"/><rect x="480" y="560" width="40" height="40"/><rect x="560" y="560" width="40" height="40"/><rect x="640" y="560" width="40" height="40"/><rect x="720" y="560" width="40" height="40"/><rect x="760" y="560" width="40" height="40"/><rect x="880" y="560" width="40" height="40"/><rect x="920" y="560" width="40" height="40"/><rect x="960" y="560" width="40" height="40"/><rect x="40" y="600" width="40" height="40"/><rect x="200" y="600" width="40" height="40"/><rect x="320" y="600" width="40" height="40"/><rect x="400" y="600" width="40" height="40"/><rect x="480" y="600" width="40" height="40"/><rect x="520" y="600" width="40" height="40"/><rect x="560" y="600" width="40" height="40"/><rect x="800" y="600" width="40" height="40"/><rect x="920" y="600" width="40" height="40"/><rect y="640" width="40" height="40"/><rect x="200" y="640" width="40" height="40"/><rect x="240" y="640" width="40" height="40"/><rect x="320" y="640" width="40" height="40"/><rect x="360" y="640" width="40" height="40"/><rect x="440" y="640" width="40" height="40"/><rect x="560" y="640" width="40" height="40"/><rect x="640" y="640" width="40" height="40"/><rect x="680" y="640" width="40" height="40"/><rect x="720" y="640" width="40" height="40"/><rect x="760" y="640" width="40" height="40"/><rect x="800" y="640" width="40" height="40"/><rect x="840" y="640" width="40" height="40"/><rect x="320" y="680" width="40" height="40"/><rect x="360" y="680" width="40" height="40"/><rect x="440" y="680" width="40" height="40"/><rect x="560" y="680" width="40" height="40"/><rect x="640" y="680" width="40" height="40"/><rect x="800" y="680" width="40" height="40"/><rect x="840" y="680" width="40" height="40"/><rect x="920" y="680" width="40" height="40"/><rect x="960" y="680" width="40" height="40"/><rect x="360" y="720" width="40" height="40"/><rect x="520" y="720" width="40" height="40"/><rect x="600" y="720" width="40" height="40"/><rect x="640" y="720" width="40" height="40"/><rect x="720" y="720" width="40" height="40"/><rect x="800" y="720" width="40" height="40"/><rect x="840" y="720" width="40" height="40"/><rect x="920" y="720" width="40" height="40"/><rect x="960" y="720" width="40" height="40"/><rect x="360" y="760" width="40" height="40"/><rect x="440" y="760" width="40" height="40"/><rect x="640" y="760" width="40" height="40"/><rect x="800" y="760" width="40" height="40"/><rect x="840" y="760" width="40" height="40"/><rect x="960" y="760" width="40" height="40"/><rect x="320" y="800" width="40" height="40"/><rect x="360" y="800" width="40" height="40"/><rect x="480" y="800" width="40" height="40"/><rect x="640" y="800" width="40" height="40"/><rect x="680" y="800" width="40" height="40"/><rect x="720" y="800" width="40" height="40"/><rect x="760" y="800" width="40" height="40"/><rect x="800" y="800" width="40" height="40"/><rect x="840" y="800" width="40" height="40"/><rect x="920" y="800" width="40" height="40"/><rect x="440" y="840" width="40" height="40"/><rect x="480" y="840" width="40" height="40"/><rect x="520" y="840" width="40" height="40"/><rect x="600" y="840" width="40" height="40"/><rect x="640" y="840" width="40" height="40"/><rect x="680" y="840" width="40" height="40"/><rect x="760" y="840" width="40" height="40"/><rect x="800" y="840" width="40" height="40"/><rect x="840" y="840" width="40" height="40"/><rect x="880" y="840" width="40" height="40"/><rect x="920" y="840" width="40" height="40"/><rect x="320" y="880" width="40" height="40"/><rect x="360" y="880" width="40" height="40"/><rect x="400" y="880" width="40" height="40"/><rect x="440" y="880" width="40" height="40"/><rect x="480" y="880" width="40" height="40"/><rect x="560" y="880" width="40" height="40"/><rect x="600" y="880" width="40" height="40"/><rect x="680" y="880" width="40" height="40"/><rect x="800" y="880" width="40" height="40"/><rect x="960" y="880" width="40" height="40"/><rect x="360" y="920" width="40" height="40"/><rect x="480" y="920" width="40" height="40"/><rect x="520" y="920" width="40" height="40"/><rect x="560" y="920" width="40" height="40"/><rect x="600" y="920" width="40" height="40"/><rect x="640" y="920" width="40" height="40"/><rect x="800" y="920" width="40" height="40"/><rect x="840" y="920" width="40" height="40"/><rect x="920" y="920" width="40" height="40"/><rect x="320" y="960" width="40" height="40"/><rect x="440" y="960" width="40" height="40"/><rect x="560" y="960" width="40" height="40"/><rect x="640" y="960" width="40" height="40"/><rect x="680" y="960" width="40" height="40"/><rect x="760" y="960" width="40" height="40"/><rect x="920" y="960" width="40" height="40"/><rect x="960" y="960" width="40" height="40"/><rect class="cls-1" x="42" y="42" width="196" height="196"/><path d="M238,2H0V282H280V2Zm0,238H42V44H238Z" transform="translate(0 -2)"/><rect class="cls-1" x="762" y="42" width="196" height="196"/><path d="M958,2H720V282h280V2Zm0,238H762V44H958Z" transform="translate(0 -2)"/><rect class="cls-1" x="42" y="762" width="196" height="196"/><path d="M238,722H0v280H280V722Zm0,238H42V764H238Z" transform="translate(0 -2)"/><rect x="80" y="80" width="120" height="120"/><rect x="800" y="80" width="120" height="120"/><rect x="80" y="800" width="120" height="120"/></svg>
                        </div>
                    </div>
                    <div class="list_info__main">
                        <h5 class="list_info__title">Возврат<br>билетов</h5>
                        <p class="list_info__text">
                            Быстрое оформление
                            возврата в личном<br>кабинете
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="list_info">
                    <div class="list_info__icon">
                        <div class = "list_info__img">
                            <svg viewBox="0 0 612 612"><path d="M567.297,106.951C416.932,18.793,306.283,0,306.283,0S306.166,0.018,306,0.049C305.834,0.018,305.717,0,305.717,0 S195.062,18.793,44.703,106.951c0,0-19.938,445.063,261.014,505.049c0.098-0.018,0.185-0.049,0.283-0.068 c0.098,0.018,0.185,0.049,0.283,0.068C587.229,552.014,567.297,106.951,567.297,106.951z M306.302,37.79 c24.615,5.323,111.049,27.451,223.778,90.686c-0.492,82.194-14.553,393.213-223.778,445.482V37.79L306.302,37.79z"/></svg>
                        </div>
                    </div>
                    <div class="list_info__main">
                        <h5 class="list_info__title">Квалифицированные<br>водители</h5>
                        <p class="list_info__text">
                            Только лицензированные
                            перевозчики и водители
                            со стажем более 15 лет
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="services_wrap" id="terms">
    <div class="container">
        <div class="services">
            <h3 class="services__title text_26">Условия предоставления услуг</h3>
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
                <button class="services__read text_26" type="button" name="read">Читать полностью
                    <svg class="icon icon-right-arrow services__read__svg">
                        <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="information_wrap" id="information">
    <div class="container">
        <div class="information">
            <h3 class="information__title title_30">Правовая информация
                <svg class="icon icon-right-arrow information__svg">
                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#right-arrow"></use>
                </svg>
            </h3>
            <p class="information__text text_18">Сервис — лицо, самостоятельно организующее и (или) осуществляющее обработку персональных данных, а также определяющее цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными. льных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>
        </div>
    </div>
</div>
<div id="gallary" class="cars_wrap">
    <div class="cars">
        <div class="cars__row"><a class="cars__item" href="#" data-izimodal-open="#modal1">
                <picture>
                    <source class="cars__img" srcset="/images_new/content/mersedes1.webp" type="image/webp"><img class="cars__img" src="/images_new/content/mersedes1.jpg" alt="img">
                </picture></a><a class="cars__item" href="#" data-izimodal-open="#modal2">
                <picture>
                    <source class="cars__img" srcset="/images_new/content/mersedes2.webp" type="image/webp"><img class="cars__img" src="/images_new/content/mersedes2.jpg" alt="img">
                </picture></a></div>
        <div class="cars__row"><a class="cars__item" href="#" data-izimodal-open="#modal3">
                <picture>
                    <source class="cars__img" srcset="/images_new/content/mersedes3.webp" type="image/webp"><img class="cars__img" src="/images_new/content/mersedes3.jpg" alt="img">
                </picture></a><a class="cars__item" href="#" data-izimodal-open="#modal4">
                <picture>
                    <source class="cars__img" srcset="/images_new/content/mersedes4.webp" type="image/webp"><img class="cars__img" src="/images_new/content/mersedes4.jpg" alt="img">
                </picture></a></div>
        <div class="cars__btn">
            <button class="cars__more text_18" type="button" name="more">Больше фото</button>
        </div>
    </div>
</div>
<div class="video_wrap">
    <div class="video"></div><a class="video__link text_28" href="#" data-video="https://player.vimeo.com/video/33219961" data-title="This title for your video..." data-izimodal-open="#modal-video">
        <svg class="icon icon-play video__svg">
            <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#play"></use>
        </svg>Смотреть видео</a>
</div>
<div id="contact" class="contacts_wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="map">
                    <iframe class="map__img" src="https://yandex.ru/map-widget/v1/-/CGGdn05A" allowfullscreen="“true”"></iframe>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contacts">
                    <h6 class="contacts__title text_28">Наши контакты</h6>
                    <ul class="social">
                        <li class="social__item"><a class="social__link" href="#">
                                <svg class="icon icon-facebook social__icon">
                                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#facebook"></use>
                                </svg></a></li>
                        <li class="social__item"><a class="social__link" href="#">
                                <svg class="icon icon-instagram social__icon">
                                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#instagram"></use>
                                </svg></a></li>
                        <li class="social__item"><a class="social__link" href="#">
                                <svg class="icon icon-twitter social__icon">
                                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#twitter"></use>
                                </svg></a></li>
                        <li class="social__item"><a class="social__link" href="#">
                                <svg class="icon icon-youtube social__icon">
                                    <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#youtube"></use>
                                </svg></a></li>
                    </ul>
                    <ul class="contacts_list">
                        <li class="contacts_list__item">
                            <svg class="icon icon-flag contacts_list__icon">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#flag"></use>
                            </svg>
                            <div class="contacts_list__info">
                                <p class="contacts_list__text text_18">г. Название города, ул. Название улицы, дом 111</p>
                            </div>
                        </li>
                        <li class="contacts_list__item">
                            <svg class="icon icon-phone contacts_list__icon">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#phone"></use>
                            </svg>
                            <div class="contacts_list__info"><a class="contacts_list__link text_18" href="#">+7(000) 000-00-00</a></div>
                        </li>
                        <li class="contacts_list__item">
                            <svg class="icon icon-envelope contacts_list__icon">
                                <use xlink:href="/images_new/svg-sprites/symbol/sprite.svg#envelope"></use>
                            </svg>
                            <div class="contacts_list__info"><a class="contacts_list__link text_18" href="#">info@417.ru</a><br><a class="contacts_list__link text_18" href="#">skype: abc12345</a></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
