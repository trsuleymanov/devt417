<?php

use app\models\City;
use app\widgets\SelectWidget;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

?>

<?php
$form = ActiveForm::begin([
    'id' => 'order-client-form',
//    'action' => '/site/index',
//    //'action' => "",
//    'enableAjaxValidation' => false,
//    'enableClientValidation' => false,
//    'options' => [
//        'order-id' => $model->id,
//        //'order-temp-identifier' => $model->temp_identifier,
//        //'order-passengers-count' => $order_passengers_count,
//    ],
]);
?>
<div class="px-15px">
    <p class="header-txt-a">ДОБРОЕ УТРО !</p>
    <h1 class="header-txt-b">
        <span class="brown">СДЕЛАЙТЕ&nbsp;ВАШ<br>ЗАКАЗ</span>&nbsp;ОНЛАЙН
    </h1>
    <div class="wall w-md-80">
        <div class="row">
            <div class="col">
                <h3 class="wall-title">Я хочу выехать</h3>
            </div>
            <div class="col-auto">
                <a target="_blank" href="http://417417.ru">
                    <img height="13" src="images/main_page/logo-ln.svg">
                </a>
            </div>
        </div>
        <form id="create-order-form" class="js-form">


            <?php /*
            <select name="ClientExt[city_from_id]" class="input" data-validate="select-text">
                <option disabled selected>Откуда</option>
                <option value="2">из Альметьевска</option>
                <option value="1">из Казани</option>
            </select>

            <select name="ClientExt[city_to_id]" class="input" data-validate="select-text">
                <option disabled selected>Выберите город прибытия</option>
                <option value="1">в Казань</option>
                <option value="2">в Альметьевск</option>
            </select>
            */ ?>



            <?= $form->field($model, 'city_from_id')->dropDownList([0 => '', 2 => 'из Альметьевска', 1 => 'из Казани'])->label('Откуда'); ?>

            <?= $form->field($model, 'city_to_id')->dropDownList([0 => '', 1 => 'в Казань', 2 => 'в Альметьевск'])->label('Выберите город прибытия'); ?>

            <?php
            if($model->data > 0 && !preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/i', $model->data)) {
                $model->data = date("d.m.Y", $model->data);
            }
            echo $form->field($model, 'data', ['errorOptions' => ['style' => 'display:none;']])
                ->widget(kartik\date\DatePicker::classname(), [
                    'type' => kartik\date\DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'class' => ''
                    ],
                    'options' => [
                        'id' => 'data',
                    ]
                ])
                ->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' =>  'dd.mm.yyyy',
                        //'alias' =>  'дд.мм.гггг', // возникают проблемы если использовать русские буквы
                    ],
                    'options' => [
                        'id' => 'data',
                        'start-date' => $model->data,
                        'aria-required' => 'true',
                        'placeholder' => 'Дата поездки'
                    ]
                ])
                ->label(false);
            ?>


            <?php
            echo $form->field($model, 'time', ['options' => ['class' => 'form-group person_info tel md-form'], 'template' => '{input}{label}{error}'])
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
                            'placeholder' => 'Во сколько вас забрать'
                        ]
                    ])->label(false);
            ?>

            <!--
            <input class="input js-dpicker" type="text" name="date" placeholder="Количество пассажиров" data-validate="text">
            -->

            <?= $form->field($model, 'places_count')
                ->textInput([
                    'class' => "input",
                    'placeholder' => "Количество пассажиров",
                ])->label(false) ?>

            <?php /*
            <select id="direction" name="ClientExt[direction]" class="input" data-validate="select-text">
                <option disabled selected>Откуда</option>
                <option value="1">из Альметьевска</option>
                <option value="2">из Казани</option>
            </select>
            <div>
                <label id="select-yandex-point-from" href="">выбрать на карте</label>
                <?php
                // временная правка для последних созданных заказах до выгрузки кода с изменения в яндекс-точках
                if($model->yandex_point_from_id > 0 && empty($model->yandex_point_from_lat) && empty($model->yandex_point_from_long) && empty($model->yandex_point_from_name)) {
                    $yandex_point_from = $model->yandexPointFrom;
                    if($yandex_point_from == null) {
                        $value = '';
                        $initValueText = '';
                    }else {
                        //$value = $model->yandex_point_from_id.'_'.$yandex_point_from->lat.'_'.$yandex_point_from->long.'_'.$yandex_point_from->name;
                        $value = $model->yandex_point_from_id;
                        $initValueText = $yandex_point_from->name;
                    }
                }elseif($model->yandex_point_from_id == 0 && empty($model->yandex_point_from_lat) && empty($model->yandex_point_from_long) && empty($model->yandex_point_from_name)) {
                    $value = '';
                    $initValueText = '';
                }else {
                    // $value = (empty($model->yandex_point_from_id) ? 0 : $model->yandex_point_from_id).'_'.$model->yandex_point_from_lat.'_'.$model->yandex_point_from_long.'_'.$model->yandex_point_from_name;
                    $value = (empty($model->yandex_point_from_id) ? 0 : $model->yandex_point_from_id);
                    $initValueText = $model->yandex_point_from_name;
                }


                echo $form->field($model, 'yandex_point_from_id')->widget(SelectWidget::className(), [
                    'initValueText' => $initValueText,
                    'value' => $value,
                    'options' => [
                        'name' => 'ClientExt[yandex_point_from_id]',
                        'placeholder' => 'Выбрать точку',
                        'id' => 'yandex_point_from',
                        'style' => "font-size: 14px;"
                    ],
                    'ajax' => [
                        'url' => '/yandex-point/ajax-yandex-points?is_from=1&simple_id=1',
                        'data' => new JsExpression('function(params) {
                            return {
                                search: params.search,
                                direction_id: $("#direction").val()
                            };
                        }'),
                    ],
//                    'add_new_value_url' => new JsExpression('function(params) {
//                        // открытие карты...
//                        //var search = $(".sw-outer-block[attribute-name=\"ClientExt[yandex_point_from]\"]").find(".sw-search").val();
//                        //openMapWithPointFrom(search);
//                    }'),
                ])->label(false);
                ?>
            </div>

            <!--
            <input class="input js-dpicker" type="text" name="date" placeholder="Когда" data-validate="text">
            -->

            <?php
            if($model->data > 0 && !preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/i', $model->data)) {
                $model->data = date("d.m.Y", $model->data);
            }
            echo $form->field($model, 'data', ['errorOptions' => ['style' => 'display:none;']])
                ->widget(kartik\date\DatePicker::classname(), [
                    'type' => kartik\date\DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true,
                        'autoclose' => true,
                        'class' => ''
                    ],
                    'options' => [
                        'id' => 'data',
                    ]
                ])
                ->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' =>  'dd.mm.yyyy',
                        //'alias' =>  'дд.мм.гггг', // возникают проблемы если использовать русские буквы
                    ],
                    'options' => [
                        'id' => 'data',
                        'start-date' => $model->data,
                        'aria-required' => 'true',
                        'placeholder' => 'Когда'
                    ]
                ])
                ->label(false);
            ?>

            <?php
//            echo $form->field($model, 'time', ['errorOptions' => ['style' => 'display:none;']])
//                ->widget(\yii\widgets\MaskedInput::classname(), [
//                    'mask' => '99 : 99',
//                    'options' => [
//                        //'placeholder' => 'Я хочу сесть в автобус в...',
//                        'placeholder' => 'Желаемое время выезда'
//                    ],
//                    'clientOptions' => [
//                        'placeholder' => '_'
//                    ]
//                ])
//                ->label(false);


            echo $form->field($model, 'time', ['options' => ['class' => 'form-group person_info tel md-form'], 'template' => '{input}{label}{error}'])
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
                            'placeholder' => 'Желаемое время выезда'
                        ]
                ])->label(false);
            ?>

            <input name="ClientExt[user_id]" type="hidden" value="<?= $model->user_id ?>" />
            <input name="ClientExt[email]" type="hidden" value="<?= $model->email ?>" />
            <?= $form->field($model, 'username')
                ->textInput([
                    'id' => 'username',
                    'class' => "input",
                    'placeholder' => "Имя Фамилия",
                ])->label(false) ?>


            <?= MaskedInput::widget([
                'id' => 'phone',
                'name' => 'ClientExt[phone]',
                'mask' => '+7-999-999-99-99',
                'value' => $model->phone,
                'clientOptions' => [
                    'placeholder' => '*',
                ],
                'options' => [
                    'placeholder' => 'Номер телефона',
                    'class' => "input"
                ]
            ]);
            ?>
            <br />

            <!--
            <input class="input js-dpicker" type="text" name="callme" placeholder="Позвоните мне" data-validate="text">
            -->
            */ ?>

            <div class="row justify-content-center">
                <div class="col-auto">
                    <button class="button" type="submit">Перейти к оформлению</button>
                </div>
            </div>
        </form>
    </div><!-- /.wall -->
</div><!-- /.my-auto -->

<?php ActiveForm::end(); ?>