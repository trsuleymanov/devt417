<?php

namespace app\controllers;

use app\models\ClientExt;
use app\models\ClientExtPassenger;
use app\models\Direction;
use app\models\Passenger;
use app\models\User;
use Codeception\Module\Cli;
use Yii;
use app\models\Trip;
use app\models\TripSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class TripController extends Controller
{
    /**
     * @inheritdoc
     */
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

    public function actionIndex($id)
    {
        $trip = Trip::find()->where(['id' => $id])->one();

        if(Yii::$app->user->isGuest) {
            $user = new User();
        }else {
            $user = Yii::$app->user->identity;
        }

        $client_ext = new ClientExt();

        return $this->render('index', [
            'trip' => $trip,
            'user' => $user,
            'client_ext' => $client_ext
        ]);
    }

    public function actionAjaxGetPassengerForm() {

        Yii::$app->response->format = 'json';

        $passenger = new Passenger();

        return [
            'html' => $this->renderPartial('passenger-form', [
                'passenger' => $passenger,
            ])
        ];
    }


    public function actionAjaxSaveTripForm($trip_id) {

        Yii::$app->response->format = 'json';

        $trip = Trip::find()->where(['id' => intval($trip_id)])->one();
        if($trip == null) {
            throw new ForbiddenHttpException('Рейс не найден');
        }

        $post = Yii::$app->request->post();

        // если пользователь авторизован, то

//        Считаю что если незарегистрированный пользователь при создании заказа ввел свою почту и телефон, то:
//        - ищеться пользователь с такой почтой. Если пользователь находиться с такой почтой, то ему переписывается телефон если изменился.
//        - также должна работать проверка чтобы не было дублирование телефонов у пользователей.
//
//        - если не находиться пользователя с такой почтой, то создается новый user с этими 2-мя полями: почтой и телефоном.
//        - также должна работать проверка чтобы не было дублирование телефонов у пользователей.
//        - в этом случае при регистрации будет не просто создаваться новый пользователь, а будет искаться пользователь с такой почтой.
//        - также должна работать проверка чтобы не было дублирование телефонов у пользователей.
//        ! телефон у клиента может меняться, почта - никогда. Значит поле телефона можно переписать.


        if($post['agreement_checkbox'] == 'false') {
            throw new ForbiddenHttpException('Вы не дали согласие на обработку данных');
        }

        //echo "post:<pre>"; print_r($post); echo "</pre>";
        if(Yii::$app->user->isGuest) {
            $user = User::find()->where(['email' => $post['User']['email']])->one();
            if($user == null) {
                $user = new User();
            }

        }else {
            $user = Yii::$app->user->identity;

            if ($user->email != $post['User']['email']) {
                throw new ForbiddenHttpException('Вы не можете переписать свою почту');
            }
        }


        $aPassengers = [];
        $user_errors = [];
        $passengers_errors = [];
        foreach($post['Passengers'] as $key => $aPostPassenger) {

            if(isset($aPostPassenger['date_of_birth'])) {
                $aPostPassenger['date_of_birth'] = strtotime($aPostPassenger['date_of_birth']);
            }

            $pas_query = Passenger::find()->where(['series_number' => $aPostPassenger['series_number']]);
            if(isset($aPostPassenger['citizenship'])) {
                $pas_query->andWhere(['citizenship' => $aPostPassenger['citizenship']]);
            }else {
                $pas_query->andWhere(['citizenship' => NULL]);
            }
//            $passenger = Passenger::find()
//                ->where(['series_number' => $aPostPassenger['series_number']])
//                ->andWhere(['citizenship' => isset($aPostPassenger['citizenship']) ? $aPostPassenger['citizenship'] : ''])
//                ->one();
            $passenger = $pas_query->one();
            if($passenger == null) {
                $passenger = new Passenger();
            }

            $aPostPassenger['Passenger'] = $aPostPassenger;
            if($passenger->load($aPostPassenger) && $passenger->validate() && $passenger->save()) {
                $aPassengers[] = $passenger;
            }else {
                $passengers_errors[$key] = $passenger->validate() ? [] : $passenger->getErrors();
            }
        }


        $user->scenario = 'create_client_ext';
        if($user->load($post) && $user->validate()) {
            // ...
        }else {
            $user_errors = $user->validate() ? [] : $user->getErrors();
        }

        $client_ext_errors = [];
        if(count($user_errors) == 0 && count($passengers_errors) == 0) {

            // сохраняю пользователя, всех пассажиров, рейс и связи рейс-пассажир
            $client_ext = new ClientExt();

            $client_ext->yandex_point_from_id = $post['ClientExt']['yandex_point_from_id'];
            $client_ext->yandex_point_from_lat = $post['ClientExt']['yandex_point_from_lat'];
            $client_ext->yandex_point_from_long = $post['ClientExt']['yandex_point_from_long'];
            $client_ext->yandex_point_from_name = $post['ClientExt']['yandex_point_from_name'];

            $client_ext->yandex_point_to_id = $post['ClientExt']['yandex_point_to_id'];
            $client_ext->yandex_point_to_lat = $post['ClientExt']['yandex_point_to_lat'];
            $client_ext->yandex_point_to_long = $post['ClientExt']['yandex_point_to_long'];
            $client_ext->yandex_point_to_name = $post['ClientExt']['yandex_point_to_name'];

            $client_ext->is_mobile = 0;
            $client_ext->status = ''; // в этот момент заказ создан условно, статус заказ должен получить только после выбора типа оплаты
            //$client_ext->status_setting_time = time();
            $client_ext->user_id = $user->id;
            $client_ext->phone = $user->phone;
            $client_ext->email = $user->email;
            $client_ext->direction = Direction::getDirections()[$trip->direction_id - 1];
            $client_ext->data = $trip->date;
            $client_ext->time = $trip->mid_time;
            $client_ext->trip_id = $trip_id;
            $client_ext->trip_name = $trip->name;
            $client_ext->places_count = count($aPassengers);

            $client_ext->price = 0;
            foreach($aPassengers as $passenger) {
                //$client_ext->price += Passenger::getTariffsPrices()[$passenger->tariff_type];
                $client_ext->price += 450;
            }

            $client_ext_errors = $client_ext->validate() ? [] : $client_ext->getErrors();
        }


        if(count($user_errors) > 0 || count($passengers_errors) > 0 || count($client_ext_errors) > 0) {
            return [
                'success' => false,
                'user_errors' => $user_errors,
                'passengers_errors' => $passengers_errors,
                'client_ext_errors' => $client_ext_errors,
                'client_ext' => $client_ext
            ];
        }else {

            if(!$user->save(false)) {
                throw new ErrorException('Не удалось сохранить пользователя');
            }

            if(!$client_ext->save()) {
                throw new ForbiddenHttpException('Не удалось создать заказ');
            }

            foreach($aPassengers as $passenger) {
                $client_ext_passenger = ClientExtPassenger::find()
                    ->where(['client_ext_id' => $client_ext->id])
                    ->andWhere(['passenger_id' => $passenger->id])
                    ->one();
                if($client_ext_passenger == null) {
                    $client_ext_passenger = new ClientExtPassenger();
                    $client_ext_passenger->client_ext_id = $client_ext->id;
                    $client_ext_passenger->passenger_id = $passenger->id;
                    if(!$client_ext_passenger->save()) {
                        throw new ForbiddenHttpException('Не удалось привязать пассажира к заказу');
                    }
                }
            }


            $client_ext->access_code = $client_ext->generateAccessCode();
            $client_ext->setField('access_code', $client_ext->access_code);

            return [
                'success' => true,
                //'client_ext_id' => $client_ext->id
                'client_ext_code' => $client_ext->access_code
            ];
        }
    }


    public function actionClientExtPayment($c){

        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

//        $trip = $client_ext->trip;
//        if($trip == null) {
//            throw new ForbiddenHttpException('Рейс не найден');
//        }

        $passengers = Passenger::find()
            ->joinWith('clientExtPassengers')
            ->andWhere(['client_ext_passenger.client_ext_id' => $client_ext->id])
            ->all();
        //echo "<pre>"; print_r($trip); echo "</pre>";



        return $this->render('client-ext-payment', [
            'client_ext' => $client_ext,
            //'trip' => $trip,
            'passengers' => $passengers
        ]);
    }

    /*
     * На эту страницу переходит яндекс после оплаты заказа
     */
    public function actionPaymentFinish($c) {

        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $trip = $client_ext->trip;
        if($trip == null) {
            throw new ForbiddenHttpException('Рейс не найден');
        }

        return $this->render('client-ext-payment-finish', [
            'client_ext' => $client_ext,
            'trip' => $trip,
        ]);
    }

    /*
    public function actionReservClientExt($c) {

        Yii::$app->response->format = 'json';

        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        if($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $client_ext->setStatus('created');

        return [
            'success' => true
        ];
    }
    */
}
