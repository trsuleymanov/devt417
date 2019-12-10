<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\City;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->registerJsFile('js/admin/pages.js', ['depends' => 'app\assets\AdminAsset']);
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU', ['depends' => 'app\assets\AdminAsset']);
?>

<?php $form = ActiveForm::begin([
    'id' => 'city-form',
    'options' => [
        'city-id' => $model->id
    ]
]); ?>

<div class="box box-solid">

    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="fa fa-address-book-o"></i>
            Основная информация
        </h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="box-body">

        <br />
        <div class="row">
            <div class="col-sm-4 form-group form-group-sm">
                <?= $form->field($model, 'extended_external_use')->checkbox() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 form-group form-group-sm">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2 form-group form-group-sm">
                <?= $form->field($model, 'center_lat')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-2 form-group form-group-sm">
                <?= $form->field($model, 'center_long')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 form-group form-group-sm">
                <?= $form->field($model, 'map_scale')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3 form-group form-group-sm">
                <?= $form->field($model, 'search_scale')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3 form-group form-group-sm">
                <?= $form->field($model, 'point_focusing_scale')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-3 form-group form-group-sm">
                <?= $form->field($model, 'all_points_show_scale')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 form-group form-group-sm">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить и выйти', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
if(!$model->isNewRecord)
{ ?>
    <div id="yandex-point-list" class="box box-solid">

        <div class="box-header scroller with-border">
            <h3 class="box-title">
                <i class="fa fa-address-book-o"></i>
                Яндекс точки
            </h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>


        <div class="box-body box-table">

            <?php
            /*
            // создание яндекс-точек на клиентском сервере отключаю
            echo Html::a('<i class="fa fa-plus"></i> Добавить опорную точку', Url::to(['/admin/yandex-point/ajax-create', 'city_id' => $model->id]), ['id'=>'add-yandex-point', 'class' => 'btn btn-success']) ?>
            <br /><br />
            <?php */ ?>

            <?php Pjax::begin([
                'id' => 'yandex-points-grid'
            ]) ?>

            <?= GridView::widget([
                'dataProvider' => $yandexPointDataProvider,
                'filterModel' => $yandexPointSearchModel,
                'options' => ['class' => 'grid-view table-responsive'],
                'tableOptions' => [
                    'class' => 'table table-condensed table-bordered table-hover'
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                        'attribute' => 'active',
                        'content' => function($model) {
                            return ($model->active == true ? 'да' : 'нет');
                        },
                        'filter' => Html::activeDropDownList(
                            $yandexPointSearchModel,
                            'active',
                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                            ['class' => "form-control"]
                        )
                    ],
                    'name',
                    [
                        'attribute' => 'city_id',
                        'content' => function($model) {
                            return $model->city->name;
                        },
                        'filter' => Html::activeDropDownList(
                            $yandexPointSearchModel,
                            'city_id',
                            ['' => 'Все'] + ArrayHelper::map(City::find()->all(), 'id', 'name'),
                            ['class' => "form-control"]
                        )
                    ],
                    'lat',
                    'long',
                    [
                        'attribute' => 'super_tariff_used',
                        'content' => function ($model) {
                            return ($model->super_tariff_used == true ? 'Да' : 'нет');
                        },
                        'filter' => Html::activeDropDownList(
                            $yandexPointSearchModel,
                            'super_tariff_used',
                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                            ['class' => "form-control"]
                        )
                    ],

                    [
                        'attribute' => 'popular_departure_point',
                        'content' => function ($model) {
                            return ($model->popular_departure_point == true ? 'Да' : 'нет');
                        },
                        'filter' => Html::activeDropDownList(
                            $yandexPointSearchModel,
                            'popular_departure_point',
                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                            ['class' => "form-control"]
                        )
                    ],

                    [
                        'attribute' => 'popular_arrival_point',
                        'content' => function ($model) {
                            return ($model->popular_arrival_point == true ? 'Да' : 'нет');
                        },
                        'filter' => Html::activeDropDownList(
                            $yandexPointSearchModel,
                            'popular_arrival_point',
                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                            ['class' => "form-control"]
                        )
                    ],

//                    [
//                        'attribute' => 'point_of_arrival',
//                        'content' => function($model) {
//                            return $model->point_of_arrival == 1 ? 'Да' : '';
//                        },
//                        'filter' => Html::activeDropDownList(
//                            $yandexPointSearchModel,
//                            'point_of_arrival',
//                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
//                            ['class' => "form-control"]
//                        )
//                    ],
//                    [
//                        'attribute' => 'critical_point',
//                        'content' => function($model) {
//                            return $model->critical_point == 1 ? 'Да' : '';
//                        },
//                        'filter' => Html::activeDropDownList(
//                            $yandexPointSearchModel,
//                            'critical_point',
//                            ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
//                            ['class' => "form-control"]
//                        )
//                    ],
//                    [
//                        'attribute' => 'alias',
//                        'label' => 'Алиас'
//                    ],
//                    [
//                        'attribute' => 'created_at',
//                        'content' => function ($model) {
//                            return (!empty($model->created_at) ? date('d.m.Y', $model->created_at) : '');
//                        },
//                        'filter' => DatePicker::widget([
//                            'model' => $yandexPointSearchModel,
//                            'attribute' => 'created_at',
//                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
//                            'pluginOptions' => [
//                                'autoclose' => true,
//                                'format' => 'dd.mm.yyyy',
//                            ]
//                        ]),
//                    ],
//                    [
//                        'attribute' => 'creator_id',
//                        'content' => function ($model) {
//                            if(!empty($model->creator_id)) {
//                                return $model->creator->fio;
//                            }else {
//                                return '';
//                            }
//                        }
//                    ],
//                    [
//                        'attribute' => 'updated_at',
//                        'content' => function ($model) {
//                            return (!empty($model->updated_at) ? date('d.m.Y', $model->updated_at) : '');
//                        },
//                        'filter' => DatePicker::widget([
//                            'model' => $yandexPointSearchModel,
//                            'attribute' => 'updated_at',
//                            'type' => DatePicker::TYPE_COMPONENT_PREPEND,
//                            'pluginOptions' => [
//                                'autoclose' => true,
//                                'format' => 'dd.mm.yyyy',
//                            ]
//                        ])
//                    ],
//                    [
//                        'attribute' => 'updater_id',
//                        'content' => function ($model) {
//                            if(!empty($model->updater_id)) {
//                                return $model->updater->fio;
//                            }else {
//                                return '';
//                            }
//                        }
//                    ],

// редактирование/удаление яндекс-точек на клиентском сервере отключаю
//                    [
//                        'class' => 'yii\grid\ActionColumn',
//                        'template' => '{update} {delete}',
//                        'options' => ['style' => 'width: 50px;'],
//                        'buttons' => [
//                            'update' => function ($url, $model) {
//                                return Html::a(
//                                    '<span class="glyphicon glyphicon-pencil"></span>',
//                                    '#',
//                                    [
//                                        'aria-label' => 'Редактировать',
//                                        'class' => "edit-yandex-point",
//                                        'yandex-point-id' => $model->id
//                                    ]
//                                );
//                            },
//                            'delete' => function ($url, $model) {
//                                return Html::a(
//                                    '<span class="glyphicon glyphicon-trash"></span>',
//                                    Url::to(['/admin/yandex-point/ajax-delete', 'id' => $model->id]),
//                                    [
//                                        'aria-label' => 'Удалить',
//                                        'class' => "delete-yandex-point"
//                                    ]
//                                );
//                            },
//                        ],
//                    ],
                ],
            ]); ?>
            <?php Pjax::end() ?>
        </div>
    </div>

<?php } ?>

