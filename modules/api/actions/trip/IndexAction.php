<?php

namespace app\modules\api\actions\trip;

use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;
use app\models\Trip;


class IndexAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Список рейсов
     */
    public function run()
    {
        // поле даты пока не используется в рейсах
        //$data = Yii::$app->getRequest()->getBodyParam('data');
        $direction = intval(Yii::$app->getRequest()->getBodyParam('direction'));
        if(!in_array($direction, [1, 2])) {
            throw new ForbiddenHttpException('Выберите направление');
        }

        $date = Yii::$app->getRequest()->getBodyParam('date');
        $mktime_date = strtotime($date);

        $trips = Trip::find()
            ->select('*, CAST(mid_time AS UNSIGNED) AS int_mid_time')
            ->where(['direction_id' => $direction])
            ->andWhere(['date' => $mktime_date])
            ->orderBy(['int_mid_time' => SORT_ASC])
            //->orderBy('name DESC')
            ->all();

        return $trips;
    }
}