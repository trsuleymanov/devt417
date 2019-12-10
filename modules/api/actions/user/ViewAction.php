<?php

namespace app\modules\api\actions\user;

use Yii;
use app\models\User;
use yii\web\ForbiddenHttpException;


class ViewAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Отображение
     */
    public function run()
    {
        $user = Yii::$app->user->identity;

        if(empty($user->code_for_friends)) {
            $user->code_for_friends = $user::generateCodeForFriends();
            $user->setField('code_for_friends', $user->code_for_friends);
        }

        return $user;
    }
}
