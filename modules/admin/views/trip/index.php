<?php

use app\helpers\table\PageSizeHelper;
use app\models\Direction;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;


$this->title = 'Рейсы';
$this->params['breadcrumbs'][] = $this->title;

$pagination = $dataProvider->getPagination();
$pagination->totalCount = $dataProvider->getTotalCount();
?>
<div id="trip-index" class="box box-default" >
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

                //'id',
                'name',
                [
                    'attribute' => 'date',
                    'content' => function ($model) {
                        return date('d.m.Y', $model->date);
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]),
                ],
                //'direction_id',
                [
                    'attribute' => 'direction_id',
                    'content' => function ($model) {
                        return $model->direction_id > 0 ? $model->direction->sh_name : '';
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'direction_id',
                        ['' => 'Все'] + ArrayHelper::map(Direction::find()->all(), 'id', 'sh_name'),
                        ['class' => "form-control"]
                    )
                ],
                [
                    'attribute' => 'commercial',
                    'content' => function ($model) {
                        return $model->commercial == 1 ? 'да' : 'нет';
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'commercial',
                        ['' => 'Все', 0 => 'Нет', 1 => 'Да'],
                        ['class' => "form-control"]
                    )
                ],
                'start_time',
                'mid_time',
                'end_time',
                [
                    'label' => 'Дата синхронизации с основным сервером',
                    'attribute' => 'created_updated_at',
                    'content' => function ($model) {
                        return date('d.m.Y H:i', $model->created_updated_at);
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_updated_at',
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