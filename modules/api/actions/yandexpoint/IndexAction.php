<?php

namespace app\modules\api\actions\yandexpoint;

use app\models\City;
use app\models\YandexPoint;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;
use app\models\Trip;


class IndexAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Список рейсов
     */
    public function run()
    {
        $direction = intval(Yii::$app->getRequest()->getBodyParam('direction'));
        $from = Yii::$app->getRequest()->getBodyParam('from');
        if(!in_array($direction, [1, 2])) {
            throw new ForbiddenHttpException('Выберите направление');
        }
        if($from == "true") {
            $from = true;
        }elseif($from == "false") {
            $from = false;
        }else {
            $from = boolval($from);
        }

        if($direction == 1) { // АК
            if($from == true) {
                $city_id = 2; // Альметьевск
            }else {
                $city_id = 1; // Казань
            }
        }else { // direction==2 - КА
            if($from == true) {
                $city_id = 1; // Казань
            }else {
                $city_id = 2; // Альметьевск
            }
        }


        $yandex_points = YandexPoint::find()->where(['city_id' => $city_id])->all();
        $city = City::find()->where(['id' => $city_id])->one();

        return [
            'yandex_points' => $yandex_points,
            'city' => $city
        ];
    }
}