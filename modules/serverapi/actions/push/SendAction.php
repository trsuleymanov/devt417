<?php

namespace app\modules\serverapi\actions\push;

use app\models\ClientExt;
use app\models\Push;
use app\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;


class SendAction extends \yii\rest\Action
{
    public $modelClass = '';

    //public static $firebase_server_key = 'AAAAcz-CVIY:APA91bFj_q-GgIpqvE2HrUSieZxvgxTc8ngVy-SQpsOhvckjIGesfph1M_RU1KTp9mE8hVjgIgVfFA7ZhQuaNF8Ci6THZBx3CdEC4WizGkQ-5JKwpz6O_vyFPhDG59kzkb01Z4BDZz0V';


    /**
     * Пересылка/формирование пуша (клиенский сервер создает/перенапляет пуш в телефон через google firebase)
     *
     * запрос с кодом доступа:
     * curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" -XPOST -H "Content-Type:application/json" -d "{\"phone\": \"+7-966-112-8006\", \"title\":\"qqq\",\"text\":\"qqq2\",\"clientext_id\":\"15\"}" http://tobus-client.ru/serverapi/user/send-push
     *
     * curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" -XPOST -H "Content-Type:application/json" -d "{\"phone\": \"+7-966-112-8006\", \"title\":\"qqq\",\"text\":\"qqq2\",\"clientext_id\":\"2\"}" http://developer.almobus.ru/serverapi/user/send-push
     * curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" -XPOST -H "Content-Type:application/json" -d "{\"phone\": \"+7-966-112-8006\", \"title\":\"qqq\",\"text\":\"qqq2\"}" http://developer.almobus.ru/serverapi/user/send-push
     */
    public function run()
    {
        $phone = Yii::$app->getRequest()->getBodyParam('phone');
        $title = Yii::$app->getRequest()->getBodyParam('title');
        $text = Yii::$app->getRequest()->getBodyParam('text');
        $send_event = Yii::$app->getRequest()->getBodyParam('send_event');
        $client_ext_id = Yii::$app->getRequest()->getBodyParam('client_ext_id');

        $user = User::find()->where(['phone' => $phone])->one();
        if($user == null) {
            throw new ForbiddenHttpException('Пользователь не найден');
        }

        if(empty($user->push_token)) {
            throw new ForbiddenHttpException('У пользователя не установлен токен для отправки пуша');
        }

        if(!empty($clientext_id)) {
            $clientext = ClientExt::find()->where(['id' => $clientext_id])->one();
            if($clientext == null) {
                throw new ForbiddenHttpException('Заявка не найдена');
            }
        }

        if(!in_array($send_event, ['with_sync_clientext', 'immediately'])) {
            throw new ForbiddenHttpException('Неизвестное событие send_event');
        }


        $push = new Push();
        $push->created_at = time();
        $push->title = $title;
        $push->text = $text;
        $push->recipient_user_id = $user->id;
        $push->send_event = $send_event;
        $push->client_ext_id = $client_ext_id;
        if(!$push->save(false)) {
            throw new ForbiddenHttpException('Не удалось сохранить пуш');
        }

        //if($send_event == 'immediately') {
            $push->send();
        //}


        return;
    }
}