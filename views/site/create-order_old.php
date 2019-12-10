<?php

use yii\web\JsExpression;
use app\widgets\SelectWidget;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/create-order.js', ['depends'=>'app\assets\NewAppAsset', 'position' => \yii\web\View::POS_END]);

// echo "model:<pre>"; print_r($model); echo "</pre>";
//echo "errors:<pre>"; print_r($model->getErrors()); echo "</pre>";
?>
<style type="text/css">
    #search-place-from {
        width: 600px;
        color: #000000;
    }
</style>
<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
    'options' => [
        'client-ext-id' => $model->id,
    ]
]);
?>
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
            /*
            <div class="pay-form-table">
                <div class="pay-form-total">
                    <div class="pay-form-item pay-form-item_total">
                        <span class="pay-form-item-name">К оплате:</span>&nbsp;&nbsp;&nbsp;<span id="client-ext-unprepayment-price" class="pay-form-item-value"><?= $model->price ?> &#8399;</span> / <span id="client-ext-prepayment-price" class="pay-form-item-value"><?= $model->price ?> &#8399;</span>
                    </div>
                </div>
            </div>
            */ ?>
            <?php /*
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
            */ ?>
            <div class="pay-form-action" style="margin-left: 0;">
                <button type="submit" class="y-button y-button_theme_action y-button_size_l y-button_type_submit" role="button" aria-haspopup="true">
                    <span class="y-button-text">Бронировать</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
