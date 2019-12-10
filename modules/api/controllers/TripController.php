<?php
namespace app\modules\api\controllers;

use yii\filters\auth\HttpBearerAuth;


class TripController extends \yii\rest\ActiveController
{
    public $modelClass = '';

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

        $actions['index']['class'] = 'app\modules\api\actions\trip\IndexAction';

        return $actions;
    }

    protected function verbs(){
        return [
            'index' => ['GET', 'POST'],
        ];
    }

}