<?php
namespace app\modules\serverapi\controllers;

use Yii;
//use yii\filters\auth\HttpBearerAuth;
use app\modules\serverapi\models\HttpSecretKeyAuth;


class ClientextController extends \yii\rest\ActiveController
{
    public $modelClass = '';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            //'class' => HttpBearerAuth::className(),
            'class' => HttpSecretKeyAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['get-not-sync-clientexts']['class'] = 'app\modules\serverapi\actions\clientext\GetNotSyncClientextsAction';
        $actions['set-sync-to-clientexts']['class'] = 'app\modules\serverapi\actions\clientext\SetSyncToClientextsAction';

        return $actions;
    }

//    protected function verbs(){
//        return [
//            'test' => ['GET', 'POST'],
//        ];
//    }

}
