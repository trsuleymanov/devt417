<?php

namespace app\modules\api\actions\push;

use Yii;
use app\models\Push;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;
use app\commands\MainServerController;


class RejectAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Нажатие "Не согласен" при получении пуша
     */
    public function run()
    {
        $push_id = intval(Yii::$app->getRequest()->getBodyParam('push_id'));
        $push = Push::find()->where(['id' => $push_id])->one();
        if($push == null) {
            throw new ForbiddenHttpException('Пуш не найден');
        }

        $push->setField('reject_time_at', time());
        $push->setField('sync_answer_time_at', NULL);

        MainServerController::actionSetRejectPush($push->id);

        return; // 200
    }
}