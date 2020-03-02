<?php

namespace app\modules\serverapi\actions\clientext;

use app\models\ClientExt;
use app\models\Passenger;
use Yii;
use yii\helpers\ArrayHelper;


class GetNotSyncClientextsAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Возвращается список не синхронизированных заявок
     *
     * запрос: curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/clientext/get-not-sync-clientexts
     * запрос с кодом доступа: curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/clientext/get-not-sync-clientexts
     */
    public function run()
    {
        // нужны поля клиента: id, name, mobile_phone, логин - нет такого, пароль - нет такого
        \Yii::$app->response->format = 'json';

        $client_exts = ClientExt::find()
            ->where(['sync_date' => NULL])
            ->andWhere(['status' => [
                'created_with_time_confirm', 'created_without_time_confirm',
                // не завершенные отмененные заказы не должны перетекать в CRM, чтобы не менять статистику отмен
                //'canceled_not_ready_order_by_client', 'canceled_not_ready_order_auto',
                'canceled_by_client',
                'canceled_by_operator',
                'created_with_time_sat', 'sended'
            ]])
            ->limit(50)
            ->all();

        $clientExtPassengers = [];
        if(count($client_exts) > 0) {
            $sql = 'SELECT p.*, cp.*
                FROM `passenger` p
                INNER JOIN `client_ext_passenger` cp ON cp.passenger_id = p.id
                WHERE cp.client_ext_id IN (' . implode(',', ArrayHelper::map($client_exts, 'id', 'id')) . ')';
            $clientExtPassengers = Yii::$app->db->createCommand($sql)->queryAll();
        }
        $aClientExtPassengers = [];
        foreach($clientExtPassengers as $passenger) {
            $aClientExtPassengers[$passenger['client_ext_id']][$passenger['passenger_id']] = $passenger;
        }



        //+id
        //+id -> 		client_ext.client_server_ext_id
        //+status   -> 	client_ext.status
        //+user_id   -> 	не передается
        //+direction ->    direction_id (преобразую)
        //+data   ->  	data_mktime (преобразую)
        //time   ->  	time
        //user.fio  ->    fio  (фио на основном сервере в таблице client.name должен переписаться только после создания заказа(т.е. после
        //подтверждения оператором) )
        //user.phone
        //user.email


        // у каждого клиента есть массив с данными пассажиров
        $aClientExts = [];
        if(count($client_exts) > 0) {
            foreach($client_exts as $client_ext) {
                $user = $client_ext->user;

                $fio = $client_ext->last_name;
                if(!empty($client_ext->first_name)) {
                    $fio .= ' '.$client_ext->first_name;
                }

                $aClientExts[] = [
                    'id' => $client_ext->id,
                    'source_type' => $client_ext->source_type,
                    'main_server_order_id' => $client_ext->main_server_order_id,

                    'is_mobile' => $client_ext->is_mobile,
                    'status' => $client_ext->status,

                    'status_setting_time' => $client_ext->status_setting_time,
                    'cancellation_click_time' => $client_ext->cancellation_click_time,
                    'cancellation_clicker_id' => $client_ext->cancellation_clicker_id,

                    'direction_id' => $client_ext->direction_id,
                    'data' => $client_ext->data,
                    'time' => $client_ext->time,

                    'places_count' => $client_ext->places_count,
                    'student_count' => $client_ext->student_count,
                    'child_count' => $client_ext->child_count,
                    'is_not_places' => $client_ext->is_not_places,
                    'prize_trip_count' => $client_ext->prize_trip_count,
                    'price' => $client_ext->price,
                    'used_cash_back' => $client_ext->used_cash_back,
                    'accrual_cash_back' => $client_ext->accrual_cash_back,
                    'penalty_cash_back' => $client_ext->penalty_cash_back,
                    'paid_summ' => $client_ext->paid_summ,
                    'is_paid' => $client_ext->is_paid,
                    'paid_time' => $client_ext->paid_time,
                    'payment_source' => $client_ext->payment_source,
                    'yandex_point_from_id' => $client_ext->yandex_point_from_id,
                    'yandex_point_from_name' => $client_ext->yandex_point_from_name,
                    'yandex_point_from_lat' => $client_ext->yandex_point_from_lat,
                    'yandex_point_from_long' => $client_ext->yandex_point_from_long,
                    'yandex_point_to_id' => $client_ext->yandex_point_to_id,
                    'yandex_point_to_name' => $client_ext->yandex_point_to_name,
                    'yandex_point_to_lat' => $client_ext->yandex_point_to_lat,
                    'yandex_point_to_long' => $client_ext->yandex_point_to_long,

                    'time_air_train_arrival' => $client_ext->time_air_train_arrival,
                    'time_air_train_departure' => $client_ext->time_air_train_departure,

                    //'fio' => $client_ext->fio,
                    'fio' => $fio,
                    'phone' => $client_ext->phone,
                    'email' => $client_ext->email,
                    //'cashback' => $user->cashback,

                    'passengers' => isset($aClientExtPassengers[$client_ext->id]) ? $aClientExtPassengers[$client_ext->id] : [],

                    'suitcase_count' => $client_ext->suitcase_count,
                    'bag_count' => $client_ext->bag_count,
                    'trip_id' => ($client_ext->trip != null ? $client_ext->trip->main_server_trip_id : ''),
                    'time_confirm' => $client_ext->time_confirm,
                    //'but_checkout' => $client_ext->but_checkout,
                ];
            }
        }

        return $aClientExts;
    }
}
