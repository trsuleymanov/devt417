<?php


namespace app\commands;

use app\models\User;
use yii\console\Controller;


class TestController extends Controller
{
    /*
     * Команда:  php yii test/set-password
     */
    public function actionSetPassword() {

        $user = User::findOne(1);
        echo "user_id=".$user->id." username=".$user->fio."\n";
        $user->setPassword('123456');

        if($user->save(false)) {
            echo "ok \n";
        }else {
            return $user->getErrors();
        }
    }
}
