<?php
namespace app\modules\yandexpayment\controllers;


use app\models\ClientExt;
use app\models\YandexPayment;
use Yii;
use yii\base\ErrorException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use YandexCheckout\Client;
use yii\filters\VerbFilter;


class PaymentController extends Controller
{
    public $modelClass = '';


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionTest() {

        //$json='{"name": "Test Case","desc": "This is test task"}';
//        $json = '{"type":"notification","event":"payment.waiting_for_capture","object":{"id":"2185355e-000f-5081-a000-0000000",
//"status":"waiting_for_capture","paid":true,"amount":{"value":"10.00","currency":"RUB"},"created_at":"2017-09-27T12:07:58.702Z",
//"expires_at":"2017-11-03T12:08:23.080Z","metadata":{},"payment_method":{"type":"bank_card","id":"2185355e-000f-5081-a000-0000000",
//"saved":false,"card":{"last4":"1026","expiry_month":"12","expiry_year":"2025","card_type":"Unknown"},"title":"Bank card *1026"},
//"recipient":{"account_id":"000005","gateway_id":"0000015"}}}';

//        $json='{"name": "Test Case","desc": "This is test task"}';
//        $ch = curl_init('http://developer.almobus.ru/yandex-payment/default');
//        curl_setopt($ch, CURLOPT_POST, true); //переключаем запрос в POST
//        curl_setopt($ch, CURLOPT_POSTFIELDS,$json); //Это POST данные
//        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
//        curl_exec($ch);
//        curl_close($ch);

        $json='{"name": "Test Case","desc": "This is test task"}';
        //$json=json_encode($json);
        //$ch = curl_init('https://developer.almobus.ru/yandex-payment/default/index');
        //$ch = curl_init('https://developer.almobus.ru/yandex-payment2/test/test');
        //$ch = curl_init('http://tobus-client.ru/yandex-payment2/test/test');
        $ch = curl_init('http://tobus-client.ru/yandex-payment/default/index');
        curl_setopt($ch, CURLOPT_POST, true); //переключаем запрос в POST
        //curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        //curl_setopt($ch,CURLOPT_PROTOCOLS,CURLPROTO_HTTPS);
        //curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    public function actionAjaxMakeSimplePayment($c, $source_page) {

        Yii::$app->response->format = 'json';

        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }


        $summ = $client_ext->price - $client_ext->paid_summ - $client_ext->used_cash_back;


        if($summ <= 0) {
            throw new ForbiddenHttpException('Сумма оплаты должна быть больше нуля');
        }

        if($source_page == 'check-order') {
            $return_url = Yii::$app->params['siteUrl']."/site/finish-order?c=".$client_ext->access_code;
        }elseif($source_page == 'account/order/history') {
            $return_url = Yii::$app->params['siteUrl']."/account/order/history";
        }

        // в метод создания платежа с сайта...
        $data = [
            'amount' => [
                'value' => $summ,
                'currency' => 'RUB'
            ],
            'capture' => true, // в этом случае при оплате заказ сразу будет переходить в статус succeeded
            //'capture' => false, // двухстадийный платеж - в этом случае при оплате заказ перейдет в статус waiting_for_capture,
            // и далее сайт должен будет запросить списание замороженной суммы. Если
            // от сайта не придет запрос на списание оплаты (на это выделяется 6 часов или 7 суток - точно время передается в параметре
            // - expires_atы), то заказ перейдет в статус отменен
            'confirmation' => [
                'type' => "redirect",
                'return_url' => $return_url
            ],
            'description' => "Заказ №".$client_ext->id,
//            'metadata' => [
//                'client_ext_id' => $client_ext->id
//            ]
        ];

        $client = new Client();
        $client->setAuth(YandexPayment::$shopId, YandexPayment::$api_key);

        $payment = $client->createPayment($data, uniqid('', true));

//        {
//          "id": "2419a771-000f-5000-9000-1edaf29243f2",
//          "status": "pending",
//          "paid": false,
//          "amount": {
//            "value": "100.00",
//            "currency": "RUB"
//          },
//          "confirmation": {
//            "type": "redirect",
//            "confirmation_url": "https://money.yandex.ru/api-pages/v2/payment-confirm/epl?orderId=2419a771-000f-5000-9000-1edaf29243f2"
//          },
//          "created_at": "2019-03-12T11:10:41.802Z",
//          "description": "Заказ №1",
//          "metadata": {
//             "client_ext_id": "37"
//          },
//          "recipient": {
//            "account_id": "100001",
//            "gateway_id": "1000001"
//          },
//          "test": false
//        }

        // мне нужно извлеч:
        // id, status, confirmationUrl(- не сохранять)

        $yandex_payment = new YandexPayment();
        $yandex_payment->type = 'payment';
        $yandex_payment->source_type = 'site';
        $yandex_payment->yandex_payment_id = $payment->id;
        $yandex_payment->client_ext_id = $client_ext->id;
        //$yandex_payment->value = $payment->amount->value;
        //$yandex_payment->currency = $payment->amount->currency;
        $yandex_payment->status = $payment->status;
        if($yandex_payment->status == 'pending') {
            $yandex_payment->pending_at = time();
        }elseif($yandex_payment->status == 'waiting_for_capture') {
            $yandex_payment->waiting_for_capture_at = time();
        }elseif($yandex_payment->status == 'succeeded') {
            $yandex_payment->succeeded_at = time();
        }elseif($yandex_payment->status == 'canceled') {
            $yandex_payment->canceled_at = time();
        }
        if(!$yandex_payment->save(false)) {
            throw new ErrorException('Не удалось сохранить платеж');
        }
// в метод создания платежа с сайта... -->

        return [
            'success' => true,
            'redirect_url' => $payment->confirmation->confirmationUrl,
        ];
    }

}
