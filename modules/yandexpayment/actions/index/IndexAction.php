<?php

namespace app\modules\yandexpayment\actions\index;

use app\models\YandexPayment;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class IndexAction extends \yii\rest\Action
{
    public $modelClass = '';


    public function run()
    {
        $source = file_get_contents('php://input');
        $json = json_decode($source, true);

//        $msg = $source;
//        foreach($json as $key => $val) {
//            $msg .= $key.'='.$val."\n";
//        }



//        {
//          "type" : "notification",
//          "event" : "payment.waiting_for_capture",
//          "object" :
//          {
//                "id" : "248a5aa6-000f-5000-a000-18fd2c5e5d52",
//                "status" : "waiting_for_capture",
//                "paid" : true,
//                "amount" : {
//                  "value" : "11.00",
//                  "currency" : "RUB"
//                },
//                "authorization_details" : {
//                  "rrn" : "705166624692",
//                  "auth_code" : "623740"
//                },
//                "created_at" : "2019-06-05T22:49:38.927Z",
//                "description" : "Заказ №110",
//                "expires_at" : "2019-06-12T22:49:41.490Z",
//                "metadata" : { },
//                "payment_method" : {
//                  "type" : "bank_card",
//                  "id" : "248a5aa6-000f-5000-a000-18fd2c5e5d52",
//                  "saved" : false,
//                  "card" : {
//                    "first6" : "555555",
//                    "last4" : "4444",
//                    "expiry_month" : "11",
//                    "expiry_year" : "2021",
//                    "card_type" : "MasterCard"
//                  },
//                  "title" : "Bank card *4444"
//                },
//                "recipient" : {
//                  "account_id" : "610090",
//                  "gateway_id" : "1590074"
//                },
//                "refundable" : false,
//                "test" : true
//          }
//        }


        // когда проводиться возврат средств, то приходит такой пинг:
//        [
//            'type' => 'notification',
//            'event' => 'refund.succeeded',
//            'object' => [
//                'id' => '24a4c36c-0015-5000-8000-1addfd9ca393',
//                'status' => 'succeeded',
//                'amount' => [
//                    'value' => '450.00',
//                    'currency' => 'RUB'
//                ],
//                'created_at' => '2019-06-25T23:35:08.713Z',
//                'payment_id' => '24a4ac4f-000f-5000-8000-1252846386e2'
//            ]
//        ]


        // нужно извлеч: id платежа, статус, чем оплата происходила
//        $msg .= 'payment_id='.$json['object']['id']."\n";
//        $msg .= 'client_ext_id='.$json['object']['metadata']['client_ext_id']."\n";
//        $msg .= 'status='.$json['object']['status']."\n";
//        $msg .= 'value='.$json['object']['amount']['value']."\n";
//        $msg .= 'currency='.$json['object']['amount']['currency']."\n";
//        $msg .= 'payment_type='.$json['object']['payment_method']['type']."\n";

        $payment_id = $json['object']['id'];
        $yandex_payment = YandexPayment::find()->where(['yandex_payment_id' => $payment_id])->one();
        if($yandex_payment == null) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo('vlad.shetinin@gmail.com')
                ->setSubject('сообщение от Яндекс оплаты')
                ->setTextBody('Платеж с yandex_payment_id='.$payment_id.' не найден')
                ->send();
            return;
        }

        if($yandex_payment->status == $json['object']['status']) { // если статус уже такой был, то выходим!
            return;
        }

        $yandex_payment->status = $json['object']['status'];
        if($yandex_payment->status == 'pending') {
            $yandex_payment->pending_at = time();
        }elseif($yandex_payment->status == 'waiting_for_capture') {
            $yandex_payment->waiting_for_capture_at = time();
        }elseif($yandex_payment->status == 'succeeded') {
            $yandex_payment->succeeded_at = time();
        }elseif($yandex_payment->status == 'canceled') {
            $yandex_payment->canceled_at = time();
        }

        if(in_array($yandex_payment->status, ['waiting_for_capture', 'succeeded'])) {
            $yandex_payment->value = $json['object']['amount']['value'];
            $yandex_payment->currency = $json['object']['amount']['currency'];
        }

        $yandex_payment->payment_type = $json['object']['payment_method']['type'];

        if(!$yandex_payment->save(false)) {
            $msg = "Не удалось сохранить платеж: \n";
            foreach($yandex_payment as $key => $value) {
                $msg .= $key.'='.$value."\n";
            }
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo('vlad.shetinin@gmail.com')
                ->setSubject('сообщение от Яндекс оплаты')
                ->setTextBody($msg)
                ->send();
            return;
        }



        if($yandex_payment->status == 'succeeded') {


//            $msg = "yandex_payment_status=".$yandex_payment->status." \n";
//            Yii::$app->mailer->compose()
//                ->setFrom(Yii::$app->params['adminEmail'])
//                ->setTo('vlad.shetinin@gmail.com')
//                ->setSubject('сообщение от Яндекс оплаты')
//                ->setTextBody($msg)
//                ->send();


            $clientext = $yandex_payment->clientext;
            if ($clientext == null) {
                $msg = "Не найдена заявка к которой привязана оплата: \n";
                foreach ($yandex_payment as $key => $value) {
                    $msg .= $key . '=' . $value . "\n";
                }
                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo('vlad.shetinin@gmail.com')
                    ->setSubject('сообщение от Яндекс оплаты')
                    ->setTextBody($msg)
                    ->send();
                return;
            }


            if ($yandex_payment->currency != 'RUB') {
                $msg = "Обнаружена валюта(" . $yandex_payment->currency . "), которая не используется на сайте: \n";
                foreach ($yandex_payment as $key => $value) {
                    $msg .= $key . '=' . $value . "\n";
                }
                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo('vlad.shetinin@gmail.com')
                    ->setSubject('сообщение от Яндекс оплаты')
                    ->setTextBody($msg)
                    ->send();
                return;
            }


            if($yandex_payment->type == 'payment')
            {
//                $msg = "yandex_payment_type=".$yandex_payment->type." \n";
//                Yii::$app->mailer->compose()
//                    ->setFrom(Yii::$app->params['adminEmail'])
//                    ->setTo('vlad.shetinin@gmail.com')
//                    ->setSubject('сообщение от Яндекс оплаты')
//                    ->setTextBody($msg)
//                    ->send();


                if ($yandex_payment->currency == 'RUB') {
                    $clientext->paid_summ += $yandex_payment->value;
                }

                $clientext->payment_in_process = false;
                $this->payment_source = 'application';
                $clientext->sync_date = null;
                if(empty($clientext->status)) {
                    $clientext->status = 'created';
                    $clientext->status_setting_time = time();
                }

            }elseif($yandex_payment->type == 'return_payment') { // пришел success по проводимому возврату

                if ($yandex_payment->currency == 'RUB') {
                    $clientext->paid_summ -= $yandex_payment->value;
                }
                $this->payment_source = 'application';
                $clientext->sync_date = null;
            }


//            $msg = "сейчас будет сохраняться заказ \n";
//            foreach($clientext as $key => $val) {
//                $msg .= $key.'='.$val."\n";
//            }
//            Yii::$app->mailer->compose()
//                ->setFrom(Yii::$app->params['adminEmail'])
//                ->setTo('vlad.shetinin@gmail.com')
//                ->setSubject('сообщение от Яндекс оплаты')
//                ->setTextBody($msg)
//                ->send();


            if (!$clientext->save(false)) {
                $msg = "Не удалось сохранить заявку: \n";
                foreach ($clientext as $key => $value) {
                    $msg .= $key . '=' . $value . "\n";
                }
                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo('vlad.shetinin@gmail.com')
                    ->setSubject('сообщение от Яндекс оплаты')
                    ->setTextBody($msg)
                    ->send();
                return;
            }
//            else {
//                $msg = "Заказ ".$clientext->id." сохранен. paid_summ=".$clientext->paid_summ.": \n";
//                Yii::$app->mailer->compose()
//                    ->setFrom(Yii::$app->params['adminEmail'])
//                    ->setTo('vlad.shetinin@gmail.com')
//                    ->setSubject('сообщение от Яндекс оплаты')
//                    ->setTextBody($msg)
//                    ->send();
//                return;
//            }


        }elseif($yandex_payment->status == 'canceled') {

            $clientext = $yandex_payment->clientext;
            if ($clientext == null) {
                $msg = "Не найдена заявка к которой привязана оплата: \n";
                foreach ($yandex_payment as $key => $value) {
                    $msg .= $key . '=' . $value . "\n";
                }
                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo('vlad.shetinin@gmail.com')
                    ->setSubject('сообщение от Яндекс оплаты')
                    ->setTextBody($msg)
                    ->send();
                return;
            }

            $clientext->setField('payment_in_process', false);
        }

        return; // 200
    }
}
