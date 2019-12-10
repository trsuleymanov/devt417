<?php

use app\helpers\table\PageSizeHelper;
use app\models\ClientExt;
use app\models\Direction;
use app\models\User;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;


$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;

$pagination = $dataProvider->getPagination();
$pagination->totalCount = $dataProvider->getTotalCount();
?>
<div id="client-ext-index" class="box box-default" >
    <div class="box-header scroller with-border">
        <div class="pull-left">

        </div>
        <div class="pull-left">
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'options' => ['class' => 'pagination pagination-sm']
            ]); ?>
        </div>
        <?= (new PageSizeHelper([20, 50, 100, 200, 500]))->getButtons() ?>
    </div>
    <div></div>

    <div class="box-body box-table">
        <?php

        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout'=>"{summary}\n{items}",
            'options' => ['class' => 'grid-view table-responsive'],
            'tableOptions' => [
                'class' => 'table table-condensed table-bordered table-hover'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'main_server_order_id',
                    'content' => function ($model) {
                        return $model->main_server_order_id > 0 ? $model->main_server_order_id : '';
                    },
                ],
                [
                    'attribute' => 'status',
                    'content' => function ($model) {
                        return $model->status;
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        ['' => 'Все', ] + ClientExt::getStatusesRu(),
                        ['class' => "form-control"]
                    )
                ],
//                [
//                    'attribute' => 'status_setting_time',
//                    'content' => function ($model) {
//                        return $model->status_setting_time > 0 ? date('d.m.Y h:i', $model->status_setting_time) : '';
//                    },
//                    'filter' => DatePicker::widget([
//                        'model' => $searchModel,
//                        'attribute' => 'status_setting_time',
//                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
//                        'pluginOptions' => [
//                            'autoclose' => true,
//                            'format' => 'dd.mm.yyyy',
//                        ]
//                    ]),
//                ],
                //'user_id',
                [
                    'attribute' => 'user_id',
                    'content' => function ($model) {
                        //return ($model->user != null ? $model->user->fio : '');
                        return $model->fio;
                    },
//                    'filter' => Html::activeDropDownList(
//                        $searchModel,
//                        'user_id',
//                        ['' => 'Все', ] + ArrayHelper::map(User::find()->all(), 'id', 'fio'),
//                        ['class' => "form-control"]
//                    )
                    'filter' => false,
                ],
                [
                    'attribute' => 'direction_id',
                    'content' => function ($model) {
                        return $model->direction_id;
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'direction_id',
                        ['' => 'Все', ] + Direction::getDirections(),
                        ['class' => "form-control"]
                    )
                ],
                [
                    'attribute' => 'data',
                    'content' => function ($model) {
                        return $model->data;
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'data',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                'time',
                [
                    'attribute' => 'time_confirm',
                    'content' => function ($model) {
                        return $model->time_confirm > 0 ? date("d.m.Y H:i", $model->time_confirm) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'time_confirm',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                [
                    'attribute' => 'trip_name',
                    'content' => function ($model) {
                        return !empty($model->trip_name) ? $model->trip_name : '';
                    },
                ],
                //'street_from',
                //'point_from',
                //'yandex_point_from_id',
                'yandex_point_from_name',
                //'yandex_point_from_lat',
                //'yandex_point_from_long',
                //'street_to',
                //'point_to',
                //'yandex_point_to_id',
                'yandex_point_to_name',
                //'yandex_point_to_lat',
                //'yandex_point_to_long',
                'places_count',
                'price',
                'paid_summ',
                'discount',
                [
                    'attribute' => 'transport_car_reg',
                    'content' => function ($model) {
                        return !empty($model->transport_car_reg) ? $model->transport_car_reg : '';
                    },
                ],
                [
                    'attribute' => 'transport_model',
                    'content' => function ($model) {
                        return !empty($model->transport_model) ? $model->transport_model : '';
                    },
                ],
                [
                    'attribute' => 'transport_color',
                    'content' => function ($model) {
                        return !empty($model->transport_color) ? $model->transport_color : '';
                    },
                ],
                [
                    'attribute' => 'friend_code',
                    'content' => function ($model) {
                        return !empty($model->friend_code) ? $model->friend_code : '';
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'content' => function ($model) {
                        return $model->created_at > 0 ? date("d.m.Y H:i", $model->created_at) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                [
                    'attribute' => 'updated_at',
                    'content' => function ($model) {
                        return $model->updated_at > 0 ? date("d.m.Y H:i", $model->updated_at) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'updated_at',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                [
                    'label' => 'Дата синхронизации с основным сервером',
                    'attribute' => 'sync_date',
                    'content' => function ($model) {
                        return $model->sync_date > 0 ? date("d.m.Y H:i", $model->sync_date) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'sync_date',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]);

        ?>
    </div>
</div>
