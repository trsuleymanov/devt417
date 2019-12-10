<?php
namespace app\modules\serverapi\controllers;

use Yii;
use app\modules\serverapi\models\HttpSecretKeyAuth;


class RequestController extends \yii\rest\ActiveController
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

        $actions['get-not-sync-requests']['class'] = 'app\modules\serverapi\actions\request\GetNotSyncRequestsAction';
        $actions['set-sync-to-requests']['class'] = 'app\modules\serverapi\actions\request\SetSyncToRequestsAction';

        return $actions;
    }

//    protected function verbs(){
//        return [
//            'test' => ['GET', 'POST'],
//        ];
//    }

}
