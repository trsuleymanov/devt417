<?php

use app\helpers\table\PageSizeHelper;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;


$this->title = 'Не окончившие регистрацию пользователи';
$this->params['breadcrumbs'][] = $this->title;

$pagination = $dataProvider->getPagination();
$pagination->totalCount = $dataProvider->getTotalCount();
?>
<div id="current-reg-page" class="box box-default" >
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
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'email:email',
                'fio',
                'mobile_phone',
                'password',
                'registration_code',
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

                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php
        /*
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            //'layout' => '{items}<span class="pull-right text-muted">{summary}</span>',
            'layout'=>"{summary}\n{items}",
            'options' => ['class' => 'grid-view table-responsive'],
            'tableOptions' => [
                'class' => 'table table-condensed table-bordered table-hover'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
//                [
//                    'attribute' => 'last_login_date',
//                    'content' => function ($model) {
//                        return (empty($model->last_login_date) ? '' : date('d.m.Y', $model->last_login_date));
//                    },
//                    'filter' => DatePicker::widget([
//                        'model' => $searchModel,
//                        'attribute' => 'last_login_date',
//                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
//                        'pluginOptions' => [
//                            'autoclose' => true,
//                            'format' => 'dd.mm.yyyy',
//                        ]
//                    ])
//                ],
//                [
//                    'attribute' => 'last_login_date',
//                    'content' => function ($model) {
//                        return (empty($model->last_login_date) ? '' : date('d.m.Y H:i', $model->last_login_date));
//                    },
//                    'filter' => DateTimePicker::widget([
//                        'model' => $searchModel,
//                        'attribute' => 'last_login_date',
//                        'convertFormat' => true,
//                        'pluginOptions' => [
//                            'format' => 'dd.MM.yyyy hh:i',
//                            'autoclose' => true,
//                        ],
//                    ]),
//                ],
                'fio',
//                'auth_key',
//                'password_hash',
//                'firstname',
//                'lastname',
                'email:email',
//                'city',
//                'address',
                'phone',
                [
                    'attribute' => 'code_for_friends',
                    'content' => function ($model) {
                        return !empty($model->code_for_friends) ? $model->code_for_friends : '';
                    }
                ],
                [
                    'attribute' => 'friend_code',
                    'content' => function ($model) {
                        return !empty($model->friend_code) ? $model->friend_code : '';
                    }
                ],
                'account',
//                [
//                    'attribute' => 'role_id',
//                    'content' => function ($model) {
//                        if(empty($model->role_id)) {
//                            return '';
//                        }else {
//                            return $model->userRole->name;
//                        }
//                    },
//                    'filter' => Html::activeDropDownList(
//                        $searchModel,
//                        'role_id',
//                        ['' => 'Все'] + ArrayHelper::map(UserRole::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
//                        ['class' => "form-control"]
//                    )
//                ],
//                'last_ip',
//                'attempt_count',
//                'attempt_date',
                [
                    'attribute' => 'created_at',
                    'content' => function ($model) {
                        return (empty($model->created_at) ? '' : date('d.m.Y', $model->created_at));
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ])
                ],
                [
                    'attribute' => 'updated_at',
                    'content' => function ($model) {
                        return (empty($model->updated_at) ? '' : date('d.m.Y', $model->updated_at));
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'updated_at',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ])
                ],
                [
                    'attribute' => 'blocked',
                    'content' => function ($model) {
                        return ($model->blocked == 1 ? 'Заблокирован' : '');
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'blocked',
                        ['' => 'Все', '0' => 'Нет', '1' => 'Да'],
                        ['class' => "form-control"]
                    )
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'options' => ['style' => 'width: 50px;']
                ],
            ],
        ]); */ ?>
    </div>
</div>

