<?php

namespace app\models;

use Yii;
use app\models\City;
use app\models\Trip;
use app\models\Schedule;
use yii\base\ErrorException;

/**
 * This is the model class for table "direction".
 *
 * @property integer $id
 * @property string $sh_name
 * @property integer $city_from
 * @property integer $city_to
 * @property integer $distance
 * @property integer $created_at
 * @property integer $updated_at
 */
class Direction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'direction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sh_name'], 'required'],
            [['city_from', 'city_to', 'distance', 'created_at', 'updated_at', ], 'integer'],
            [['sh_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sh_name' => 'Краткое название',
            'city_from' => 'Город отправления',
            'city_to' => 'Город назначения',
            'distance' => 'Дистанция, км',
            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }else {
            $this->updated_at = time();
        }

        return parent::beforeSave($insert);
    }

    public static function getDirections() {
        return [
            'Альметьевск-Казань',
            'Казань-Альметьевск'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityFrom()
    {
        return $this->hasOne(City::className(), ['id' => 'city_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityTo()
    {
        return $this->hasOne(City::className(), ['id' => 'city_to']);
    }


    public function getTrips()
    {
        return $this->hasMany(Trip::className(), ['direction_id' => 'id']);
    }


//    public function getSchedules()
//    {
//        return $this->hasMany(Schedule::className(), ['direction_id' => 'id']);
//    }

    public function getRevertDirection() {
        return Direction::find()->where(['city_from' => $this->city_to, 'city_to' => $this->city_from])->one();
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        if ($insert) {
//            $this->createSchedule();// создаются типовое расписание для нового направления
//        }
//
//        parent::afterSave($insert, $changedAttributes);
//    }

//    public function createSchedule()
//    {
//        $schedule = new Schedule();
//        $schedule->direction_id = $this->id;
//        $schedule->name = 'Стандартное расписание';
//        $schedule->start_date = date('d.m.Y', time() + 86400);
//
//        if(!$schedule->save()) {
//            throw new ErrorException('Не удалось создать стандартное расписание');
//        }
//
//        return true;
//    }

//    public function afterDelete()
//    {
//        // удалять необходимо распиния через модели расписаний - и никак иначе!
//        $schedules = $this->schedules;
//        foreach($schedules as $schedule) {
//            $schedule->delete();
//        }
//
//        parent::afterDelete();
//    }

}
