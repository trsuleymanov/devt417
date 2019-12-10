<?php

namespace app\models;

use Yii;
use app\models\City;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "yandex_point".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 * @property double $lat
 * @property double $long
 */
class YandexPoint extends \yii\db\ActiveRecord
{
    const MIN_POINTS_DISTANCE = 40; // минимальная дистанция между точками

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lat', 'long'], 'required'],
            [['city_id', 'main_server_id', 'time_to_get_together_short', 'time_to_get_together_long', ], 'integer'],
            [['lat', 'long'], 'number'],
            [['name', 'description'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 10],
            [['name'], 'unique'],
            [['active', 'critical_point', 'point_of_arrival', 'super_tariff_used',
                'popular_departure_point', 'popular_arrival_point'], 'boolean'],
            [['lat', /*'long'*/], 'checkLatLong', 'skipOnEmpty' => false],
        ];
    }

    public function checkLatLong($attribute, $params)
    {
        if(!empty($this->lat) && $this->lat > 0 && !empty($this->long) && $this->long > 0) {

            if ($this->isNewRecord) {
                $yandex_points = YandexPoint::find()
                    ->where(['city_id' => $this->city_id])
                    ->all();
            }else {
                $yandex_points = YandexPoint::find()
                    ->where(['city_id' => $this->city_id])
                    ->andWhere(['!=', 'id', $this->id])
                    ->all();
            }

            foreach($yandex_points as $yandex_point) {
                $distance = YandexPoint::getDistance($this->lat, $this->long, $yandex_point->lat, $yandex_point->long);
                if($distance <= self::MIN_POINTS_DISTANCE) {
                    $this->addError($attribute, 'Расстоянием между точками должно быть больше '.self::MIN_POINTS_DISTANCE.' метров');
                }
            }
        }
    }

    public static function getDistance($lat1, $lon1, $lat2, $lon2) {

        $lat1 *= M_PI / 180;
        $lat2 *= M_PI / 180;
        $lon1 *= M_PI / 180;
        $lon2 *= M_PI / 180;

        $d_lon = $lon1 - $lon2;

        $slat1 = sin($lat1);
        $slat2 = sin($lat2);
        $clat1 = cos($lat1);
        $clat2 = cos($lat2);
        $sdelt = sin($d_lon);
        $cdelt = cos($d_lon);

        $y = pow($clat2 * $sdelt, 2) + pow($clat1 * $slat2 - $slat1 * $clat2 * $cdelt, 2);
        $x = $slat1 * $slat2 + $clat1 * $clat2 * $cdelt;

        return atan2(sqrt($y), $x) * 6372795;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_server_id' => 'id точки на основном сервере',
            'active' => 'Активность',
            'external_use' => 'Внешнее использование (да/нет)',
            'name' => 'Название',
            'description' => 'Описание',
            'city_id' => 'Город',
            'lat' => 'Широта',
            'long' => 'Долгота',
            'sync_date' => 'Дата синхронизации с клиенским сервером',
            'point_of_arrival' => 'Является точкой прибытия',
            'super_tariff_used' => 'Применяется супер тариф',
            'critical_point' => 'Критическая точка',
            'popular_departure_point' => 'Популярная точка отправления',
            'popular_arrival_point' => 'Популярная точка прибытия',
            'alias' => 'Доп.поле означающее принадлежность точки к чему-либо, например к аэропорту',
            //'created_at' => 'Время создания',
            //'updated_at' => 'Время изменения',
            //'creator_id' => 'Создатель точки',
            //'updater_id' => 'Редактор точки',
            'time_to_get_together_short' => 'Относительное время от ВРПТ до конечной базовой точки рейса коротких рейсов',
            'time_to_get_together_long' => 'Относительное время от ВРПТ до конечной базовой точки рейса длинных рейсов',
        ];
    }

//    public function beforeSave($insert)
//    {
//        $this->sync_date = null;
//
//        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
//    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }
}
