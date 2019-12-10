<?php

namespace app\commands;

use app\models\City;
use app\models\Push;
use app\models\Setting;
use app\models\Tariff;
use app\models\Trip;
use app\models\YandexPoint;
use Yii;
use app\models\ClientExt;
use app\models\User;
use yii\base\ErrorException;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\ForbiddenHttpException;

/**
 *  Отсюда отправляются запросы в главный сервер в диспетчерскую (запросы-экшены вызываются кроном)
 */
class MainServerController extends Controller
{
    //private $main_server_url = 'http://tobus-yii2.ru/serverapi/';
    //private $main_server_url = 'http://test2-vlad.tmweb.ru/serverapi/';
    //private $main_server_url = 'http://185.6.83.45:7900/serverapi/';
    //private $main_server_url = Yii::$app->params['adminEmail'];

    public static $secretKey = 'lsaeu5jERTffd_7'; // ключ доступа к serverapi основного сервера.


    /*
     * Возвращается список не синхронизированных заказов
     *
     * php yii main-server/get-not-sync-users
     */
    public function actionGetNotSyncUsers()
    {
        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'client/get-not-sync-clients')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {
            $aClients = $response->data;
            if(count($aClients) > 0) {

                $aIds = [];
                foreach($aClients as $aClient) {

                    $user = null;
                    if(!empty($aClient['email'])) {
                        $user = User::find()->where(['email' => $aClient['email']])->one();
                    }
                    if(!empty($aClient['mobile_phone']) && $user == null) {
                        $user = User::find()->where(['phone' => $aClient['mobile_phone']])->one();
                    }

                    if($user == null) {
                        $user = new User();
                        $user->email = $aClient['email'];
                        $user->phone = $aClient['mobile_phone'];
                        $user->fio = $aClient['name'];
                        $user->cashback = $aClient['cashback'];
                        $user->current_year_sended_places = $aClient['current_year_sended_places'];
                        $user->current_year_sended_prize_places = $aClient['current_year_sended_prize_places'];
                        $user->current_year_penalty = $aClient['current_year_penalty'];

                        if(!$user->save(false)) {
                            throw new ErrorException('Не удалось создать пользователя');
                        }
                    }else {
                        if($user->fio != $aClient['name']) {
                            $user->setField('fio', $aClient['name']);
                        }
                        if($user->email != $aClient['email'] && !empty($aClient['email'])) {
                            $user->setField('email', $aClient['email']);
                        }
                        if($user->phone != $aClient['mobile_phone'] && !empty($aClient['mobile_phone'])) {
                            $user->setField('phone', $aClient['mobile_phone']);
                        }
                        if($user->cashback != $aClient['cashback'] && !empty($aClient['cashback'])) {
                            $user->setField('cashback', $aClient['cashback']);
                        }
                        if($user->current_year_sended_places != $aClient['current_year_sended_places'] && !empty($aClient['current_year_sended_places'])) {
                            $user->setField('current_year_sended_places', $aClient['current_year_sended_places']);
                        }
                        if($user->current_year_sended_prize_places != $aClient['current_year_sended_prize_places'] && !empty($aClient['current_year_sended_prize_places'])) {
                            $user->setField('current_year_sended_prize_places', $aClient['current_year_sended_prize_places']);
                        }
                        if($user->current_year_penalty != $aClient['current_year_penalty'] && !empty($aClient['current_year_penalty'])) {
                            $user->setField('current_year_penalty', $aClient['current_year_penalty']);
                        }
                    }
                    //$user->sync_date = time();

                    if(!$user->save(false)) {
                        throw new ErrorException('Не удалось сохранить пользователя');
                    }
                    $user->setField('sync_date', time());


                    $aIds[$aClient['id']] = $aClient['id'];
                }

                // пошлем обратно ответ на основной сервер со списком id записанных клиентов, чтобы там была установлена дата синхронизации
                $request_2 = new Client();
                $response = $request_2->createRequest()
                    ->setMethod('post')
                    ->setUrl(Yii::$app->params['mainServerUrl'].'client/set-sync-to-clients?ids='.implode(',', $aIds))
                    ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
                    ->send();

                if ($response->statusCode == 200) {
                    echo "успешно завершено\n";
                }else {
                    echo "Пришел ответ на запрос установки дат синхронизации со статусом ".$response->statusCode."\n";
                    exit;
                }

            }else {
                echo "нечего записывать \n";
            }

        }else {
            echo "Пришел ответ на запрос со статусом ".$response->statusCode."\n";
            exit;
        }
    }

    /*
     * Возвращается список не синхронизированных заказов
     *
     * php yii main-server/get-not-sync-orders
     */
    /**
     * @throws ErrorException
     * @throws ForbiddenHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionGetNotSyncOrders()
    {
        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'order/get-not-sync-orders')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {


            $orders = $response->data;
            if(count($orders) > 0) {
                foreach($orders as $order) {

                    $client_ext = ClientExt::find()->where(['id' => $order['client_server_ext_id']])->one();
                    if($client_ext == null) {
                        $client_ext = ClientExt::find()->where(['main_server_order_id' => $order['order_id']])->one();
                    }

                    if($client_ext == null) {
                        //throw new ForbiddenHttpException('Заявка не найдена');
                        $client_ext = new ClientExt();
                        $client_ext->source_type = 'main_site';

                    }else {
                        $client_ext->source_type = 'client_site';// 'client_site', 'main_site', 'application'
                    }

                    $client_ext->main_server_order_id = $order['order_id'];

                    // статус после перезаписи $client_ext отдельно установим чтобы сработал нужный код
//                    $client_ext->status = ClientExt::convertMainServerOrderStatus($order);
//                    $client_ext->status_setting_time = $order['status_setting_time'];


                    $user = null;
                    if(!empty($order['client_email'])) {
                        $user = User::find()->where(['email' => $order['client_email']])->one();
                    }
                    if($user == null) {
                        $user = User::find()->where(['phone' => $order['client_mobile_phone']])->one();
                    }
//                    if($user == null) {
//                        $user = new User();
//                        $user->email = $order['client_email'];
//                        $user->phone = $order['client_mobile_phone'];
//                        $user->fio = $order['client_name'];
//                        $user->cashback = $order['client_cashback'];
//                        if(!$user->save(false)) {
//                            throw new ErrorException('Не удалось создать пользователя');
//                        }
//                    }else {
//                        if($user->fio != $order['client_name']) {
//                            $user->setField('fio', $order['client_name']);
//                        }
//                        if($user->email != $order['client_email'] && !empty($order['client_email'])) {
//                            $user->setField('email', $order['client_email']);
//                        }
//                        if($user->phone != $order['client_mobile_phone'] && !empty($order['client_mobile_phone'])) {
//                            $user->setField('phone', $order['client_mobile_phone']);
//                        }
//                        if($user->cashback != $order['client_cashback'] && !empty($order['client_cashback'])) {
//                            $user->setField('cashback', $order['client_cashback']);
//                        }
//                    }

                    // создание пользователя должно было произойти ранее при синхронизации пользователей
                    if($user == null) {
                        throw new ErrorException('Пользователь не найден');
                    }

                    $client_ext->user_id = $user->id;
                    $client_ext->phone = $order['client_mobile_phone'];
                    $client_ext->email = $order['client_email'];
                    $client_ext->direction_id = ($order['direction_name'] == 'АК' ? 1 : 2);
                    $client_ext->data = $order['date'];
                    $client_ext->time = $order['trip_mid_time'];
                    $client_ext->time_confirm = $order['time_confirm'];

                    $trip = null;
                    if(!empty($order['trip_name'])) {
                        $trip = Trip::find()
                            //->where(['date' => $order['date']])
                            ->where(['date' => $order['trip_date']])
                            ->andWhere(['direction_id' => ($order['direction_name'] == 'АК' ? 1 : 2)])
                            ->andWhere(['name' => $order['trip_name']])
                            ->one();
                        if($trip == null) {
                            throw new ErrorException('direction_name='.$order['direction_name'].' trip_name='.$order['trip_name'].' У заказа '.$this->id.' (в CRM id='.$order['order_id'].' trip_date='.$order['trip_date'].' direction_name='.$order['direction_name'].' trip_name='.$order['trip_name'].') не найден рейс');
                        }
                    }

                    $client_ext->trip_id = ($trip != null ? $trip->id : 0);
                    $client_ext->trip_name = $order['trip_name'];
                    $client_ext->places_count = $order['places_count'];
                    $client_ext->student_count = $order['student_count'];
                    $client_ext->child_count = $order['child_count'];
                    $client_ext->is_not_places = $order['is_not_places'];
                    $client_ext->prize_trip_count = $order['prize_trip_count'];
                    $client_ext->bag_count = $order['bag_count'];
                    $client_ext->suitcase_count = $order['suitcase_count'];


                    $client_ext->yandex_point_from_id = $order['yandex_point_from_id'];
                    $client_ext->yandex_point_from_name = $order['yandex_point_from_name'];
                    $client_ext->yandex_point_from_lat = $order['yandex_point_from_lat'];
                    $client_ext->yandex_point_from_long = $order['yandex_point_from_long'];
                    $client_ext->yandex_point_to_id = $order['yandex_point_to_id'];
                    $client_ext->yandex_point_to_name = $order['yandex_point_to_name'];
                    $client_ext->yandex_point_to_lat = $order['yandex_point_to_lat'];
                    $client_ext->yandex_point_to_long = $order['yandex_point_to_long'];

                    $client_ext->price = $order['price'];
                    $client_ext->accrual_cash_back = $order['accrual_cash_back'];
                    $client_ext->penalty_cash_back = $order['penalty_cash_back'];
                    $client_ext->used_cash_back = $order['used_cash_back'];
                    // $client_ext->discount // - такого поля нет в заказах диспетчерской

                    $client_ext->transport_car_reg = $order['transport_car_reg'];
                    $client_ext->transport_model = $order['transport_model'];
                    $client_ext->transport_color = $order['transport_color'];

                    $client_ext->sync_date = time();
                    if(!$client_ext->save(false)) {
                        throw new ErrorException('Не удалось сохранить заявку');
                    }

                    // отдельно установим статус через функцию чтобы сработал нужный код
                    $new_status = ClientExt::convertMainServerOrderStatus($order);
                    if($client_ext->status != $new_status) {
                        $client_ext->setStatus($new_status, false);
                    }

                    // если заявка-заказ перешел в статус "отправлена", то при наличии кода друга начисляем другу деньгу
//                    if(
//                        $client_ext->status == 'sended'
//                        && !empty($client_ext->friend_code)
//                    ) {
//                        $friend_user = User::find()->where(['code_for_friends' => $client_ext->friend_code])->one();
//                        if($friend_user == null) {
//                            throw new ForbiddenHttpException('Друг не найден');
//                        }
//
//                        $friend_user->addMoneyForFriend($client_ext->id);
//                    }

                    // если приходил пуш который нужно отправить вместе с обновлением данных по заявке, то отправим его
//                    $push = Push::find()
//                        ->where(['client_ext_id' => $client_ext->id])
//                        ->andWhere(['sended_at' => NULL])
//                        ->one();
//                    if($push != null) {
//                        $push->send();
//                    }
                }

                // пошлем обратно ответ на основной сервер со списком id записанных клиентов, чтобы там была установлена дата синхронизации
                $request_2 = new Client();
                $response = $request_2->createRequest()
                    ->setMethod('post')
                    ->setUrl(Yii::$app->params['mainServerUrl'].'order/set-sync-to-orders?ids='.implode(',', ArrayHelper::map($orders, 'order_id', 'order_id')))
                    ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
                    ->send();

                if ($response->statusCode == 200) {
                    echo "успешно завершено\n";
                }else {
                    echo "Пришел ответ на запрос установки дат синхронизации со статусом ".$response->statusCode."\n";
                    exit;
                }


            }else {
                echo "нечего записывать \n";
            }

        }else {
            echo "Пришел ответ на запрос получения клиентов со статусом ".$response->statusCode."\n";
            exit;
        }
    }



    // если на основном сервере есть изменения в рейсах, то получаем рейсы за последние 11 дней с основного сервера и
    // переписываем текущие рейсы
    // команда: php yii main-server/update-trips
    /**
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\httpclient\Exception
     */
    public function actionUpdateTrips()
    {
        $trip = Trip::find()->one();
        $created_updated_at = $trip != null ? $trip->created_updated_at : 0;

        // если хотим выгрузить все рейсы, то текущую таблицу рейсов нужно очистить и использовать $url для всех рейсов
        //$url = Yii::$app->params['mainServerUrl'].'trip/get-trips?created_updated_at=0&directions_ids=1,2&all_days=true';

        $url = Yii::$app->params['mainServerUrl'].'trip/get-trips?created_updated_at='.$created_updated_at.'&directions_ids=1,2';

        $request_1 = new Client();
        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {

//            return [
//                'new_max_date' => $max_date,
//                'trips' => $trips
//            ];

            $data = $response->data;
            if(!empty($data['new_max_date'])) {

                // удаляем все рейсы и пишем пришедшие с основного сервера
//                $sql = 'TRUNCATE `'.Trip::tableName().'`';
//                Yii::$app->db->createCommand($sql)->execute();


//                $aDates = [];
//                foreach($data['trips'] as $data_trip) {
//                    $aDates[] = [
//                        $data_trip['name'],
//                        $data_trip['date'],
//                        $data_trip['direction_id'],
//                        empty($data_trip['commercial']) ? 0 : 1,
//                        $data_trip['start_time'],
//                        $data_trip['mid_time'],
//                        $data_trip['end_time'],
//                        $data['new_max_date']
//                    ];
//                }
//
//                Yii::$app->db->createCommand()->batchInsert(
//                    'trip',
//                    ['name', 'date', 'direction_id', 'commercial', 'start_time', 'mid_time', 'end_time', 'created_updated_at'],
//                    $aDates
//                )->execute();



                //{"new_max_date":1561410017,"trips":[{"id":29033,"name":"3:40","date":1561410000,"direction_id":1,"commercial":null,"start_time":"03:00","mid_time":"03:20","end_time":"03:40","date_start_sending":null,"start_sending_user_id":null,"date_sended":null,"sended_user_id":null,"use_mobile_app":null,"created_at":1560546010,"updated_at":null},{"id":29034,


                // разделим пришедшие рейсы на новые и бывалые
                $aTripsId = [];
                // echo "count_trips=".count($data['trips'])."<br />"; exit;
                foreach($data['trips'] as $data_trip) {
                    $aTripsId[] = $data_trip['id'];
                }

                $exist_trips = Trip::find()->where(['main_server_trip_id' => $aTripsId])->all();
                $aExistTrips = [];
                if(count($exist_trips) > 0) {
                    $aExistTrips = ArrayHelper::index($exist_trips, 'main_server_trip_id'); // группируем по main_server_trip_id
                }

                $aExistDataTrips = [];
                $aNewDataTrips = [];
                foreach($data['trips'] as $data_trip) {
                    if($aExistTrips[$data_trip['id']]) {
                        $aExistDataTrips[$data_trip['id']] = $data_trip;
                    }else {
                        $aNewDataTrips[$data_trip['id']] = $data_trip;
                    }
                }


                if(count($aExistDataTrips) > 0) {
                    foreach ($aExistDataTrips as $data_trip) {
                        $exist_trip = $aExistTrips[$data_trip['id']];
                        $exist_trip->name = $data_trip['name'];
                        $exist_trip->date = $data_trip['date'];
                        $exist_trip->direction_id = $data_trip['direction_id'];
                        $exist_trip->commercial = empty($data_trip['commercial']) ? 0 : 1;
                        $exist_trip->start_time = $data_trip['start_time'];
                        $exist_trip->mid_time = $data_trip['mid_time'];
                        $exist_trip->end_time = $data_trip['end_time'];
                        $exist_trip->created_updated_at = $data['new_max_date'];

                        if(!$exist_trip->save(false)) {
                            throw new ErrorException('Не удалось обновлить рейс');
                        }
                    }
                }

                if(count($aNewDataTrips) > 0) {
                    $aSqlNewTrips = [];
                    foreach ($aNewDataTrips as $data_trip) {
                        $aSqlNewTrips[] = [
                            $data_trip['id'],
                            $data_trip['name'],
                            $data_trip['date'],
                            $data_trip['direction_id'],
                            empty($data_trip['commercial']) ? 0 : 1,
                            $data_trip['start_time'],
                            $data_trip['mid_time'],
                            $data_trip['end_time'],
                            $data['new_max_date']
                        ];
                    }

                    Yii::$app->db->createCommand()->batchInsert(
                        'trip',
                        ['main_server_trip_id', 'name', 'date', 'direction_id', 'commercial', 'start_time', 'mid_time', 'end_time', 'created_updated_at'],
                        $aSqlNewTrips
                    )->execute();
                }



                echo "Создано новых ".count($aNewDataTrips)." рейсов, обновлено ".count($aExistTrips)." рейсов.\n";

            }else {
                echo "Рейсы обновлять нет необходимости"."\n";
            }


        }else {
            echo "Пришел ответ на запрос получения рейсов со статусом ".$response->statusCode."\n";
            exit;
        }

    }


    // выкачка изменений яндекс-точек с основного сервера
    // создаем, обновляем или активируем/деактивируем яндекс-точки текущей базы
    // команда: php yii main-server/update-yandex-points
    public function actionUpdateYandexPoints() {

        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'yandex-point/get-yandex-points')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {
            $data = $response->data;
            $mainServerYandexPoints = $data['yandex_points'];

            $created_yandex_points_count = 0;
            $deactivate_yandex_points_count = 0;
            $activate_update_yandex_points_count = 0;

            $cities = City::find()->all();
            $aCities = ArrayHelper::map($cities, 'name', 'id');



            // точки id которых не существуют на основном сервере и которые имеют

            // если id_входящей точки не существует в этой базе
                // если external_use=0, то ничего не делать
                // если external_use=1, то создавать здесь эту точку (активной создаю)
            // иначе (если id_входящей точки существует в этой базе)
                // если external_use=0, то обновляю данные и точку деактивирую
                // если external_use=1, то обновляю данные и смотрю чтобы точка результирующая была активна

            $exist_yandex_points = YandexPoint::find()->all();
            $aExistYandexPoints = [];
            foreach($exist_yandex_points as $exist_yandex_point) {
                $aExistYandexPoints[$exist_yandex_point->main_server_id] = $exist_yandex_point;
            }

            if(count($mainServerYandexPoints) > 0) {
                foreach ($mainServerYandexPoints as $mainServerYandexPoint) {

                    if (isset($aExistYandexPoints[$mainServerYandexPoint['id']])) {// если id_входящей точки существует в текущей базе

                        $yandex_point = $aExistYandexPoints[$mainServerYandexPoint['id']];
                        if ($mainServerYandexPoint['external_use'] == 1) {// обновляю данные текущей точки и активирую ее если не активна

                            if (
                                $yandex_point->active != true
                                || $yandex_point->name != $mainServerYandexPoint['name']
                                || $yandex_point->description != $mainServerYandexPoint['description']
                                || $yandex_point->lat != $mainServerYandexPoint['lat']
                                || $yandex_point->long != $mainServerYandexPoint['long']
                                || $yandex_point->critical_point != $mainServerYandexPoint['critical_point']
                                || $yandex_point->popular_departure_point != $mainServerYandexPoint['popular_departure_point']
                                || $yandex_point->popular_arrival_point != $mainServerYandexPoint['popular_arrival_point']
                                || $yandex_point->point_of_arrival != $mainServerYandexPoint['point_of_arrival']
                                || $yandex_point->super_tariff_used != $mainServerYandexPoint['super_tariff_used']
                                || $yandex_point->alias != $mainServerYandexPoint['alias']
                                || $yandex_point->time_to_get_together_short != $mainServerYandexPoint['time_to_get_together_short']
                                || $yandex_point->time_to_get_together_long != $mainServerYandexPoint['time_to_get_together_long']
                            ) {
                                $yandex_point->active = true;
                                $yandex_point->name = $mainServerYandexPoint['name'];
                                $yandex_point->description = $mainServerYandexPoint['description'];
                                $yandex_point->lat = $mainServerYandexPoint['lat'];
                                $yandex_point->long = $mainServerYandexPoint['long'];
                                $yandex_point->critical_point = $mainServerYandexPoint['critical_point'];
                                $yandex_point->popular_departure_point = $mainServerYandexPoint['popular_departure_point'];
                                $yandex_point->popular_arrival_point = $mainServerYandexPoint['popular_arrival_point'];
                                $yandex_point->point_of_arrival = $mainServerYandexPoint['point_of_arrival'];
                                $yandex_point->super_tariff_used = $mainServerYandexPoint['super_tariff_used'];
                                $yandex_point->alias = $mainServerYandexPoint['alias'];
                                $yandex_point->time_to_get_together_short = $mainServerYandexPoint['time_to_get_together_short'];
                                $yandex_point->time_to_get_together_long = $mainServerYandexPoint['time_to_get_together_long'];

                                if (!$yandex_point->save(false)) {
                                    throw new ForbiddenHttpException('Не удалось пересохранить яндекс-точку');
                                } else {
                                    $activate_update_yandex_points_count++;
                                }
                            }

                        } else {// обновляю данные текущей точки и деактивирую ее

                            if (
                                $yandex_point->active == true
                                || $yandex_point->name != $mainServerYandexPoint['name']
                                || $yandex_point->description != $mainServerYandexPoint['description']
                                || $yandex_point->lat != $mainServerYandexPoint['lat']
                                || $yandex_point->long != $mainServerYandexPoint['long']
                                || $yandex_point->critical_point != $mainServerYandexPoint['critical_point']
                                || $yandex_point->popular_departure_point != $mainServerYandexPoint['popular_departure_point']
                                || $yandex_point->popular_arrival_point != $mainServerYandexPoint['popular_arrival_point']
                                || $yandex_point->point_of_arrival != $mainServerYandexPoint['point_of_arrival']
                                || $yandex_point->super_tariff_used != $mainServerYandexPoint['super_tariff_used']
                                || $yandex_point->alias != $mainServerYandexPoint['alias']
                                || $yandex_point->time_to_get_together_short != $mainServerYandexPoint['time_to_get_together_short']
                                || $yandex_point->time_to_get_together_long != $mainServerYandexPoint['time_to_get_together_long']
                            ) {
                                $yandex_point->active = false;
                                $yandex_point->city_id = isset($aCities[$mainServerYandexPoint['city_name']]) ? $aCities[$mainServerYandexPoint['city_name']] : '';
                                $yandex_point->name = $mainServerYandexPoint['name'];
                                $yandex_point->description = $mainServerYandexPoint['description'];
                                $yandex_point->lat = $mainServerYandexPoint['lat'];
                                $yandex_point->long = $mainServerYandexPoint['long'];
                                $yandex_point->critical_point = $mainServerYandexPoint['critical_point'];
                                $yandex_point->popular_departure_point = $mainServerYandexPoint['popular_departure_point'];
                                $yandex_point->popular_arrival_point = $mainServerYandexPoint['popular_arrival_point'];
                                $yandex_point->point_of_arrival = $mainServerYandexPoint['point_of_arrival'];
                                $yandex_point->super_tariff_used = $mainServerYandexPoint['super_tariff_used'];
                                $yandex_point->alias = $mainServerYandexPoint['alias'];
                                $yandex_point->time_to_get_together_short = $mainServerYandexPoint['time_to_get_together_short'];
                                $yandex_point->time_to_get_together_long = $mainServerYandexPoint['time_to_get_together_long'];

                                if (!$yandex_point->save(false)) {
                                    throw new ForbiddenHttpException('Не удалось пересохранить яндекс-точку');
                                } else {
                                    $deactivate_yandex_points_count++;
                                }
                            }
                        }


                    } else {// если id_входящей точки не существует в этой базе

                        if ($mainServerYandexPoint['external_use'] == 1) { // создаю активную точку по данным с основного сервера

                            $yandex_point = new YandexPoint();
                            $yandex_point->active = true;
                            $yandex_point->main_server_id = $mainServerYandexPoint['id'];
                            $yandex_point->city_id = isset($aCities[$mainServerYandexPoint['city_name']]) ? $aCities[$mainServerYandexPoint['city_name']] : '';
                            $yandex_point->name = $mainServerYandexPoint['name'];
                            $yandex_point->description = $mainServerYandexPoint['description'];
                            $yandex_point->lat = $mainServerYandexPoint['lat'];
                            $yandex_point->long = $mainServerYandexPoint['long'];
                            $yandex_point->critical_point = $mainServerYandexPoint['critical_point'];
                            $yandex_point->popular_departure_point = $mainServerYandexPoint['popular_departure_point'];
                            $yandex_point->popular_arrival_point = $mainServerYandexPoint['popular_arrival_point'];
                            $yandex_point->point_of_arrival = $mainServerYandexPoint['point_of_arrival'];
                            $yandex_point->super_tariff_used = $mainServerYandexPoint['super_tariff_used'];
                            $yandex_point->alias = $mainServerYandexPoint['alias'];
                            $yandex_point->time_to_get_together_short = $mainServerYandexPoint['time_to_get_together_short'];
                            $yandex_point->time_to_get_together_long = $mainServerYandexPoint['time_to_get_together_long'];

                            if (!$yandex_point->save(false)) {
                                throw new ForbiddenHttpException('Не удалось создать яндекс-точку');
                            } else {
                                $created_yandex_points_count++;
                            }

                        } else { // ничего не делаю

                        }
                    }
                }
            }

            echo "создано точек: $created_yandex_points_count шт. \n";
            echo "деактивировано точек: $deactivate_yandex_points_count шт. \n";
            echo "активировано или обновлено точек: $activate_update_yandex_points_count шт. \n";


            // пошлем обратно ответ на основной сервер со списком id записанных клиентов, чтобы там была установлена дата синхронизации
            if(count($mainServerYandexPoints) > 0) {
                $request_2 = new Client();
                $response = $request_2->createRequest()
                    ->setMethod('post')
                    ->setUrl(Yii::$app->params['mainServerUrl'] . 'yandex-point/set-sync-to-yandex-points?ids=' . implode(',', ArrayHelper::map($mainServerYandexPoints, 'id', 'id')))
                    ->setHeaders(['Authorization' => 'SecretKey ' . MainServerController::$secretKey])
                    ->send();

                if ($response->statusCode == 200) {
                    echo "успешно завершено\n";
                } else {
                    echo "Пришел ответ на запрос установки дат синхронизации со статусом " . $response->statusCode . "\n";
                    exit;
                }
            }


        }else {
            echo "Пришел ответ на запрос получения клиентов со статусом ".$response->statusCode."\n";
            exit;
        }
    }

    // php yii main-server/update-tariffs
    public function actionUpdateTariffs() {

        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'tariff/get-tariffs')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {
            $data = $response->data;


            if(count($data['tariffs']) > 0) {

                $aTariffsMainServerId = [];
                $new_count = 0;
                $old_count = 0;
                foreach ($data['tariffs'] as $aTariff) {

                    $tariff = Tariff::find()->where(['main_server_id' => $aTariff['id']])->one();
                    if($tariff == null) {
                        $new_count++;
                        $tariff = new Tariff();
                        $tariff->main_server_id = $aTariff['id'];
                    }else {
                        $old_count++;
                    }

                    $tariff->start_date = $aTariff['start_date'];
                    $tariff->commercial = $aTariff['commercial'];

                    $tariff->unprepayment_common_price = $aTariff['unprepayment_common_price'];
                    $tariff->unprepayment_student_price = $aTariff['unprepayment_student_price'];
                    $tariff->unprepayment_baby_price = $aTariff['unprepayment_baby_price'];
                    $tariff->unprepayment_aero_price = $aTariff['unprepayment_aero_price'];
                    $tariff->unprepayment_parcel_price = $aTariff['unprepayment_parcel_price'];
                    $tariff->unprepayment_loyal_price = $aTariff['unprepayment_loyal_price'];
                    $tariff->unprepayment_reservation_cost = $aTariff['unprepayment_reservation_cost'];

                    $tariff->prepayment_common_price = $aTariff['prepayment_common_price'];
                    $tariff->prepayment_student_price = $aTariff['prepayment_student_price'];
                    $tariff->prepayment_baby_price = $aTariff['prepayment_baby_price'];
                    $tariff->prepayment_aero_price = $aTariff['prepayment_aero_price'];
                    $tariff->prepayment_parcel_price = $aTariff['prepayment_parcel_price'];
                    $tariff->prepayment_loyal_price = $aTariff['prepayment_loyal_price'];
                    $tariff->prepayment_reservation_cost = $aTariff['prepayment_reservation_cost'];

                    $tariff->superprepayment_common_price = $aTariff['superprepayment_common_price'];
                    $tariff->superprepayment_student_price = $aTariff['superprepayment_student_price'];
                    $tariff->superprepayment_baby_price = $aTariff['superprepayment_baby_price'];
                    $tariff->superprepayment_aero_price = $aTariff['superprepayment_aero_price'];
                    $tariff->superprepayment_parcel_price = $aTariff['superprepayment_parcel_price'];
                    $tariff->superprepayment_loyal_price = $aTariff['superprepayment_loyal_price'];
                    $tariff->superprepayment_reservation_cost = $aTariff['superprepayment_reservation_cost'];

                    $tariff->save(false);

                    $aTariffsMainServerId[$tariff->main_server_id] = $tariff->main_server_id;
                }

                echo "создано тарифов: $new_count шт. \n";
                echo "изменено тарифов: $old_count шт. \n";


                // пошлем обратно ответ на основной сервер со списком id тарифов
                if(count($aTariffsMainServerId) > 0) {

                    $request_2 = new Client();
                    $response = $request_2->createRequest()
                        ->setMethod('post')
                        ->setUrl(Yii::$app->params['mainServerUrl'] . 'tariff/set-sync-to-tariffs?ids=' . implode(',', $aTariffsMainServerId))
                        ->setHeaders(['Authorization' => 'SecretKey ' . MainServerController::$secretKey])
                        ->send();

                    if ($response->statusCode == 200) {
                        echo "успешно завершено\n";
                    } else {
                        echo "Пришел ответ на запрос установки дат синхронизации со статусом " . $response->statusCode . "\n";
                        exit;
                    }
                }


            }else {
                echo "нечего копировать \n";
            }






        }else {
            echo "Пришел ответ на запрос получения тарифов со статусом ".$response->statusCode."\n";
            exit;
        }
    }

    // php yii main-server/set-accept-push?push_id=123 - вызывается из /modules/api/actions/push/AcceptAction.php
    public static function actionSetAcceptPush($push_id) {

        $push = Push::find()->where(['id' => $push_id])->one();
        if($push == null) {
            throw new ErrorException('Пуш не найден');
        }

        $request_1 = new Client();
        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'order/set-push-accept?clientext_id='.$push->client_ext_id.'&accept_time='.$push->confirm_time_at)
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {

            $push->setField('sync_answer_time_at', time());

        }else {
            echo "Пришел ответ на запрос получения рейсов со статусом ".$response->statusCode."\n";
            exit;
        }
    }

    // php yii main-server/set-reject-push?push_id=123 - вызывается из /modules/api/actions/push/AcceptAction.php
    public static function actionSetRejectPush($push_id) {

        $push = Push::find()->where(['id' => $push_id])->one();
        if($push == null) {
            throw new ErrorException('Пуш не найден');
        }

        $request_1 = new Client();
        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'order/set-push-reject?clientext_id='.$push->client_ext_id.'&reject_time='.$push->reject_time_at)
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {

            $push->setField('sync_answer_time_at', time());

        }else {
            echo "Пришел ответ на запрос получения рейсов со статусом ".$response->statusCode."\n";
            exit;
        }
    }


    /*
     * Синхронизация настроек с диспетчерским(основным) сайтов
     *
     * php yii main-server/get-not-sync-setting
     */
    public function actionGetNotSyncSetting()
    {
        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'setting/get-not-sync-setting')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {

            $aSetting = $response->data;
            if(count($aSetting) > 0) {

                $setting = Setting::find()->where(['id' => 1])->one();
                $setting->setField('count_hours_before_trip_to_cancel_order', $aSetting['count_hours_before_trip_to_cancel_order']);

                // пошлем обратно ответ на основной сервер чтобы там была установлена дата синхронизации
                $request_2 = new Client();
                $response = $request_2->createRequest()
                    ->setMethod('post')
                    ->setUrl(Yii::$app->params['mainServerUrl'].'setting/set-sync-to-setting')
                    ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
                    ->send();

                if ($response->statusCode == 200) {
                    echo "успешно завершено\n";
                }else {
                    echo "Пришел ответ на запрос установки дат синхронизации со статусом ".$response->statusCode."\n";
                    exit;
                }

            }else {
                echo "нечего записывать \n";
            }

        }else {
            echo "Пришел ответ на запрос со статусом ".$response->statusCode."\n";
            exit;
        }
    }


    // выкачка изменений по городам с основного сервера
    public function actionUpdateCities() {

        $request_1 = new Client(); // это клиент запроса, а не Клиент-человек

        $response = $request_1->createRequest()
            ->setMethod('post')
            ->setUrl(Yii::$app->params['mainServerUrl'].'city/get-not-sync-cities')
            ->setHeaders(['Authorization' => 'SecretKey '.MainServerController::$secretKey])
            ->send();

        if ($response->statusCode == 200) {

            $aCities = $response->data;
            if(count($aCities) > 0) {
                foreach($aCities as $aCity) {

                    $city = ClientExt::find()->where(['id' => $aCity['id']])->one();

                    $city->name = $aCity['name'];
                    $city->extended_external_use = $aCity['extended_external_use'];
                    $city->center_lat = $aCity['center_lat'];
                    $city->center_long = $aCity['center_long'];
                    $city->map_scale = $aCity['map_scale'];
                    $city->search_scale = $aCity['search_scale'];
                    $city->point_focusing_scale = $aCity['point_focusing_scale'];
                    $city->all_points_show_scale = $aCity['all_points_show_scale'];

                    if(!$city->save(false)) {
                        throw new ErrorException('Не удалось сохранить город');
                    }
                }


                // пошлем обратно ответ на основной сервер со списком id записанных клиентов, чтобы там была установлена дата синхронизации
                $request_2 = new Client();
                $response = $request_2->createRequest()
                    ->setMethod('post')
                    ->setUrl(Yii::$app->params['mainServerUrl'] . 'city/set-sync-to-cities?ids=' . implode(',', ArrayHelper::map($aCities, 'id', 'id')))
                    ->setHeaders(['Authorization' => 'SecretKey ' . MainServerController::$secretKey])
                    ->send();

                if ($response->statusCode == 200) {
                    echo "успешно завершено\n";
                } else {
                    echo "Пришел ответ на запрос установки дат синхронизации со статусом " . $response->statusCode . "\n";
                    exit;
                }
            }

        }else {
            echo "Пришел ответ на запрос получения городов со статусом ".$response->statusCode."\n";
            exit;
        }
    }
}
