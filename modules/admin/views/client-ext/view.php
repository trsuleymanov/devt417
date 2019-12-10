<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClientExt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Client Exts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-ext-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'main_server_order_id',
            'status',
            'status_setting_time:datetime',
            'user_id',
            'direction',
            'data',
            'time',
            'time_confirm:datetime',
            'trip_name',
            //'street_from',
            //'point_from',
            'yandex_point_from_id',
            'yandex_point_from_name',
            'yandex_point_from_lat',
            'yandex_point_from_long',
            //'street_to',
            //'point_to',
            'yandex_point_to_id',
            'yandex_point_to_name',
            'yandex_point_to_lat',
            'yandex_point_to_long',
            'places_count',
            'price',
            'discount',
            'transport_car_reg',
            'transport_model',
            'transport_color',
            'friend_code',
            'created_at',
            'updated_at',
            'sync_date',
        ],
    ]) ?>

</div>
