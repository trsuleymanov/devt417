<?php
namespace app\modules\beeline\controllers;


use app\models\Call;
use app\models\CallEvent;
use app\models\Client;
use Yii;
use yii\base\ErrorException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Принимаем сигналы слушателем звонков. Сигналы: ringing, established, completed - звонит, установил, завершил
 */
class SubscriptionController extends Controller
{
    public $modelClass = '';

    // если 30 секунд из АТС не приходят события по поводу
    // "не закрытого звонка", то звонок закрывается автоматически
    protected static $waiting_time_to_close_call = 30;



    public function actionIndex()
    {
        Yii::$app->response->format = 'json';

//        $xmlstring = Yii::$app->request->getRawBody();
//
//        $event = [];
//
//        if(!empty($xmlstring)) {
//            $XMLReader = new XMLReader();
//            $XMLReader->xml($xmlstring);
//            //var_dump($XMLReader->isValid());
//
//            while ($XMLReader->read()) {
//
//                if ($XMLReader->nodeType == XMLReader::ELEMENT) {
//                    $prevLocalName = $XMLReader->localName;
//                    continue;
//                }
//                if ($XMLReader->nodeType != XMLReader::TEXT) {
//                    continue;
//                }
//                $event[$prevLocalName] = $XMLReader->value;
//            }
//        }
//
//        if(!isset($event['extTrackingId'])) {
//            return;
//        }
//
//        $msg = '';
//        $msg .= 'время: '.date('H:i:s')."<br />";
//        foreach($event as $key => $val) {
//            $msg .= $key.'='.$val."<br />";
//        }
//        Yii::$app->mailer->compose()
//            ->setFrom('admin@developer.almobus.ru')
//            ->setTo('test.shetinin@gmail.com')
//            //->setTo('nara-dress@yandex.ru')
//            ->setSubject('сообщение от АТС')
//            //->setTextBody($msg)
//            ->setHtmlBody($msg)
//            ->send();

        return;
    }

}
