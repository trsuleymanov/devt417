<?php

namespace app\modules\api\actions\clientext;

use app\models\ClientExt;
use app\models\Trip;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class CreateAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Создание заказа
     * @throws ErrorException
     */
    public function run()
    {
        $clientExt = new ClientExt();
        $clientExt->load(Yii::$app->getRequest()->getBodyParams(), '');// direction, data, time

        if (!$clientExt->validate()) {
            return $clientExt;
        }

        if(empty($clientExt->trip_id) && !empty($clientExt->time)) {
            $trip = Trip::find()->where(['date' => $clientExt->data])->andWhere(['mid_time' => $clientExt->time])->one();
            if($trip != null) {
                $clientExt->trip_id = $trip->id;
            }
        }

        $clientExt->source_type = 'application';
        $clientExt->user_id = Yii::$app->user->id;
        $clientExt->status = 'created';

        // эту функцию расчета цены нужно переписать, так как теперь цена зависит от предоплаченности и от точки отправления
        // $clientExt->price = $clientExt->getCalculatePrice();
        if(!$clientExt->save()) {
            throw new ErrorException('Не удалось сохранить заказ');
        }

        return; // 200
    }
}
