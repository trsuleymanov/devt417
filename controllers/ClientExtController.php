<?php

namespace app\controllers;

use app\models\ClientExt;
use app\models\ClientExtPassenger;
use app\models\Direction;
use app\models\Passenger;
use app\models\User;
use app\models\YandexPoint;
use Codeception\Module\Cli;
use Yii;
use app\models\Trip;
use app\models\TripSearch;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class ClientExtController extends Controller
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

    public function actionAjaxGetTimeConfirm($yandex_point_from_id, $trip_id) {

        Yii::$app->response->format = 'json';

        $trip = Trip::find()->where(['id' => $trip_id])->one();
        if($trip == null) {
            throw new ForbiddenHttpException('Рейс не найден');
        }

        //$yandex_point_from = $this->yandexPointFrom;
        $yandex_point_from = YandexPoint::find()->where(['id' => $yandex_point_from_id])->one();
        if($yandex_point_from == null) {
            throw new ForbiddenHttpException('Точка отправки не найдена');
        }

        $time_confirm = ClientExt::getYandexPointTimeConfirm($trip, $yandex_point_from);

        return [
            'time_confirm_str' => $time_confirm > 0 ? date('H:i', $time_confirm) : '',
            //'trip_start_time' => $trip->start_time
        ];
    }

    //public function actionAjaxTripsTimeConfirm($client_ext_id, $yandex_point_from_id) {
    public function actionAjaxTripsTimeConfirm($c, $yandex_point_from_id) {

        Yii::$app->response->format = 'json';

        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        $trips = $client_ext->getTripsForChange();
        // echo "trips:<pre>"; print_r($trips); echo "</pre>";

        $aTripsTimeConfirms = [];
        $yandex_point_from = YandexPoint::find()->where(['id' => $yandex_point_from_id])->one();
        foreach ($trips as $trip) {

            if($trip == null) {
                continue;
            }

            $time_confirm = ClientExt::getYandexPointTimeConfirm($trip, $yandex_point_from);

            if($time_confirm > 0) {

                $aMonths = ['', 'янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];

                $arrival = $time_confirm + 12000;
                $aTripsTimeConfirms[] = [
                    'trip_id' => $trip->id,
                    'data' => date("d.m.Y", $time_confirm),
                    'departure_date' => date('d', $time_confirm) .' '. $aMonths[intval(date('m', $time_confirm))],
                    'departure_time' => date("H:i", $time_confirm),
                    'arrival_date' => date('d', $arrival) .' '. $aMonths[intval(date('m', $arrival))],
                    'arrival_time' => date("H:i", $arrival)
                ];

                // $aTripEndTime = explode(':', $trip->end_time);
                // $trip_end_time = 3600*intval($aTripEndTime[0]) + 60*intval($aTripEndTime[1]);
                // //$travel_time = $trip_end_time - $time_confirm + 10800; // unixtime
                // $travel_time = 2*$trip->date + $trip_end_time - $time_confirm + 10800;

                // if(date("d.m.Y", $time_confirm) == date("d.m.Y", $client_ext->data)) {

                //     $aTripsTimeConfirms[] = [
                //         'trip_id' => $trip->id,
                //         'time' => date("H:i", $time_confirm),
                //         'travel_time_h' => intval(date("H", $travel_time)),
                //         'travel_time_m' => intval(date("i", $travel_time)),
                //         'data' => date("d.m.Y", $time_confirm),
                //     ];
                // }else {

                //     $date = date("d.m.Y", $time_confirm);
                //     if($date == date("d.m.Y", time() + 86400)) {
                //         $date = "завтра";
                //     }elseif($date == date("d.m.Y", time() + 86400)) {
                //         $date = "вчера";
                //     }

                //     $aTripsTimeConfirms[] = [
                //         'trip_id' => $trip->id,
                //         'time' => date("H:i", $time_confirm),
                //         'data' => $date,
                //         'travel_time_h' => intval(date("H", $travel_time)),
                //         'travel_time_m' => intval(date("i", $travel_time)),
                //     ];
                // }
            }

        }

        return [
            'client_ext_data' => date("d.m.Y", $client_ext->data),
            'client_ext_time' => $client_ext->time,
            'trips_time' => $aTripsTimeConfirms,
            'yandex_point_id' => $yandex_point_from->id,
            'yandex_point_name' => $yandex_point_from->name,
            'yandex_point_description' => $yandex_point_from->description,
            'yandex_point_lat' => $yandex_point_from->lat,
            'yandex_point_long' => $yandex_point_from->long,
        ];
    }

    // эту функцию нужно будет модифицировать, так как теперь цена зависит от предоплаченности и яндекс-точки отправления
    public function actionAjaxGetPrice($c, $trip_id, $yandex_point_from_id, $yandex_point_to_id = 0, $places_count, $student_count = 0, $child_count = 0, $is_not_places = 0) {

        Yii::$app->response->format = 'json';

//        $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
//        if($client_ext == null) {
//            throw new ForbiddenHttpException('Заказ не найден');
//        }

        // нужно все таки считать цену нового заказа, так как в старом данные не перезаписываются
        $client_ext = new ClientExt();

        $client_ext->trip_id = $trip_id;
        $client_ext->yandex_point_from_id = $yandex_point_from_id;
        if($yandex_point_to_id > 0) {
            $client_ext->yandex_point_to_id = $yandex_point_to_id;
        }
        $client_ext->places_count = $places_count;
        if($student_count > 0) {
            $client_ext->student_count = $student_count;
        }
        if($student_count > 0) {
            $client_ext->student_count = $student_count;
        }
        if($child_count > 0) {
            $client_ext->child_count = $child_count;
        }
        if($is_not_places > 0) {
            $client_ext->is_not_places = true;
        }

        // эту функцию нужно будет модифицировать, так как теперь цена зависит от предоплаченности и яндекс-точки отправления
        $price = $client_ext->getCalculatePrice('unprepayment'); // цена без предоплаты, т.е. полная
        //$price = 0;

        return [
            'price' => $price,
        ];
    }



    public function actionGetSelectPointFromForm($c) {

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        return $this->renderPartial('select-point-from-form', [
            'model' => $model,
        ]);
    }


    public function actionGetSelectPointToForm($c) {

        $model = ClientExt::find()->where(['access_code' => $c])->one();
        if($model == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $some_points = YandexPoint::find()->where(['active' => true, 'city_id' => $model->city_to_id])->limit(4)->all();

        return $this->renderPartial('select-point-to-form', [
            'model' => $model,
            'some_points' => $some_points
        ]);
    }
}
