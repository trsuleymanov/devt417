<?php

namespace app\modules\api\actions\user;

use app\models\CurrentReg;
use app\models\User;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class RestorePasswordAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Восстановление пароля
     */
    public function run()
    {
        $user = User::find()->where(['email' => Yii::$app->getRequest()->getBodyParam('email')])->one();
        if($user == null) {
            throw new ForbiddenHttpException('Пользователя с такой почтой не существует');
        }

        if($user->generateRestoreCode() && $user->save(false) && $user->sendRestoreCode()) {
            return; // + stasus 200 by default
        }else {
            throw new ErrorException('Не удалось сгенерировать и отправить код восстановления доступа');
        }
    }
}
