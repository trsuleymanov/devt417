<?php
namespace app\modules\serverapi\controllers;

use Yii;
use app\modules\serverapi\models\HttpSecretKeyAuth;


class PushController extends \yii\rest\ActiveController
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

        $actions['send']['class'] = 'app\modules\serverapi\actions\push\SendAction';

        return $actions;
    }
}
