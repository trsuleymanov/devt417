<?php
namespace app\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;



class PushController extends \yii\rest\ActiveController
{
    public $modelClass = '';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        $behaviors['authenticator']['except'] = [
            'accept', // сложно формировать в приложении токен доступа
            'reject', // сложно формировать в приложении токен доступа
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['delete'], $actions['index'], $actions['create'], $actions['update']);

        $actions['accept']['class'] = 'app\modules\api\actions\push\AcceptAction';
        $actions['reject']['class'] = 'app\modules\api\actions\push\RejectAction';

        return $actions;
    }

    protected function verbs(){
        return [
            'accept' => ['GET', 'POST'],
            'reject' => ['GET', 'POST'],
        ];
    }

}
