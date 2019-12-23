<?php

namespace app\modules\api\actions\clientext;

use app\models\ClientExt;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class CancelAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Отмена заказа
     * @throws ForbiddenHttpException
     */
    public function run()
    {
        $clientext_id = intval(Yii::$app->getRequest()->getBodyParam('clientext_id'));
        $client_ext = ClientExt::find()->where(['id' => $clientext_id])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

//        if($client_ext->paid_summ > 0) {
//            throw new ForbiddenHttpException('Нельзя отменить заказ по которому была произведена оплата');
//        }

        $client_ext->setStatus('canceled_by_client');

        return; // 200
    }
}
