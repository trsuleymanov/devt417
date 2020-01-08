<?php

use app\widgets\SelectWidget;
use yii\web\JsExpression;

// популярные яндекс-точки высадки
// echo "popular_yandex_points:<pre>"; print_r($popular_yandex_points); echo "</pre>";

// яндекс-точки высадки из последних 3 заказов
// echo "last_yandex_points:<pre>"; print_r($last_yandex_points); echo "</pre>";


?>

<div class="reservation-drop__select">
    <div class="reservation-drop__select-title">Выберите из списка точку высадки, наиболее удобную для вас</div>
    <div id="search-to-block" class="reservation-drop__select-select-wrap">
        <?php /*
        <input id="search-place-to" type="text" class="reservation-drop__select-select" autocomplete="off">
        <div class="search-result-block sw-select-block"></div>
        <div class="reservation-popup reservation-popup-select">
            <ul class="reservation-popup__list"></ul>
        </div>*/ ?>
        <?php
        // поиск по точкам города
        echo SelectWidget::widget([
            'name' => 'search_yandex_point_to_id',
            'initValueText' => ($model->yandex_point_from_id > 0 ? $model->yandexPointFrom->name : ''),
            'options' => [
                'placeholder' => 'Выберите точку',
                'class' => 'reservation-drop__search-input'
            ],
            'ajax' => [
                'url' => '/yandex-point/ajax-yandex-points?is_from=0&simple_id=1',
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
    <? if( count($last_yandex_points) || count($popular_yandex_points) ): ?>
        <ul class="reservation-drop__select-list">
            <? foreach($last_yandex_points as $point): ?>
                <li class="reservation-drop__select-item select-point-to" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
            <? endforeach; ?>
            <? foreach($popular_yandex_points as $point): ?>
                <li class="reservation-drop__select-item select-point-to" data-id = "<?= $point->id ?>" data-name = "<?= $point->name ?>" lat="<?= $point->lat ?>" lon="<?= $point->long ?>"><?= $point->name ?></li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>
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

