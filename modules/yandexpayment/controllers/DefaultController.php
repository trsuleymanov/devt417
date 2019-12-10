<?php
namespace app\modules\yandexpayment\controllers;

use Yii;
use yii\base\ErrorException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use YandexCheckout\Client;
use yii\filters\VerbFilter;

/**
 * Сюда приходят сообщения от яндекс-оплаты после оплаты на стороне яндекса
 */
class DefaultController extends  \yii\rest\ActiveController
{
    public $modelClass = '';

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
////        $behaviors['authenticator'] = [
////            'class' => HttpSecretKeyAuth::className(),
////        ];
////        $behaviors['authenticator']['except'] = [
////            'test',
////        ];
//
//        return $behaviors;
//    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['class'] = 'app\modules\yandexpayment\actions\index\IndexAction';

        return $actions;
    }


    protected function verbs(){
        return [
            'index' => ['GET', 'POST'],
        ];
    }

//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    /*
    public function actionIndex()
    {
        //Yii::$app->response->format = 'json';

//        $msg = 'GET:<br />';
//        foreach(Yii::$app->request->get() as $key => $val) {
//            $msg .= $key.'='.$val."<br />";
//        }
//
//        $msg .= '<br /><br />POST:<br />';
//        foreach(Yii::$app->request->post() as $key => $val) {
//            $msg .= $key.'='.$val."<br />";
//        }

//        $source = file_get_contents('php://input');
//        $json = json_decode($source, true);

//        $msg = '';
//        foreach($json as $key => $val) {
//            $msg .= $key.'='.$val."<br />";
//        }

//        Yii::$app->mailer->compose()
//            ->setFrom('admin@developer.almobus.ru')
//            ->setTo('vlad.shetinin@gmail.com')
//            //->setTo('nara-dress@yandex.ru')
//            ->setSubject('сообщение от Яндекс оплаты')
//            //->setTextBody($msg)
//            ->setHtmlBody($json)
//            ->send();
        // отсюда шлем сигнал через сокет-демона к клиенту в браузер
        //$post = Yii::$app->request->post();

        return;
    }
*/
}
