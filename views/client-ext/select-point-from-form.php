<?php

// популярные яндекс-точки посадки
// echo "popular_yandex_points:<pre>"; print_r($popular_yandex_points); echo "</pre>";

// яндекс-точки посадки с супер тарифом
// echo "super_yandex_points:<pre>"; print_r($super_yandex_points); echo "</pre>";

// яндекс-точки посадки из последних 3 заказов
// echo "last_yandex_points:<pre>"; print_r($last_yandex_points); echo "</pre>";

// $super_yandex_points = $last_yandex_points;

// echo "tariff:<pre>"; print_r($tariff); echo "</pre>";

?>

<?php if(count($super_yandex_points) > 0) { ?>
    <div class="reservation-drop-offer">
        <div class="reservation-drop-offer__cover">
            <div class="reservation-drop-offer__cover-wrap">
                <div class="reservation-drop-offer__cover-title">Совершите<br>поездку за <b><?= $tariff->superprepayment_common_price ?></b> руб.</div>
                <div class="reservation-drop-offer__cover-subtitle">Выберите адрес из опций быстрого выезда. Цена за одно место действует при условии предоплаты.</div>
            </div>
            <img src="/images_new/arrow-tab.png" alt="" class="reservation-drop-offer__cover-arrow">
        </div>
        <ul class="reservation-drop-offer__list">
            <?php foreach ($super_yandex_points as $yandex_point) { ?>
                <li class="reservation-drop-offer__item" yandex-point-id="<?= $yandex_point->id ?>">
                    <div class="reservation-drop-offer__item-title">«<?= $yandex_point->name ?>» - <b><?= $tariff->superprepayment_common_price ?></b> руб.</div>
                    <!--<div class="reservation-drop-offer__item-subtitle">ул. Ленина, 92</div>-->
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<? if( $model->cityFrom->extended_external_use ): ?>

    <div class="reservation-drop__search">

        <div class="reservation-drop__search-text">… или введите адрес вручную для выбора точки посадки рядом с домом</div>
        <div id="search-from-block" class="reservation-drop__search-input-wrap">
            <input id="search-place-from" type="text" class="reservation-drop__search-input" autocomplete="none" placeholder="Начните вводить адрес..." />
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

    <div class="reservation-drop__select">
        <div class="reservation-drop__select-title">Выберите из списка точку высадки, наиболее удобную для вас</div>
        <div id="search-to-block" class="reservation-drop__select-select-wrap">
            <input id="search-place-to" type="text" class="reservation-drop__select-select" autocomplete="off">
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
    </div>

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
        <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3Ad85c33d8c2998c0058266a0bafaaa69c1c2197088f04a1e4ed222bdbeca7aa6b&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
    </div>
</div>
<div class="reservation-drop__time"></div>
