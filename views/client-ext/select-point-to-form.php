<?php

// популярные яндекс-точки высадки
// echo "popular_yandex_points:<pre>"; print_r($popular_yandex_points); echo "</pre>";

// яндекс-точки высадки из последних 3 заказов
// echo "last_yandex_points:<pre>"; print_r($last_yandex_points); echo "</pre>";


?>

<div class="reservation-drop__select">
    <div class="reservation-drop__select-title">Выберите из списка точку высадки, наиболее удобную для вас</div>
    <div id="search-to-block" class="reservation-drop__select-select-wrap">
        <input id="search-place-to" type="text" class="reservation-drop__select-select" autocomplete="off">
        <div class="search-result-block sw-select-block"></div>
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
        <?php /*
        <li class="reservation-drop__select-item">РКБ</li>
        <li class="reservation-drop__select-item">ТЦ «Кольцо»</li>
        <li class="reservation-drop__select-item">Ж/Д Центр.</li>
        <li class="reservation-drop__select-item">Аэропорт</li>
        */ ?>
        <?php /*foreach ($some_points as $point) { ?>
            <li class="reservation-drop__select-item select-point-to" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
        <?php }*/ ?>
    </ul>
</div>
<div class="reservation-drop__dest">
    <div class="reservation-drop__dest-title">… или укажите на карте:</div>
    <div class="reservation-drop__dest-map">
        <div class="map-block">
            <div class="map-block-body">
                <div id="ya-map-to"></div>
            </div>
        </div>
    </div>
</div>

