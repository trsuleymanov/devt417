<?php
use app\models\ClientExtChild;

?>
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
        <button id="submit-create-order-step-<?= $step ?>" class="reservation-calc__button reservation-calc__button--disabled text_24">Продолжить</button>
    </div>
</div>
