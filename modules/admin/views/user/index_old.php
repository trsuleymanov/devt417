<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'last_login_date',
            'auth_key',
            'password_hash',
            'token',
            //'email:email',
            //'fio',
            //'phone',
            //'last_ip',
            //'attempt_count',
            //'attempt_date',
            //'confirmed',
            //'restore_code',
            //'code_for_friends',
            //'friend_code',
            //'account',
            //'created_at',
            //'updated_at',
            //'blocked',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
