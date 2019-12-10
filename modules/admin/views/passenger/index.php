<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PassengerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Passengers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="passenger-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Passenger', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'client_id',
            'fio',
            'gender',
            //'date_of_birth',
            //'document_type',
            //'citizenship',
            //'series_number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
