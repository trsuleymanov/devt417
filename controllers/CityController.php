<?php

namespace app\controllers;

use Yii;
use app\models\City;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
{
    public function actionAjaxGetCityYandexPointsData($city_id) {

        Yii::$app->response->format = 'json';

        $city = City::find()->where(['id' => $city_id])->one();
        if($city == null) {
            throw new ForbiddenHttpException('Город не найден');
        }

        return [
            'city' => $city,
            'yandex_points' => $city->yandexPoints
        ];
    }
}
