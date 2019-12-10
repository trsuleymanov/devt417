<?php

namespace app\models;

use ErrorException;
use YandexCheckout\Client;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "yandex_payment".
 *
 * @property int $id
 * @property string $type
 * @property string $yandex_payment_id id текущего платежа/возврата в системе яндекса
 * @property string $source_yandex_payment_id id платежа в системе яндекса по которой производиться возврат
 * @property int $source_payment_id id платежа в текущей таблице по которой производиться возврат
 * @property int $client_ext_id Заявка
 * @property string $payment_type Тип платежной системы с помощью которой произведена оплата (например bank_card)
 * @property string $status
 * @property int $created_at Создан
 * @property int $pending_at Время перехода платежа в статус pending
 * @property int $waiting_for_capture_at Время перехода платежа в статус waiting_for_capture
 * @property int $succeeded_at Время перехода платежа в статус succeeded
 * @property int $canceled_at Время перехода платежа в статус canceled
 */
class YandexPayment extends \yii\db\ActiveRecord
{
    public static $shopId = '610090'; // идентификатор магазина в яндексе
    public static $api_key = 'test_Y9KAEB2ZcuNyF7X96tHo_507c4JkoUpswzXAEbLRKLA'; // секретный ключ для API

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'yandex_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'source_type'], 'string'],
            [['source_payment_id', 'client_ext_id', 'created_at', 'pending_at', 'waiting_for_capture_at', 'succeeded_at', 'canceled_at'], 'integer'],
            [['yandex_payment_id', 'source_yandex_payment_id'], 'string', 'max' => 36],
            [['payment_token'], 'string', 'max' => 40],
            [['payment_type'], 'string', 'max' => 16],
            [['currency'], 'string', 'max' => 4],
            [['value'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип', // payment, return_payment
            'payment_token' => 'токен для провещения мобильного платежа',
            'source_type' => 'Источник',
            'yandex_payment_id' => 'id текущего платежа/возврата в системе яндекса',
            'source_yandex_payment_id' => 'id платежа в системе яндекса по которой производиться возврат',
            'source_payment_id' => 'id платежа в текущей таблице по которой производиться возврат',
            'client_ext_id' => 'Заявка',
            'value' => 'Сумма, руб',
            'currency' => 'Валюта',
            'payment_type' => 'Тип платежной системы с помощью которой произведена оплата (например bank_card)',
            'status' => 'Статус', // 'pending', 'waiting_for_capture', 'succeeded', 'canceled'
            'created_at' => 'Создан',
            'pending_at' => 'Время перехода платежа в статус pending',
            'waiting_for_capture_at' => 'Время перехода платежа в статус waiting_for_capture',
            'succeeded_at' => 'Время перехода платежа в статус succeeded',
            'canceled_at' => 'Время перехода платежа в статус canceled',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }

        return parent::beforeSave($insert);
    }

    public static function getTypes() {
       return [
           'payment' => 'Оплата',
           'return_payment' => 'Возврат'
       ];
    }

    public static function getSourceTypes() {
        return [
            'site' => "Сайт",
            'app' => "Приложение"
        ];
    }

    public static function getStatuses() {
        return [
            'pending' => 'В процессе',
            'waiting_for_capture' => 'Ожидает подтверждения от сайта на снятие средств',
            'succeeded' => 'Успешно завершен',
            'canceled' => 'Отменен'
        ];
    }

    public function getClientext() {
        return $this->hasOne(ClientExt::className(), ['id' => 'client_ext_id']);
    }


    public function setField($field_name, $field_value)
    {
        if(!empty($field_value)) {
            $field_value = htmlspecialchars($field_value);
        }

        if($field_value === false) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = false WHERE id = '.$this->id;
        }elseif(empty($field_value)) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = NULL WHERE id = '.$this->id;
        }else {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = "'.$field_value.'" WHERE id = '.$this->id;
        }

        return Yii::$app->db->createCommand($sql)->execute();
    }



    // метод создания платежа с сайта
    // ...


    // метод создания мобильного платежа с токеном платежа переданным из мобильного
    public function createMobilePayment() {

        $client_ext = $this->clientext;

        $data = [
            'payment_token' => $this->payment_token,
            'amount' => array(
                'value' => $this->value,
                'currency' => $this->currency,
            ),
            'capture' => false, //'capture' => false, // двухстадийный платеж - в этом случае при оплате заказ перейдет в статус waiting_for_capture,
            // и далее сайт должен будет запросить списание замороженной суммы. Если
            // от сайта не придет запрос на списание оплаты (на это выделяется 6 часов или 7 суток - точно время передается в параметре
            // - expires_atы), то заказ перейдет в статус отменен
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => Yii::$app->params['siteUrl']."/trip/payment-finish?c=".$client_ext->access_code
            ],
            'description' => "Заказ №".$this->client_ext_id,
        ];


        $client = new Client();
        $client->setAuth(YandexPayment::$shopId, YandexPayment::$api_key);

        $yandex_response = $client->createPayment($data, uniqid('', true));

        //$yandex_payment = new YandexPayment();
        //$yandex_payment->yandex_payment_id = $payment->id;

        // посмотри чтобы позже эти данные записались при приходе пингов от яндекс.кассы
        //$yandex_payment->value = $payment->amount->value;
        //$yandex_payment->currency = $payment->amount->currency;

        $this->status = $yandex_response->status;
        $this->yandex_payment_id = $yandex_response->id;
        if($this->status == 'pending') {
            $this->pending_at = time();
        }elseif($this->status == 'waiting_for_capture') {
            $this->waiting_for_capture_at = time();
        }elseif($this->status == 'succeeded') {
            $this->succeeded_at = time();
        }elseif($this->status == 'canceled') {
            $this->canceled_at = time();
        }
        if(!$this->save(false)) {
            throw new ErrorException('Не удалось сохранить платеж');
        }

        return $yandex_response;
    }

    // метод списания полной сумма раннее проведенного платежа находящегося в состоянии waiting_for_capture
    public function capturePayment() {

        $client = new Client();
        $client->setAuth(YandexPayment::$shopId, YandexPayment::$api_key);
        $yandex_response = $client->capturePayment(
            array(
                'amount' => $this->value,
            ),
            $this->yandex_payment_id,
            uniqid('', true)
        );

        //echo "payment:<pre>"; print_r($payment); echo "</pre>";

        if($this->status == $yandex_response->status) { // защита от повторной записи
            return;
        }


        $this->status = $yandex_response->status;
        if($this->status == 'pending') {
            $this->pending_at = time();
        }elseif($this->status == 'waiting_for_capture') {
            $this->waiting_for_capture_at = time();
        }elseif($this->status == 'succeeded') {
            $this->succeeded_at = time();
        }elseif($this->status == 'canceled') {
            $this->canceled_at = time();
        }
        if(!$this->save(false)) {
            throw new ErrorException('Не удалось сохранить платеж');
        }

        // позже через несколько секунд будет пинг от яндекс.кассы об оплате, важно чтобы там повторно эта сумма не расчиталась
        if($this->status == 'succeeded') {

            $clientext = $this->clientext;
            $clientext->payment_in_process = false;
            //$clientext->is_paid = false;
            $clientext->paid_summ = $clientext->paid_summ + $this->value;
            $clientext->sync_date = null;

            if(empty($clientext->status)) {
                $clientext->status = 'created';
                $clientext->status_setting_time = time();
            }

            if (!$clientext->save(false)) {
                throw new ErrorException('Не удалось сохранить в заказе оплаченную сумму');
            }
        }elseif($this->status == 'canceled') {
            $clientext = $this->clientext;
            $clientext->setField('payment_in_process', false);
        }

        return $yandex_response;
    }


    /**
     * Возврат
     *
     * @return \YandexCheckout\Request\Refunds\CreateRefundResponse
     * @throws ErrorException
     * @throws \YandexCheckout\Common\Exceptions\ApiException
     * @throws \YandexCheckout\Common\Exceptions\BadApiRequestException
     * @throws \YandexCheckout\Common\Exceptions\ForbiddenException
     * @throws \YandexCheckout\Common\Exceptions\InternalServerError
     * @throws \YandexCheckout\Common\Exceptions\NotFoundException
     * @throws \YandexCheckout\Common\Exceptions\ResponseProcessingException
     * @throws \YandexCheckout\Common\Exceptions\TooManyRequestsException
     * @throws \YandexCheckout\Common\Exceptions\UnauthorizedException
     */
    public function returnPayment() {

        $client = new Client();
        $client->setAuth(YandexPayment::$shopId, YandexPayment::$api_key);
        $yandex_response = $client->createRefund(
            array(
                'amount' => array(
                    'value' => $this->value,
                    'currency' =>  (!empty($this->currency) ? $this->currency : 'RUB'),
                ),
                'payment_id' => $this->yandex_payment_id, //  '21740069-000f-50be-b000-0486ffbf45b0',
            ),
            uniqid('', true)
        );

        // $yandex_response:
//    {
//        "id": "216749f7-0016-50be-b000-078d43a63ae4",
//        "status": "succeeded",
//        "amount": {
//              "value": "2.00",
//              "currency": "RUB"
//        },
//        "created_at": "2017-10-04T19:27:51.407Z",
//        "payment_id": "21740069-000f-50be-b000-0486ffbf45b0"
//    }

        // нужно проверить что по одному и тому же платежу нельзя провести 2 раза возврат
        // нужно сохранить в базе новый платеж типа "возврат"
        $return_payment = new YandexPayment();
        $return_payment->type = 'return_payment';
        //$return_payment->source_type = 'site';
        $return_payment->yandex_payment_id = $yandex_response->id;
        $return_payment->source_yandex_payment_id = $this->yandex_payment_id; // сохраняем связь с платежом который возвращаем
        $return_payment->source_payment_id = $this->id; // сохраняем связь с платежом который возвращаем
        $return_payment->client_ext_id = $this->client_ext_id;
        if(!$return_payment->save(false)) {
            throw new ErrorException('Не удалось сохранить возврат');
        }
    }
}
