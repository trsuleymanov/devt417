<?php
namespace app\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;


/**
 * Default controller for the `m-api` module
 */
class UserController extends \yii\rest\ActiveController
{
    public $modelClass = '';
    //public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        $behaviors['authenticator']['except'] = [
            'registration',
            'restorepassword',
            'login',
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['delete'], $actions['index'], $actions['create'], $actions['update']);

        $actions['registration']['class'] = 'app\modules\api\actions\user\RegistrationAction';
        $actions['restorepassword']['class'] = 'app\modules\api\actions\user\RestorePasswordAction';
        $actions['setpassword']['class'] = 'app\modules\api\actions\user\SetPasswordAction';
        $actions['login']['class'] = 'app\modules\api\actions\user\LoginAction';
        $actions['view']['class'] = 'app\modules\api\actions\user\ViewAction';

        return $actions;
    }

    protected function verbs(){
        return [
            'registration' => ['GET', 'POST'],
            'restorepassword' => ['GET', 'POST'],
            'setpassword' => ['GET', 'POST'],
            'login' => ['GET', 'POST'],
            'view' => ['GET', 'POST'],
        ];
    }

}
