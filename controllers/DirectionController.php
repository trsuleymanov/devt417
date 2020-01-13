<?php

namespace app\controllers;

use Yii;
use app\models\Client;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use app\models\Direction;
use app\models\Order;
use app\models\OrderSearch;
use app\models\Street;
use app\models\Point;



class DirectionController extends Controller
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


    public function actionAjaxGetDirectionMapData($id, $from = 0) {

        Yii::$app->response->format = 'json';

        $direction = Direction::find()->where(['id' => $id])->one();
        if($direction == null) {
            throw new ForbiddenHttpException('Направление не найдено');
        }

        $city = ($from == 1 ? $direction->cityFrom :  $direction->cityTo);

        if($from == 1) {
            $yandex_points = $city->yandexPoints;
        }else {
            $yandex_points = [];
            $points =  $city->yandexPoints;
            foreach ($points as $point) {
                if($point->point_of_arrival == true) {
                    $yandex_points[] = $point;
                }
            }
        }

        return [
            'city' => $city,
            'yandex_points' => $yandex_points
        ];
    }

}
