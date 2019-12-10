<?php

namespace app\modules\api\actions\clientext;

use app\models\ClientExt;
use app\models\YandexPayment;
use YandexCheckout\Client;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class SetPaymentAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Отмена заказа
     */
    public function run()
    {
        //$time = microtime(true);
        
        //sleep(10); // тест

        // requests_params=clientext_id=118&summ=450
        // &payment_token=pt-249398ff-0000-503b-8000-098da6740248&payment_type=BANK_CARD
        $clientext_id = intval(Yii::$app->getRequest()->getBodyParam('clientext_id'));
        $client_ext = ClientExt::find()->where(['id' => $clientext_id])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $summ = Yii::$app->getRequest()->getBodyParam('summ');
        if(empty($summ) || $summ < 1) {
            throw new ForbiddenHttpException('Должна быть указана сумма оплаты больше 1');
        }

        $payment_token = Yii::$app->getRequest()->getBodyParam('payment_token');
        if(empty($payment_token)) {
            throw new ForbiddenHttpException('Не передан токен платежа');
        }

        $payment_type = Yii::$app->getRequest()->getBodyParam('payment_type');
        if(empty($payment_type)) {
            throw new ForbiddenHttpException('Не передан тип/метод оплаты');
        }


        // $summ и $payment_type пока не сохраняю, позже посмотрю как они будут записываться...
        $yandex_payment = new YandexPayment();
        $yandex_payment->source_type = 'app';
        $yandex_payment->type = 'payment';
        $yandex_payment->payment_type = strtolower($payment_type);
        $yandex_payment->payment_token = $payment_token;
        $yandex_payment->client_ext_id = $client_ext->id;
        $yandex_payment->value = $summ;
        $yandex_payment->currency = 'RUB';
        if(!$yandex_payment->save(false)) {
            throw new ErrorException('Не удалось сохранить платеж');
        }

        $client_ext->setField('payment_in_process', true);

//        return [
//            'status' => 'unknown',
//            'redirect_url' => ''
//        ];

        //sleep(20);

        // проводим мобильный платеж
        $yandex_response = $yandex_payment->createMobilePayment();


        if($yandex_response->status == 'pending') {
            return [
                'status' => $yandex_response->status,
                'redirect_url' => $yandex_response->confirmation->confirmationUrl
            ];
        }elseif($yandex_response->status == 'waiting_for_capture') {

            // даже этот ответ приходит в сюда через 3 секунды после начала работы текущего скрипта
//            $result_time = (microtime(true) - $time);
//            throw new ErrorException('result_time='.$result_time); // несколько секунд проходит

            // сразу проводим списание только что замороженных средств
            $capture_yandex_response = $yandex_payment->capturePayment(); //а этот ответ приходит через 7 секунд после начала работы скрипта

            return [
                'status' => $capture_yandex_response->status,
                'redirect_url' => ''
            ];

        }else {
            return [
                'status' => $yandex_response->status,
                'redirect_url' => ''
            ];
        }

    }
}
