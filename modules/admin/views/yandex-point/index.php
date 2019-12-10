<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\YandexPointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Yandex Points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yandex-point-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Yandex Point', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'city_id',
            'lat',
            'long',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
