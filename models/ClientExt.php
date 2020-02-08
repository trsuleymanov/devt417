<?php

namespace app\models;

use app\components\Helper;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "client_ext".
 *
 * @property int $id
 * @property int $status Статус заказа
 * @property int $user_id Пользователь
 * @property string $direction_id Направление
 * @property string $data Дата
 * @property string $time Время
 * @property int $created_at Время создания
 * @property int $updated_at Время изменения
 */
class ClientExt extends \yii\db\ActiveRecord
{
//    public static $min_places_count = 0;
//    public static $max_places_count = 8;

//    public static $place_full_price = 500;
//    public static $standart_trip_place_discount = 100;
//    public static $commercial_trip_place_extra_charge = 50;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_ext';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['direction_id', 'data', 'time', 'yandex_point_from_id', 'city_from_id', 'city_to_id', 'time', 'places_count', 'last_name'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'sync_date', 'status_setting_time', 'time_confirm',
                'places_count', 'student_count', 'child_count', 'yandex_point_from_id', 'yandex_point_to_id', 'trip_id', 'is_paid', 'payment_in_process',
                'suitcase_count', 'bag_count', 'prize_trip_count',
                'cancellation_click_time', 'cancellation_clicker_id', 'paid_time'], 'integer'],

            [['direction_id', 'trip_name',
                // 'street_from', 'point_from', 'street_to', 'point_to',
                'transport_model', 'transport_color', 'email'], 'string', 'max' => 50],
            [['status', 'transport_car_reg', 'phone'], 'string', 'max' => 30],
            [['last_name'], 'string', 'min' => 2, 'max' => 30, 'skipOnEmpty' => false],
            [['first_name'], 'string', 'min' => 2, 'max' => 60, 'skipOnEmpty' => true],


            //[['fio'], 'string', 'max' => 100],
            ['access_code', 'string', 'min' => 32, 'max' => 32],
            [['time'], 'string', 'min' => 5, 'max' => 7],
            [['time_air_train_arrival', 'time_air_train_departure'], 'string', 'max' => 5],
            ['phone', 'checkPhone', 'skipOnEmpty' => false],
            [['friend_code'], 'checkFriendCode'],
            [['places_count'], 'checkPlacesCount'],
            // ['fio', 'checkFio', 'skipOnEmpty' => false],
            ['email', 'email'],
            ['city_from_id', 'checkCityFrom', 'skipOnEmpty' => false],
            ['city_to_id', 'checkCityTo', 'skipOnEmpty' => false],

            [['yandex_point_from_name', 'yandex_point_to_name', 'additional_wishes'], 'string', 'max' => 255],
            [['yandex_point_from_lat', 'yandex_point_from_long', 'yandex_point_to_lat', 'yandex_point_to_long'], 'number'],
            [['is_mobile', 'is_not_places'], 'boolean'],
            [['main_server_order_id', 'price', 'paid_summ',
                'accrual_cash_back', 'penalty_cash_back', 'used_cash_back',
                'discount', 'source_type', 'city_from_id', 'city_to_id', 'but_checkout', //'gen',
                'payment_source'], 'safe'],
        ];
    }

    public function checkPhone($attribute)
    {
        // +7 (123) 432 42 25
        if(!Helper::isValidWebMobile($this->$attribute)) {
            $this->addError($attribute, 'Телефон должен быть в формате +7 (---) --- -- --');
        }
//        else {
//
//            // проверяю что у текущего телефона нет дублей
//            $phone = Helper::convertWebToDBMobile($this->$attribute);
//            $user = User::find()->where(['phone' => $phone])->one();
//
//
//            if($user != null) {
//                if(Yii::$app->user->identity == null) {
//                    $this->addError($attribute, 'Пользователь с таким номером уже зарегистрирован, авторизуйтесь пожалуйста');
//                }elseif($user->id != Yii::$app->user->identity->getId()) {
//                    $this->addError($attribute, 'Пользователь с таким номером уже зарегистрирован, авторизуйтесь пожалуйста');
//                }
//            }
//
//            return true;
//        }
    }

    public function checkPlacesCount($attribute, $params) {

        if($this->places_count <= 0) {
            $this->addError($attribute, 'Необходимо заполнить количество пассажиров');
        }
    }

    public function checkCityFrom($attribute, $params) {

        if(!in_array($this->city_from_id, [1, 2])) {
            $this->addError($attribute, 'Необходимо заполнить город отправления');
        }

        if($this->city_from_id == 1) {
            $this->city_to_id = 2;
        }elseif($this->city_from_id == 2) {
            $this->city_to_id = 1;
        }
    }

    public function checkCityTo($attribute, $params) {
        if(!in_array($this->city_to_id, [1,2])) {
            $this->addError($attribute, 'Необходимо заполнить город прибытия');
        }
    }

//    public function checkFio($attribute, $params) {
//
//        $this->fio = trim($this->fio);
//        if(empty($this->fio)) {
//            $this->addError($attribute, 'Необходимо заполнить "Имя Фамилия"');
//            return false;
//        }
//
//        $aNames = explode(' ', $this->fio);
//        if(count($aNames) == 1) {
//            $this->addError($attribute, 'Необходимо заполнить Имя и Фамилию');
//            return false;
//        }
//
//        if(count($aNames) > 1) {
//            foreach ($aNames as $name) {
//                $name = trim($name);
//                if(strlen($name) < 3) {
//                    $this->addError($attribute, 'Имя и Фамилия должны содержать больше 2-х символов');
//                    return false;
//                }
//            }
//        }
//
//        return true;
//    }

    public function checkFriendCode($attribute, $params)
    {
        if(!empty($this->friend_code)) {
            if(strlen($this->friend_code) != 6) {
                $this->addError($attribute, 'Длина кода должна составлять 6 символов');
            }else {
                $friend_user = User::find()->where(['code_for_friends' => $this->friend_code])->one();
                if($friend_user == null) {
                    $this->addError($attribute, 'Такой код не существует');
                }
            }
        }

        return true;
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['first_form'] = [
            'city_from_id',
            'city_to_id',
            'data',
            'time',
            'places_count',
            'student_count',
            'child_count',
            'user_id'
        ];

        $scenarios['second_form'] = [
            'trip_id',
            'yandex_point_from_id',
            'yandex_point_to_id',
            'time_air_train_arrival',
            'time_air_train_departure',
            'suitcase_count', 'bag_count',
            'places_count', 'student_count', 'child_count', // +
            // 'price', // +
            'user_id',
            'additional_wishes'
        ];


        $scenarios['third_form'] = [
            'phone',
            'email',
            // 'fio',
            'last_name',
            'first_name',
            'places_count', 'student_count', 'child_count', // +
            //'gen',
            'user_id'
        ];

        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_type' => 'Источник создания заказа',
            'is_mobile' => 'Заявка создана в приложении',
            'main_server_order_id' => 'id заказа на основном сервере',
            'status' => 'Статус',
            'status_setting_time' => 'Время установки статуса',
            'cancellation_click_time' => 'Время отмены',
            'cancellation_clicker_id' => 'Пользователь совершивший отмену',
            'user_id' => 'Пользователь',
            // 'fio' => 'ФИО',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя (иногда это: имя + отчество)',
            'phone' => 'Телефон',
            'email' => 'Электронная почта',
            //'gen' => 'Пол',
            'direction_id' => 'Направление',
            'data' => 'Дата',
            'time' => 'Время',
            'time_confirm' => 'ВРПТ (Время подтверждения)',
            'trip_id' => 'Рейс',
            'trip_name' => 'Название рейса',

            //'street_from' => 'Улица откуда',
            //'point_from' => 'Точка откуда',
            //'street_to' => 'Улица куда',
            //'point_to' => 'Точка куда',
            'city_from_id' => 'город Отправки',
            'city_to_id' => 'город Прибытия',

            'yandex_point_from_id' => 'id яндекс-точки откуда',
            'yandex_point_from_name' => 'Яндекс-точка откуда',
            'yandex_point_from_lat' => 'Широта яндекс-точки откуда',
            'yandex_point_from_long' => 'Долгота яндекс-точки откуда',
            'yandex_point_to_id' => 'id яндекс-точки куда',
            'yandex_point_to_name' => 'Яндекс-точка куда',
            'yandex_point_to_lat' => 'Широта яндекс-точки куда',
            'yandex_point_to_long' => 'Долгота яндекс-точки куда',
            'time_air_train_arrival' => 'Время прибытия поезда / посадки самолета',
            'time_air_train_departure' => 'Время отпр. поезда / рег-ция авиарейса',

            'places_count' => 'Количество мест всего',
            'student_count' => 'Количество мест студентов',
            'child_count' => 'Количество детских мест',
            'is_not_places' => 'Без места',
            'suitcase_count' => 'Количество больших чемоданов',
            'bag_count' => 'Количество ручной клади',
            'prize_trip_count' => 'Количество призовых поездок',
            'price' => 'Итоговая цена',
            'paid_summ' => 'Оплачено',
            'paid_time' => 'Время оплаты',
            'payment_in_process' => 'Платеж обрабатывается',
            'payment_source' => 'Источник оплаты',
            'is_paid' => 'Заказ оплачен (да/нет)',
            'discount' => 'Скидка',
            'accrual_cash_back' => 'Начисление кэш-бэка',
            'penalty_cash_back' => 'Использованный кэш-бэк для оплаты заказа',
            'used_cash_back' => 'Списанный кэш-бэк как штраф',
            'but_checkout' => 'Кнопка завершения создания заказа', // Оплатить сейчас или Бронировать
            'additional_wishes' => 'Дополнительные пожелания',

            'transport_car_reg' => 'Гос. номер т/с',
            'transport_model' => 'Марка т/с',
            'transport_color' => 'Цвет т/с',

            'friend_code' => 'Код переданный от друга',
            'access_code' => 'Уникальный код доступа к заказу',

            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
            'sync_date' => 'Дата выгрузки основным сервером текущей заявки'
        ];
    }


    public function beforeValidate()
    {
        if(isset($this->data) && preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/i', $this->data)) {
            $this->data = strtotime($this->data);   // convent '07.11.2016' to unixtime
        }

        if(strlen($this->time) > 5) {
            $this->time = str_replace( ' ', '', $this->time);
        }

        if(!empty($this->yandex_point_to_id) && (empty($this->yandex_point_to_name) || empty($this->yandex_point_to_lat) || empty($this->yandex_point_to_long))) {
            $yandex_point_to = $this->yandexPointTo;
            $this->yandex_point_to_name = $yandex_point_to->name;
            $this->yandex_point_to_lat = $yandex_point_to->lat;
            $this->yandex_point_to_long = $yandex_point_to->long;
        }

        if(!empty($this->yandex_point_from_id) && (empty($this->yandex_point_from_name) || empty($this->yandex_point_from_lat) || empty($this->yandex_point_from_long))) {
            $yandex_point_from = $this->yandexPointFrom;
            $this->yandex_point_from_name = $yandex_point_from->name;
            $this->yandex_point_from_lat = $yandex_point_from->lat;
            $this->yandex_point_from_long = $yandex_point_from->long;
        }

        if(empty($this->trip_id) && !empty($this->data) && !empty($this->time)) {

            // нужен рейс - по полю data и time находим у которого start_time > time и end_time < time
            $aClientExtTime = explode(':', $this->time);
            $client_ext_time = 3600*$aClientExtTime[0] + 60*$aClientExtTime[1];

            $day_trips = Trip::find()
                ->where(['date' => $this->data])
                ->andWhere(['direction_id' => $this->direction_id])
                ->all();
            foreach ($day_trips as $day_trip) {
                $aStartTime = explode(':', $day_trip->start_time);
                $start_time = 3600*$aStartTime[0] + 60*$aStartTime[1];

                $aEndTime = explode(':', $day_trip->end_time);
                $end_time = 3600*$aEndTime[0] + 60*$aEndTime[1];

                if($client_ext_time >= $start_time && $start_time < $end_time) {
                    $this->trip_id = $day_trip->id;
                    break;
                }
            }
        }

        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {

            $this->created_at = time();

            if(empty($this->source_type)) {
                $this->source_type = 'client_site';
            }

        }else {
            $this->updated_at = time();
        }


        // преобразуем телефон из +7 (123) 432 42 25 в +7-123-432-4225
        if(!empty($this->phone) && Helper::isValidWebMobile($this->phone)) {
            $this->phone = Helper::convertWebToDBMobile($this->phone);
        }

        if(empty($this->trip_name) && $this->trip_id > 0) {
            if($this->trip != null) {
                $this->trip_name = $this->trip->name;
            }
        }

        if(empty($this->time_confirm) && $this->trip_id > 0 && $this->yandex_point_from_id > 0) {
            if($this->trip != null && $this->yandexPointFrom != null) {
                $this->time_confirm = $this->getYandexPointTimeConfirm($this->trip, $this->yandexPointFrom);
            }
        }

        // если пользователь авторизован, то его данные беруться
        // если пользователь не авторизован, то
        //      - проверяется что для такого телефона или почты не существует пользователся
        if (!Yii::$app instanceof \yii\console\Application) {
            $user = Yii::$app->user->identity;
            if ($user == null) {
                // throw new ForbiddenHttpException('Пока временно отключена создания заказа без предварительно авторизованного пользователя');
            } else {

                // у авторизованного пользователя должна быть возможность создать заказ с данными другого человека
                /*
                if (!empty($this->phone) && $user->phone != $this->phone) {
                    throw new ForbiddenHttpException('Нельзя изменить телефон пользователя');
                }

                $update_user = false;
                if (!empty($this->email) && $user->email != $this->email) {
                    $user->email = $this->email;
                    $update_user = true;
                }

                // 'last_name', 'first_name'
                if (!empty($this->last_name) && $user->last_name != $this->last_name) {
                    $user->last_name = $this->last_name;
                    $update_user = true;
                }
                if (!empty($this->first_name) && $user->first_name != $this->first_name) {
                    $user->first_name = $this->first_name;
                    $update_user = true;
                }


                if ($update_user == true) {
                    if (!$user->save(false)) {
                        throw new ForbiddenHttpException('Не удалось обновить данные пользователя');
                    }
                }*/
            }
        }


        if($this->price > 0 && ($this->price == $this->paid_summ + $this->used_cash_back)) {
            $this->is_paid = true;
            $this->paid_time = time();
            if(empty($this->payment_source)) { // application
                $this->payment_source = 'client_site';
            }
        }else {
            $this->is_paid = false;
            $this->paid_time = NULL;
            $this->payment_source = '';
        }

        return parent::beforeSave($insert);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // если заказ был создан с установленной скидкой и ценой уменьшенной на скидку, то
        // теперь проведем транзакцию уменьшения счета пользователя на размер скидки
        if($this->discount > 0) {
            $user = $this->user;
            if ($user == null) {
                throw new ForbiddenHttpException('Пользователь не найден');
            }

            $user->subMoney($this->id, $this->discount);
        }
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getTrip()
    {
        return $this->hasOne(Trip::className(), ['id' => 'trip_id']);
    }

    public function getYandexPointFrom()
    {
        return $this->hasOne(YandexPoint::className(), ['id' => 'yandex_point_from_id']);
    }

    public function getYandexPointTo()
    {
        return $this->hasOne(YandexPoint::className(), ['id' => 'yandex_point_to_id']);
    }


    public function getCityFrom()
    {
        return $this->hasOne(City::className(), ['id' => 'city_from_id']);
    }

    public function getCityTo()
    {
        return $this->hasOne(City::className(), ['id' => 'city_to_id']);
    }


    public static function getStatuses() {

//        return [
//            'created' => 'created', // создана заявка
//            'pending_call' => 'pending_call', // заявка обработана (т.е. заказ создан), но ожидается звонок от оператора для подтверждения ВРПТ
//            'pending_send' => 'pending_send', // в ожидании отправления
//            'sended' => 'sended', // отправлен
//            'canceled' => 'canceled' // отменен
//        ];

        return [
            '' => '', // Заказ недооформлен
            'created_with_time_confirm' => 'created_with_time_confirm',
            'created_without_time_confirm' => 'created_without_time_confirm',
            'canceled_by_client' => 'canceled_by_client',
            'canceled_by_operator' => 'canceled_by_operator',
            'canceled_auto' => 'canceled_auto',
            'created_with_time_sat' => 'created_with_time_sat',
            'sended' => 'sended'
        ];
    }


    public static function getStatusesRu() {

//        return [
//            'created' => 'ЗАКАЗ ЗАРЕГИСТРИРОВАН', // создана заявка
//            'pending_call' => 'ЗАКАЗ ОБРАБОТАН, ЖДИТЕ ЗВОНКА', // заявка обработана (т.е. заказ создан), но ожидается звонок от оператора для подтверждения ВРПТ
//            'pending_send' => 'НАЗНАЧЕНО ВРЕМЯ', // в ожидании отправления
//            'sended' => 'ОТПРАВЛЕН', // отправлен
//            'canceled' => 'ОТМЕНЕН' // отменен
//        ];

        return [
            '' => 'Заказ недооформлен', // Заказ недооформлен
            'created_with_time_confirm' => 'Заказ создан и время подтверждено',
            'created_without_time_confirm' => 'Заказ создан, но время не подтверждено',
            'canceled_by_client' => 'Отменен клиентом',
            'canceled_by_operator' => 'Отменен оператором',
            'canceled_auto' => 'Отменен автоматически',
            'created_with_time_sat' => 'Заказ отправлен на посадку (водителю)',
            'sended' => 'Заказ отправлен'
        ];
    }


    public static function convertMainServerOrderStatus($main_server_order) {

        //    Статусы заказа в CRM:
        //    - создан - 0 - created
        //    - отправлен - sended
        //    - отменен - canceled

        //    Старые статусы заявки в приложении:
//            'created' => 'ЗАКАЗ ЗАРЕГИСТРИРОВАН',   ~ заявка есть, заказа нет
//            'pending_call' => 'ЗАКАЗ ОБРАБОТАН, ЖДИТЕ ЗВОНКА',  ~ order.[status=created] + order.time_confirm = NULL
//            'pending_send' => 'НАЗНАЧЕНО ВРЕМЯ', // ОЖИДАЕТ ОТПРАВКИ ~ order.[status=created] + order.time_confirm > 0
//            'sended' => 'ОТПРАВЛЕН',   ~ order.[status=sended]
//            'canceled' => 'ОТМЕНЕН'   ~ order.[status=canceled]

        // Новые статусы на клиентском сайте
//        '',
//        'created_with_time_confirm',
//        'created_without_time_confirm',
//        'canceled_by_client',
//        'canceled_by_operator',
//        'canceled_auto',
//        'created_with_time_sat',
//        'sended'

        if($main_server_order['status_code'] == 'created' && !empty($main_server_order['time_sat'])) {
            return 'created_with_time_sat';
        }elseif($main_server_order['status_code'] == 'created' && !empty($main_server_order['time_confirm'])) {
            return 'created_with_time_confirm';
        }elseif($main_server_order['status_code'] == 'created' && empty($main_server_order['time_confirm'])) {
            return 'created_without_time_confirm';
        }elseif($main_server_order['status_code'] == 'canceled' && $main_server_order['canceled_by'] == 'client') {
            return 'canceled_by_client';
        }elseif($main_server_order['status_code'] == 'canceled' && $main_server_order['canceled_by'] == 'operator') {
            return 'canceled_by_operator';
        }elseif($main_server_order['status_code'] == 'canceled' && $main_server_order['canceled_by'] == 'auto') {
            return 'canceled_auto';
        }elseif($main_server_order['status_code'] == 'sent') {
            return 'sended';
        }else {
            return '';
        }

    }

    /**
     * @param $status
     * @throws ErrorException
     * @throws ForbiddenHttpException
     */
    public function setStatus($status, $with_check = true) {

        $aStatuses = ClientExt::getStatuses();
        if(!in_array($status, $aStatuses)) {
            throw new ForbiddenHttpException('Не найден статус '.$status);
        }


        if(in_array($status, ['canceled_by_client', 'canceled_by_operator', 'canceled_auto'])) {

            $setting = Setting::find()->where(['id' => 1])->one();

            $trip = $this->trip;
            //if($trip == null) {
                // throw new ErrorException('У заказа '.$this->id.' не найден рейс');
            //}

            // если текущее время отмены заказа больше чем время (первая точка рейча минут часы $setting->count_hours_before_trip_to_cancel_order),
            // то отмена заказа запрещена
            if($trip != null) {
                if (in_array($status, ['canceled_by_client']) && !empty($this->status) && $with_check == true && time() > $trip->getStartTimeUnixtime() - 3600 * intval($setting->count_hours_before_trip_to_cancel_order)) {
                    throw new ForbiddenHttpException('Запрещено отменять заказ ' . $this->id . ' менее чем за ' . $setting->count_hours_before_trip_to_cancel_order . ' часов до рейса (id=' . $this->id . ')');
                } else {
                    // если заказ оплачен/частично оплачен, то проводим возврат
                    if ($this->paid_summ > 0) {
                        $this->returnPayment();
                    }
                }
            }

            if($status == 'canceled_by_client') {
                $this->cancellation_click_time = time();
                $this->cancellation_clicker_id = Yii::$app->getUser()->getId();
            }

        }elseif($status == 'sended') {// если заявка-заказ перешел в статус "отправлена", то при наличии кода друга начисляем другу деньгу
            if(!empty($this->friend_code)) {
                $friend_user = User::find()->where(['code_for_friends' => $this->friend_code])->one();
                if($friend_user == null) {
                    throw new ForbiddenHttpException('Друг не найден');
                }

                $friend_user->addMoneyForFriend($this->id);
            }
        }

        $this->status = $status;
        $this->status_setting_time = time();
        $this->sync_date = NULL;

        if(!$this->save(false)) {
            throw new ErrorException('Не удалось сохранить заказ');
        }
    }


    public function getPrizeTripCount()
    {
//        if($this->use_fix_price == true) {
//            return 0;
//        }

        if($this->trip != null && $this->trip->commercial == 1) {
            return 0;
        }

//        if($this->informerOffice != null && $this->informerOffice->cashless_payment == 1) {
//            return 0;
//        }

        $user = $this->user;

        if($user == null) {

            $sended_orders_places_count = 0;
            $sended_prize_trip_count = 0;
            $penalty = 0;

        }else {

            $sended_orders_places_count = $user->current_year_sended_places;
            $sended_prize_trip_count = $user->current_year_sended_prize_places;
            $penalty = $user->current_year_penalty;

            // к количеству отправленных призовых поездок добавим поездки из "новых" заказов (но количество отправленных заказов оставим без изменения)
            $created_orders_query = ClientExt::find()
                ->where([
                    'user_id' => $user->id,
                    //'status' => ['created', 'pending_call']
                    'status' => ['created_with_time_confirm', 'created_without_time_confirm', 'created_with_time_sat'] // все заказы кроме отправленных и кроме отмененных
                ]);
            if($this->id > 0) {
                $created_orders_query = $created_orders_query->andWhere(['!=', 'id', $this->id]);
            }
            $created_orders = $created_orders_query->all();


            //echo "created_orders:<pre>"; print_r($created_orders); echo "</pre>";

            if(count($created_orders) > 0) {
                foreach($created_orders as $order) {

                    if($order->source_type == "client_site" && $order->is_paid == true) {
                        continue;
                    }else {
                        $sended_prize_trip_count = $sended_prize_trip_count + $order->prize_trip_count;
                    }
                }
            }
        }


        $P = intval($this->places_count); // количество мест в текущем заказе

        if($this->is_not_places == 1)  // если отправляется посылка, то призовой поездки не предоставляется
            return 0;
        else {

            // echo "<br />sended_orders_places_count=$sended_orders_places_count sended_prize_trip_count=$sended_prize_trip_count penalty=$penalty<br />";

            if($P < 5) {
                $prize_count = floor(($sended_orders_places_count - 5*($sended_prize_trip_count + $penalty) + $P)/5);
                if($prize_count > 1) {
                    $prize_count = 1;
                }
                if($prize_count < 0) { // защита от случает "страшных" данных в базе
                    $prize_count = 0;
                }
            }else {
                $prize_count = floor($P/5); // считаем призовые только на основе текущего заказа без привязки к прошлым поездкам
            }


            return $prize_count;
        }
    }

    public function getCalculatePrice($type_price = 'unprepayment', $places_count = 0) {

        // $type_price: unprepayment, prepayment[prepayment или superprepayment]

        //echo "this:<pre>"; print_r($this); echo "</pre>";

        if($this->yandexPointFrom == null) {
            return 0;
        }

        $trip = $this->trip;
        if($trip == null) {
            return 0;
        }

        $tariff = $trip->tariff;
        if ($tariff == null) {
            return 0;
        }

        // echo "tariff:<pre>"; print_r($tariff); echo "<pre>";

        if($places_count > 0) {
            $P = $places_count;
        }else {
            $P = intval($this->places_count); // количество мест в текущем заказе
        }
        $S = intval($this->student_count); // количество студентов в текущем заказе
        $B = intval($this->child_count); // количество детей в текущем заказе

        $prize_count = $this->getPrizeTripCount(); // количество призовых поездок в текущем заказе
        //echo "prize_count=$prize_count P=$P S=$S B=$B <br />";

        if($type_price == 'unprepayment') {
            $T_RESERV = $tariff->unprepayment_reservation_cost; // стоимость бронирования
            $T_COMMON = $tariff->unprepayment_common_price + $T_RESERV;  // цена по общему тарифу
            $T_STUDENT = $tariff->unprepayment_student_price + $T_RESERV; // студенческий тариф
            $T_BABY = $tariff->unprepayment_baby_price + $T_RESERV;    // детский тариф
            $T_AERO = $tariff->unprepayment_aero_price + $T_RESERV;    // тариф аэропорт
            $T_LOYAL = $tariff->unprepayment_loyal_price + $T_RESERV;   // тариф призовой поездки
            $T_PARCEL = $tariff->unprepayment_parcel_price + $T_RESERV; // тариф отправки посылки (без места)
        }else {
            if($this->yandexPointFrom->super_tariff_used == true) {
                $T_RESERV = $tariff->superprepayment_reservation_cost; // стоимость бронирования
                $T_COMMON = $tariff->superprepayment_common_price + $T_RESERV;  // цена по общему тарифу
                $T_STUDENT = $tariff->superprepayment_student_price + $T_RESERV; // студенческий тариф
                $T_BABY = $tariff->superprepayment_baby_price + $T_RESERV;    // детский тариф
                $T_AERO = $tariff->superprepayment_aero_price + $T_RESERV;    // тариф аэропорт
                $T_LOYAL = $tariff->superprepayment_loyal_price + $T_RESERV;   // тариф призовой поездки
                $T_PARCEL = $tariff->superprepayment_parcel_price + $T_RESERV; // тариф отправки посылки (без места)
            }else {
                $T_RESERV = $tariff->prepayment_reservation_cost; // стоимость бронирования
                $T_COMMON = $tariff->prepayment_common_price + $T_RESERV;  // цена по общему тарифу
                $T_STUDENT = $tariff->prepayment_student_price + $T_RESERV; // студенческий тариф
                $T_BABY = $tariff->prepayment_baby_price + $T_RESERV;    // детский тариф
                $T_AERO = $tariff->prepayment_aero_price + $T_RESERV;    // тариф аэропорт
                $T_LOYAL = $tariff->prepayment_loyal_price + $T_RESERV;   // тариф призовой поездки
                $T_PARCEL = $tariff->prepayment_parcel_price + $T_RESERV; // тариф отправки посылки (без места)
            }
        }

        $COST = 0;
        if ($this->is_not_places == 1) {

            $COST = $T_PARCEL;

        } elseif (
            ($this->yandexPointTo != null && $this->yandexPointTo->alias == 'airport')
            || ($this->yandexPointFrom != null && $this->yandexPointFrom->alias == 'airport')
        ) { // едут в аэропорт или из аэропорта

            $COST = ($P - $prize_count) * $T_AERO + $prize_count * $T_LOYAL;

        } else {


            // составляется массив всех цен за места (общих, студенческих, детских)
            $aPlacesPrice = [];
            $P = $P - $S - $B;
            for ($i = 0; $i < $P; $i++) {
                $aPlacesPrice[] = $T_COMMON;
            }
            for ($i = 0; $i < $S; $i++) {
                $aPlacesPrice[] = $T_STUDENT;
            }
            for ($i = 0; $i < $B; $i++) {
                $aPlacesPrice[] = $T_BABY;
            }
            sort($aPlacesPrice);

            // кол-во первых массив соответствующего кол-во призовых мест заменяется ценой $T_LOYAL
            for ($i = 0; $i < $prize_count; $i++) {
                $aPlacesPrice[$i] = $T_LOYAL;
            }

            // echo "aPlacesPrice:<pre>"; print_r($aPlacesPrice); echo "</pre>";

            // суммируются цены за места и получается общая цена заказа
            foreach ($aPlacesPrice as $placePrise) {
                $COST += $placePrise;
            }
        }

        return $COST;
    }


    /*
     * Функция возвращает цену всего заказа (заявки)
     *
     * @return float|int
     * @throws ForbiddenHttpException
     */
    public function getOldCalculatePrice() {

        // $this->time; - это время средней точки рейса
        $trip = Trip::find()
            //->where(['date' => strtotime($this->data)])
            ->where(['date' => $this->data])
            ->andWhere(['mid_time' => $this->time])
            ->one();

        $hours_minutes = explode(':', $this->time);
        //$dir_hours = (strtotime($this->data) + 3600*$hours_minutes[0] + 60*$hours_minutes[1] - time())/3600;
        $dir_hours = ($this->data + 3600*$hours_minutes[0] + 60*$hours_minutes[1] - time())/3600;

        $place_price = 0;
        if($trip != null) {
            if ($trip->commercial == 0 && $dir_hours > 7) {
                $place_price = self::$place_full_price - self::$standart_trip_place_discount;
            } elseif ($trip->commercial == 0 && $dir_hours <= 7) {
                $place_price = self::$place_full_price;
            } elseif ($trip->commercial == 1 && $dir_hours > 7) {
                $place_price = self::$place_full_price;
            } else { // commercial=1 && $dir_hours<=7
                $place_price = self::$place_full_price + self::$commercial_trip_place_extra_charge;
            }
        }else {
            $place_price = self::$place_full_price + self::$commercial_trip_place_extra_charge;
        }

        $places_count = $this->places_count;
        if($places_count == 0) {
            $places_count = 1;
        }

        $order_price = $places_count * $place_price;

        return $order_price;
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


    // функция генерирует уникальный код идентифицирующий заказ (чтобы можно было неавторизованному пользователю открыть страницу с заказом)
    public function generateAccessCode() {

        $access_code = Yii::$app->security->generateRandomString(); // 32 символа

        $client_ext = ClientExt::find()->where(['access_code' => $access_code])->one();
        if($client_ext != null) {
            return $this->generateAccessCode();
        }else {
            return $access_code;
        }
    }


    public function getTripsForChange() {

        $aTime = explode(':', $this->time);

        // дата-время в заказе
        $unixtime = $this->data + 3600 * intval($aTime[0]) + 60 * intval($aTime[1]);


        // ищем самый ближний рейс до выбранного времени
        $prev_trip = Trip::find()
            ->where(['direction_id' => $this->direction_id])
            ->andWhere(['<', 'end_time_unixtime', $unixtime])
            ->orderBy(['end_time_unixtime' => SORT_DESC])
            ->one();


        $day_trips = Trip::find()
            ->where(['direction_id' => $this->direction_id])
            ->andWhere(['date' => $this->data])
            ->all();

        $aUnixtimeDayTrips = [];
        foreach ($day_trips as $day_trip) {
            //$aDayTripTime = explode(':', $day_trip->end_time);
            //$day_trip_unixtime = $day_trip->date + 3600 * intval($aDayTripTime[0]) + 60 * intval($aDayTripTime[1]);
            //$day_trip->unixtime = $day_trip_unixtime;
            $aUnixtimeDayTrips[$day_trip->end_time_unixtime] = $day_trip;
        }

        //echo "aUnixtimeDayTrips:<pre>"; print_r($aUnixtimeDayTrips); echo "</pre>";
        ksort($aUnixtimeDayTrips);
        $aUnixtimeDayTrips2 = [];
        foreach ($aUnixtimeDayTrips as $day_trip) {
            $aUnixtimeDayTrips2[] = $day_trip;
        }

        //$prev_trip = null;
        $next_trip_1 = null;
        $next_trip_2 = null;
        foreach ($aUnixtimeDayTrips2 as $key => $day_trip) {

            if($key == 0) {

                //echo "day_trip_unixtime=".$day_trip->unixtime.' unixtime='.$unixtime;
                if($day_trip->unixtime >= $unixtime - 3599) {

                    // значит предшествующий рейс - это вчерашний рейс, а следующие 2 рейса - это первые 2 сегодняшних рейсов
                    $next_trip_1 = $aUnixtimeDayTrips2[0];
                    $next_trip_2 = $aUnixtimeDayTrips2[1];

                    /*
                    $prev_day_trips = Trip::find()
                        ->where(['direction_id' => $this->direction_id])
                        ->andWhere(['date' => $this->data - 86400])
                        ->all();

                    $PrevDayTrips = [];
                    foreach ($prev_day_trips as $prev_day_trip) {
                        $aDayTripTime = explode(':', $prev_day_trip->end_time);
                        $day_trip_unixtime = $prev_day_trip->date + 3600 * intval($aDayTripTime[0]) + 60 * intval($aDayTripTime[1]);
                        $prev_day_trip->unixtime = $day_trip_unixtime;
                        $PrevDayTrips[$prev_day_trip->unixtime] = $prev_day_trip;
                    }
                    krsort($PrevDayTrips);



                    foreach ($PrevDayTrips as $unixtime => $prev_day_trip) {
                        $prev_trip = $prev_day_trip;
                        break;
                    }*/

                    break;
                }

            }else {

                if($day_trip->unixtime >= $unixtime - 3599) {

                    // $prev_trip = $aUnixtimeDayTrips2[$key];
                    //echo "prev_trip:<pre>"; print_r($prev_trip); echo "</pre>";

                    if(isset($aUnixtimeDayTrips2[$key + 1])) {
                        $next_trip_1 = $aUnixtimeDayTrips2[$key + 1];

                        if(isset($aUnixtimeDayTrips2[$key + 2])) {
                            $next_trip_2 = $aUnixtimeDayTrips2[$key + 2];
                            break;
                        }else {

                            // ищем первый рейс следующий рейс
                            $next_day_trips = Trip::find()
                                ->where(['direction_id' => $this->direction_id])
                                ->andWhere(['date' => $this->data + 86400])
                                ->all();

                            $NextDayTrips = [];
                            foreach ($next_day_trips as $next_day_trip) {
                                $aDayTripTime = explode(':', $next_day_trip->end_time);
                                $day_trip_unixtime = $next_day_trip->date + 3600 * intval($aDayTripTime[0]) + 60 * intval($aDayTripTime[1]);
                                $next_day_trip->unixtime = $day_trip_unixtime;
                                $NextDayTrips[$next_day_trip->unixtime] = $next_day_trip;
                            }
                            ksort($NextDayTrips);

                            foreach ($NextDayTrips as $unixtime => $next_day_trip) {
                                $next_trip_2 = $next_day_trip;
                                break;
                            }
                        }


                    }else {

                        // ищем первый рейс следующий рейс
                        $next_day_trips = Trip::find()
                            ->where(['direction_id' => $this->direction_id])
                            ->andWhere(['date' => $this->data + 86400])
                            ->all();
                        $NextDayTrips = [];
                        foreach ($next_day_trips as $next_day_trip) {
                            $aDayTripTime = explode(':', $next_day_trip->end_time);
                            $day_trip_unixtime = $next_day_trip->date + 3600 * intval($aDayTripTime[0]) + 60 * intval($aDayTripTime[1]);
                            $next_day_trip->unixtime = $day_trip_unixtime;
                            $NextDayTrips[$next_day_trip->unixtime] = $next_day_trip;
                        }
                        ksort($NextDayTrips);

                        $NextDayTrips2 = [];
                        foreach ($NextDayTrips as $unixtime => $next_day_trip) {
                            $NextDayTrips2[] = $next_day_trip;
                        }

                        $next_trip_1 = $NextDayTrips2[0];
                        $next_trip_2 = $NextDayTrips2[1];
                        break;
                    }
                }
            }
        }

        if($next_trip_1 == null) { // например если желаемое время 23:00, то рейсы не будут найдены

            $next_day_trips = Trip::find()
                ->where(['direction_id' => $this->direction_id])
                ->andWhere(['date' => $this->data + 86400])
                ->all();

            $NextDayTrips = [];
            foreach ($next_day_trips as $next_day_trip) {
                $aDayTripTime = explode(':', $next_day_trip->end_time);
                $day_trip_unixtime = $next_day_trip->date + 3600 * intval($aDayTripTime[0]) + 60 * intval($aDayTripTime[1]);
                $next_day_trip->unixtime = $day_trip_unixtime;
                $NextDayTrips[$next_day_trip->unixtime] = $next_day_trip;
            }
            ksort($NextDayTrips);

            $aUnixtimeNextDayTrips = [];
            foreach ($NextDayTrips as $day_trip) {
                $aUnixtimeNextDayTrips[] = $day_trip;
            }
            if(count($aUnixtimeNextDayTrips) > 0) {
                //$prev_trip = $aUnixtimeNextDayTrips[0];
                $next_trip_1 = $aUnixtimeNextDayTrips[1];
                $next_trip_2 = $aUnixtimeNextDayTrips[2];
            }
        }

        $ResultTrips = [];
        $ResultTrips[] = $prev_trip;
        $ResultTrips[] = $next_trip_1;
        $ResultTrips[] = $next_trip_2;

        return $ResultTrips;
    }


    public static function getYandexPointTimeConfirm($trip, $yandex_point_from) {

        $aTripStart = explode(':', $trip->start_time);
        $trip_start_time_secs = 3600 * intval($aTripStart[0]) + 60 * intval($aTripStart[1]);
        $aTripEnd = explode(':', $trip->end_time);
        $trip_end_time_secs = 3600 * intval($aTripEnd[0]) + 60 * intval($aTripEnd[1]);

        $setting = Setting::find()->where(['id' => 1])->one();


        if($trip->direction_id == 1) {
            // $max_time_short_trip = Trip::$max_time_short_trip_AK;
            $max_time_short_trip = $setting->max_time_short_trip_AK;
        }else {
            // $max_time_short_trip = Trip::$max_time_short_trip_KA;
            $max_time_short_trip = $setting->max_time_short_trip_KA;
        }

        if($trip_end_time_secs - $trip_start_time_secs <= $max_time_short_trip) { // короткий рейс

            if($yandex_point_from->time_to_get_together_short === NULL) {
                return NULL;
            }

            //if(intval($yandex_point_from->time_to_get_together_short) > 0) { // значение может быть и отрицательным
                $time_confirm = $trip_end_time_secs + $trip->date - intval($yandex_point_from->time_to_get_together_short);
            //}

        }else { // длинный рейс

            if($yandex_point_from->time_to_get_together_long === NULL) {
                return NULL;
            }

            //if(intval($yandex_point_from->time_to_get_together_long) > 0) { // значение может быть и отрицательным
                $time_confirm = $trip_end_time_secs + $trip->date - intval($yandex_point_from->time_to_get_together_long);
            //}
        }

        return $time_confirm;
    }


    /**
     * Проводим возврат средств ранее оплаченных по заказу
     * @return bool
     * @throws ForbiddenHttpException
     */
    public function returnPayment() {

        if(intval($this->paid_summ) == 0) { // яндекс не проводит возвраты суммой меньше 1 рубля
            return false;
        }

        // платеж/платежи по которому заказ получил бабки
        $yandex_payments = YandexPayment::find()->where(['client_ext_id' => $this->id])->all();
        if(count($yandex_payments) == 0) {
            throw new ForbiddenHttpException('Платежи по которым можно провести возврат не найдены');
        }

        foreach ($yandex_payments as $yandex_payment) {
            $yandex_payment->returnPayment();
        }
    }

}
