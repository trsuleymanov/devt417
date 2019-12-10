<?php

namespace app\models;

use Yii;
use app\models\YandexPoint;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['map_scale', 'search_scale', 'point_focusing_scale', 'all_points_show_scale', 'extended_external_use'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['center_lat', 'center_long'], 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'extended_external_use' => 'Расширенное внешнее использование',
            'center_lat' => 'Широта',
            'center_long' => 'Долгота',
            'map_scale' => 'Масштаб яндекс-карты',
            'search_scale' => 'Приближение карты при поиске',
            'point_focusing_scale' => 'Масштаб фокусировки точки',
            'all_points_show_scale' => 'Масштаб отображения опорных точек'
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getYandexPoints()
    {
        return $this->hasMany(YandexPoint::className(), ['city_id' => 'id']);
    }
}
