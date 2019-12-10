<?php
namespace app\modules\serverapi\controllers;

use Yii;
use app\modules\serverapi\models\HttpSecretKeyAuth;


class UserController extends \yii\rest\ActiveController
{
    public $modelClass = '';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpSecretKeyAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['get-users']['class'] = 'app\modules\serverapi\actions\user\GetUsersAction';
        $actions['set-sync-to-users']['class'] = 'app\modules\serverapi\actions\user\SetSyncToUsersAction';

        return $actions;
    }

}
