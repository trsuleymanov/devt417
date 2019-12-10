<?php

namespace app\modules\api\actions\user;

use app\models\CurrentReg;
use app\models\User;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class SetPasswordAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Установка нового пароля
     */
    public function run()
    {
        $user = Yii::$app->user->identity;

        $user->scenario = 'set_password';
        $user->password = Yii::$app->getRequest()->getBodyParam('new_password');
        if($user->validate()) {
            $user->setPassword($user->password);
            if(!$user->save(false)) {
                throw new ErrorException('Не удалось сохранить пользователя');
            }
        }else {
            return $user;
        }

        return;
    }
}
