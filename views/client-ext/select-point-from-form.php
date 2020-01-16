<?php

use app\widgets\PointSelectWidget;
use yii\web\JsExpression;

// популярные яндекс-точки отправления
// echo "popular_yandex_points:<pre>"; print_r($popular_yandex_points); echo "</pre>";

// яндекс-точки посадки с супер тарифом
// echo "super_yandex_points:<pre>"; print_r($super_yandex_points); echo "</pre>";

// яндекс-точки посадки из последних 3 заказов
// echo "last_yandex_points:<pre>"; print_r($last_yandex_points); echo "</pre>";

// echo "tariff:<pre>"; print_r($tariff); echo "</pre>";

?>

<?php

if(count($super_yandex_points) > 0) { ?>
    <div class="reservation-drop-offer">
        <div class="reservation-drop-offer__cover">
            <div class="reservation-drop-offer__cover-wrap">
                <div class="reservation-drop-offer__cover-title">Совершите поездку за <b><?= $tariff->superprepayment_common_price ?></b> руб.</div>
                <div class="reservation-drop-offer__cover-subtitle">Выберите адрес из опций быстрого выезда. Цена за одно место действует при условии предоплаты.</div>
            </div>
            <img src="/images_new/arrow-tab.png" alt="" class="reservation-drop-offer__cover-arrow">
        </div>
        <ul class="reservation-drop-offer__list">
            <?php foreach ($super_yandex_points as $yandex_point) { ?>
                <li class="reservation-drop-offer__item" yandex-point-id="<?= $yandex_point->id ?>">
                    <div class="reservation-drop-offer__item-title">«<?= $yandex_point->name ?>» - <b><?= $tariff->superprepayment_common_price ?></b> руб.</div>
                    <? if( $yandex_point->description != '' ): ?>
                        <div class="reservation-drop-offer__item-subtitle"><?=$yandex_point->description;?></div>
                    <? endif; ?>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<? if( $model->cityFrom->extended_external_use ): ?>

    <div class="reservation-drop__search">

        <div class="reservation-drop__search-text">… или введите адрес вручную для выбора точки посадки рядом с домом</div>
        <div id="search-from-block" city-extended-external-use="1" class="reservation-drop__search-input-wrap">
            <input id="search-place-from" type="text" class="reservation-drop__search-input" autocomplete="off" placeholder="Начните вводить адрес..." />
            <div class="search-result-block sw-select-block"></div>
        </div>
        <div class="reservation-drop__search-geo"><span>использовать мою геопозицию</span></div>

        <? if( count($last_yandex_points) || count($popular_yandex_points) ): ?>
            <ul class="reservation-drop__select-list">
                <? foreach($last_yandex_points as $point): ?>
                    <li class="reservation-drop__select-item select-point-from" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
                <? endforeach; ?>
                <? foreach($popular_yandex_points as $point): ?>
                    <li class="reservation-drop__select-item select-point-from" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>

    </div>

<? else: ?>

    <div class="reservation-drop__search">
        <div class="reservation-drop__search-text">Выберите из списка точку посадки, наиболее удобную для вас</div>
        <div id="search-from-block" city-extended-external-use="0" class="reservation-drop__search-input-wrap">
            <?php
            // поиск по точкам города
            echo PointSelectWidget::widget([
                'name' => 'search_yandex_point_from_id',
                'initValueText' => ($model->yandex_point_from_id > 0 ? $model->yandexPointFrom->name : ''),
                'options' => [
                    'placeholder' => 'Выберите точку',
                    'class' => 'reservation-drop__search-input'
                ],
                'ajax' => [
                    'url' => '/yandex-point/ajax-yandex-points?is_from=1&simple_id=1',
                    'data' => new JsExpression('function(params) {
                        return {
                            search: params.search,
                            direction_id: "'.$model->direction_id.'"
                        };
                    }')
                ],
                'using_delete_button' => false // отключен bootstrap, поэтому значка нет
            ]);
            ?>
        </div>
        <div class="reservation-drop__search-geo"><span>использовать мою геопозицию</span></div>

        <ul class="reservation-drop__select-list">
            <? if( count($last_yandex_points) || count($popular_yandex_points) ): ?>
                <ul class="reservation-drop__select-list">
                    <? foreach($last_yandex_points as $point): ?>
                        <li class="reservation-drop__select-item select-point-from" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
                    <? endforeach; ?>
                    <? foreach($popular_yandex_points as $point): ?>
                        <li class="reservation-drop__select-item select-point-from" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>

        </ul>

    </div>

    <?php /*
    <div class="reservation-drop__select">
        <div id="search-from-block" class="reservation-drop__select-select-wrap">
            <input id="search-place-from" type="text" class="reservation-drop__select-select" autocomplete="off">
            <div class="search-result-block sw-select-block"></div>
            <div class="reservation-popup reservation-popup-select">
                <ul class="reservation-popup__list"></ul>
            </div>
        </div>
        <div class="reservation-drop__search-geo"><span>использовать мою геопозицию</span></div>
        <ul class="reservation-drop__select-list">
            <?php foreach ($last_yandex_points as $point) { ?>
                <li class="reservation-drop__select-item select-point-from" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
            <?php } ?>
        </ul>
    </div>*/ ?>

<? endif; ?>

<div class="reservation-drop__map">
    <?php /*
    <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
    */ ?>
    <div class="map-block">
        <div class="map-block-body">
            <div id="ya-map-from"></div>
        </div>
    </div>
</div>
<div class="reservation-drop__selected">
    <div class="reservation-drop__selected-big">Выбрана точка посадки:</div>
    <div class="reservation-drop__selected-showmap">
        <div class="reservation-drop__selected-address">адрес/название точки</div>
        <div class="reservation-drop__selected-showmap-wrap">
            <span class = "reservation-drop__selected-showmap-trigger">на карте</span>
        </div>
    </div>
    <div class="reservation-drop__selected-map">
        <?php /*
        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
        */ ?>
        <div id="ya-map-from2"></div>
    </div>
</div>
<div class="reservation-drop__time"></div>
