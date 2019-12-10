<?php

use app\models\YandexPayment;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use app\helpers\table\PageSizeHelper;


$this->title = 'Платежи/Возвраты за заказ через яндекс-платформу';
$this->params['breadcrumbs'][] = $this->title;

$pagination = $dataProvider->getPagination();
$pagination->totalCount = $dataProvider->getTotalCount();
?>
<div id="yandex-payment-page" class="box box-default" >
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
            'options' => ['class' => 'grid-view table-responsive'],
            'tableOptions' => [
                'class' => 'table table-condensed table-bordered table-hover'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'type',
                    'content' => function ($model) {
                        return (isset(YandexPayment::getTypes()[$model->type]) ? YandexPayment::getTypes()[$model->type] : '');
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'type',
                        ['' => 'Все',] + YandexPayment::getTypes(),
                        ['class' => "form-control"]
                    )
                ],
                [
                    'attribute' => 'source_type',
                    'content' => function ($model) {
                        return (isset(YandexPayment::getSourceTypes()[$model->source_type]) ? YandexPayment::getSourceTypes()[$model->source_type] : '');
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'source_type',
                        ['' => 'Все',] + YandexPayment::getSourceTypes(),
                        ['class' => "form-control"]
                    )
                ],
//                [
//                    'attribute' => 'yandex_payment_id',
//                    'label' => 'id платежа/возврата в яндексе',
//                    'content' => function ($model) {
//                        return $model->yandex_payment_id;
//                    },
//                ],
                //'source_yandex_payment_id',
                //'source_payment_id',
                [
                    'label' => 'id Заявки',
                    'attribute' => 'client_ext_id',
                ],
                [
                    'attribute' => 'value',
                    'content' => function ($model) {
                        return $model->value;
                    },
                ],
                [
                    'attribute' => 'currency',
                    'content' => function ($model) {
                        return $model->currency;
                    },
                ],
                [
                    'label' => 'Чем оплачено',
                    'attribute' => 'payment_type',
                    'content' => function ($model) {
                        return $model->payment_type;
                    },
                ],
                [
                    'attribute' => 'status',
                    'content' => function ($model) {
                        return (isset(YandexPayment::getStatuses()[$model->status]) ? YandexPayment::getStatuses()[$model->status] : '');
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        ['' => 'Все',] + YandexPayment::getStatuses(),
                        ['class' => "form-control"]
                    )
                ],
                //'created_at',
                [
                    'attribute' => 'pending_at',
                    'label' => 'Начало оплаты',
                    'content' => function ($model) {
                        return (!empty($model->pending_at) ? date('d.m.Y H:i:s', $model->pending_at) : '');
                    },
                ],
                [
                    'attribute' => 'waiting_for_capture_at',
                    'label' => 'Переход в статус "Ожидает подтверждения"',
                    'content' => function ($model) {
                        return (!empty($model->waiting_for_capture_at) ? date('d.m.Y H:i:s', $model->waiting_for_capture_at) : '');
                    },
                ],
                [
                    'attribute' => 'succeeded_at',
                    'label' => 'Успешно завершен платеж',
                    'content' => function ($model) {
                        return (!empty($model->succeeded_at) ? date('d.m.Y H:i:s', $model->succeeded_at) : '');
                    },
                ],
                [
                    'attribute' => 'canceled_at',
                    'label' => 'Отменен платеж',
                    'content' => function ($model) {
                        return (!empty($model->canceled_at) ? date('d.m.Y H:i:s', $model->canceled_at) : '');
                    },
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
