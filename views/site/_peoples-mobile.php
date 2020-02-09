<?php

use app\models\ClientExtChild;

?>
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
