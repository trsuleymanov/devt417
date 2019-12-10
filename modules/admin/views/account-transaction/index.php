<?php

use app\helpers\table\PageSizeHelper;
use app\models\AccountTransaction;
use app\models\User;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;


$this->title = 'Транзации по счетам пользователей';
$this->params['breadcrumbs'][] = $this->title;

$pagination = $dataProvider->getPagination();
$pagination->totalCount = $dataProvider->getTotalCount();
?>
<div id="account-transaction-index" class="box box-default" >
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
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'attribute' => 'user_id',
                    'content' => function ($model) {
                        return $model->user->fio;
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'user_id',
                        ['' => 'Все'] + ArrayHelper::map(User::find()->all(), 'id', 'fio'),
                        ['class' => "form-control"]
                    )
                ],
                'money',
                //'operation_type',
                [
                    'attribute' => 'operation_type',
                    'content' => function ($model) {
                        return AccountTransaction::getOperationTypes()[$model->operation_type];
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'operation_type',
                        ['' => 'Все'] + AccountTransaction::getOperationTypes(),
                        ['class' => "form-control"]
                    )
                ],

                [
                    'attribute' => 'created_at',
                    'content' => function ($model) {
                        return date('d.m.Y', $model->created_at);
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
                    'attribute' => 'clientext_id',
                    'content' => function ($model) {
                        return date('d.m.Y', $model->clientext_id);
                    },
                ],

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]);

        ?>
    </div>
</div>

