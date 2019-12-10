<?php

namespace app\modules\api\actions\push;

use Yii;
use app\models\Push;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;
use app\commands\MainServerController;


class AcceptAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Нажатие "Согласен" при получении пуша
     */
    public function run()
    {
        $push_id = intval(Yii::$app->getRequest()->getBodyParam('push_id'));
        $push = Push::find()->where(['id' => $push_id])->one();
        if($push == null) {
            throw new ForbiddenHttpException('Пуш не найден');
        }

        $push->setField('confirm_time_at', time());
        $push->setField('sync_answer_time_at', NULL);

        MainServerController::actionSetAcceptPush($push->id);

        return; // 200
    }
}
