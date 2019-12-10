<?php

namespace app\modules\api\actions\user;

use app\models\CurrentReg;
use app\models\User;
use Yii;
use yii\web\ForbiddenHttpException;


class RegistrationAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Регистрация пользователя
     */
    public function run()
    {
        $user = User::find()->where(['email' => Yii::$app->getRequest()->getBodyParam('email')])->one();
        if($user != null) {
            throw new ForbiddenHttpException('Пользователь с такой почтой уже существует');
        }
        $user = User::find()->where(['phone' => Yii::$app->getRequest()->getBodyParam('mobile_phone')])->one();
        if($user != null) {
            throw new ForbiddenHttpException('Пользователь с таким телефоном уже существует');
        }

        $current_reg = CurrentReg::find()
            ->where(['email' => Yii::$app->getRequest()->getBodyParam('email')])
            ->orWhere(['mobile_phone' => Yii::$app->getRequest()->getBodyParam('mobile_phone')])
            ->one();
        if($current_reg == null) {
            $current_reg = new CurrentReg();
        }

        if (
            $current_reg->load(Yii::$app->getRequest()->getBodyParams(), '')
            && $current_reg->validate()
            && $current_reg->generateRegistrationCode()
            && $current_reg->sendRegistrationCode()
            && $current_reg->save()
        ) {
            return; // + stasus 200 by default
        }else {
            return $current_reg;
        }
    }
}
