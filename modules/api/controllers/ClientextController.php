<?php
namespace app\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;


class ClientextController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\ClientExt';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['delete'], $actions['index'], $actions['create'], $actions['update']);

        $actions['create']['class'] = 'app\modules\api\actions\clientext\CreateAction';
        $actions['index']['class'] = 'app\modules\api\actions\clientext\IndexAction';
        $actions['cancel']['class'] = 'app\modules\api\actions\clientext\CancelAction';
        $actions['set-payment']['class'] = 'app\modules\api\actions\clientext\SetPaymentAction';

        return $actions;
    }

    protected function verbs(){
        return [
            'create' => ['GET', 'POST'],
            'index' => ['GET', 'POST'],
            'cancel' => ['GET', 'POST'],
            'set-payment' => ['GET', 'POST'],
        ];
    }

}
