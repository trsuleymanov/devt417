<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

class Call extends \yii\base\Model
{
//    public function rules()
//    {
//        return [
//            [['date', 'direction_id', 'trip_id', 'orders_count'], 'required'],
//            [['orders_count'], 'integer', 'min' => 1, 'max' => 50],
//            [['transports_count'], 'integer', 'min' => 0, 'max' => 5],
//            [['direction_id', 'trip_id', 'orders_count'], 'integer'],
//            [['date'], 'safe']
//        ];
//    }
//
//    public function attributeLabels()
//    {
//        return [
//            'date' => 'Дата',
//            'direction_id' => 'Направление',
//            'trip_id' => 'Рейс',
//            'orders_count' => 'Количество заказов',
//            'transports_count' => 'Машин на рейсе (можно не заполнять)'
//        ];
//    }

    public static function clearDbMobilePhone($db_mobile_phone) {

        $phone = str_replace('-', '', $db_mobile_phone);
        $phone = str_replace('+7', '', $phone);

        return $phone;
    }

    // создание переадресации
    public static function makeCallForwarding($db_mobile_phone) {

        // curl -X POST --header 'X-MPBX-API-AUTH-TOKEN: b3469183-f19a-46ce-9b44-19ace72e84c2' --header 'Content-Type: application/json' -d ' [ { "inboundNumber": "9035621779", "extension": "4002" }] ' 'https://cloudpbx.beeline.ru/apis/portal/icr/route'
        $headers[] = 'X-MPBX-API-AUTH-TOKEN: '.Yii::$app->params['subscription_id'];
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $data = [
            [
                'inboundNumber' => self::clearDbMobilePhone($db_mobile_phone), // 9035621779
                'extension' => "4002"
            ]
        ];
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => 'https://cloudpbx.beeline.ru/apis/portal/icr/route',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            //CURLOPT_POSTFIELDS => http_build_query($data)
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);

        if($result[0]->status == 'SUCCESS') {
            return true;
        }else {
            throw new ErrorException('АТС вернула ошибку: '. $result[0]->error->description);
        }
    }

    // удаление переадресации
    public static function deleteCallForwarding($db_mobile_phone) {

        // curl -X DELETE --header 'X-MPBX-API-AUTH-TOKEN: b3469183-f19a-46ce-9b44-19ace72e84c2' --header 'Content-Type: application/json' -d ' [ { "inboundNumber": "9035621779", "extension": "4002" }] ' 'https://cloudpbx.beeline.ru/apis/portal/icr/route'

        $headers[] = 'X-MPBX-API-AUTH-TOKEN: '.Yii::$app->params['subscription_id'];
        $headers[] = 'Content-Type: application/json; charset=UTF-8';
        $data = [
            [
                'inboundNumber' => self::clearDbMobilePhone($db_mobile_phone), // 9035621779
                'extension' => "4002"
            ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_URL => 'https://cloudpbx.beeline.ru/apis/portal/icr/route',
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            //CURLOPT_POSTFIELDS => http_build_query($data)
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response);
        // echo "result:<pre>"; print_r($result); echo "</pre>";

        if($result[0]->status == 'SUCCESS') {
            return true;
        }else {
            throw new ErrorException('АТС вернула ошибку: '. $result[0]->error->description);
        }
    }
}


?>