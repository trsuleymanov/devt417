<?php

namespace app\models;

use app\models\core\QueryWithSave;
use Yii;
use app\models\Direction;
use app\models\Order;
use app\models\OrderStatus;
use app\models\ScheduleTrip;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use app\models\Transport;
use app\models\Schedule;
use app\models\TripTransport;
use yii\web\ForbiddenHttpException;
use yii\base\ErrorException;
use app\models\DispatcherAccounting;

/**
 * Рейсы
 */
class Trip extends \yii\db\ActiveRecord
{
//	public static $max_time_short_trip_AK = 2400; //40*60;
//	//public static $max_time_short_trip_KA = 30*60;
//	public static $max_time_short_trip_KA = 2400; //40*60;

    public $unixtime; // временное поле для рассчетов

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'trip';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['date', 'main_server_trip_id', 'direction_id', 'commercial', 'created_updated_at'], 'integer'],
			[['name'], 'string', 'max' => 50],
			[['start_time', 'mid_time', 'end_time'], 'string', 'max' => 5],
			[['date', 'direction_id', 'name', 'start_time', 'mid_time', 'end_time'], 'required']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			//'id' => 'ID',
            'main_server_trip_id' => 'id рейса на основном сайте (в диспетчерской)',
			'name' => 'Название',
			'date' => 'Дата',
			'direction_id' => 'Направление',
			'commercial' => 'Коммерческий рейс',
			'start_time' => 'Начало сбора',
			'mid_time' => 'Середина сбора',
			'end_time' => 'Конец сбора',
			'created_updated_at' => 'Дата создания/редатирования'
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDirection()
	{
		return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
	}

    public function getTariff() {

        return Tariff::find()
            ->where(['<=', 'start_date', $this->date])
            ->andWhere(['commercial' => intval($this->commercial)])
            ->orderBy(['start_date' => SORT_DESC])
            ->one();
    }


	public static function getTrips($unixdate, $direction_id) {

		$unixdate = intval($unixdate);
		$correct_unixdate = strtotime(date('d.m.Y', $unixdate));

		return self::find()
			->where(['direction_id' => $direction_id])
			->andWhere(['date' => $correct_unixdate])
			->orderBy(['end_time' => SORT_ASC])
			->all();
	}

	public function getStartTimeUnixtime() {

	    $aHoursMinutes = explode(':', $this->start_time);

	    return $this->date + 3600*intval($aHoursMinutes[0]) + 60*intval($aHoursMinutes[1]);
    }


	// !!! Нельзя генерировать рейсы на клиенском сервере, т.к. они должны забираться с диспетчерского сервера.

//	public static function getTrips($unixdate, $direction_id)
//	{
//		return self::getTripsQuery($unixdate, $direction_id)->all();
//	}

//	public static function getTripsQuery($unixdate, $direction_id) {
//
//		$unixdate = intval($unixdate);
//		$correct_unixdate = strtotime(date('d.m.Y', $unixdate));
//
//		$trip = self::find()
//			->where(['direction_id' => $direction_id])
//			->andWhere(['date' => $correct_unixdate])
//			->one();
//		if($trip == null) {
//			self::createStandartTripList($correct_unixdate, $direction_id);
//		}
//		return self::find()
//			->where(['direction_id' => $direction_id])
//			->andWhere(['date' => $correct_unixdate])
//			->orderBy(['end_time'=>SORT_ASC]);
//	}

//	public static function createStandartTripList($unixdate, $direction_id)
//	{
//		$schedule = Schedule::find()
//			->where(['<=', 'start_date', $unixdate])
//			->andWhere(['direction_id' => $direction_id])
//			->orderBy(['start_date' => SORT_DESC])
//			->one();
//		if($schedule == null) {
//			return [];
//		}
//		$schedule_trips = $schedule->scheduleTrips;
//		if(count($schedule_trips) == 0) {
//			throw new ForbiddenHttpException('Рейсов для расписания "'.$schedule->name.'" не найдено');
//		}
//
//
//		$trips = [];
//		foreach($schedule_trips as $schedule_trip) {
//			$trip = new Trip();
//			$trip->name = $schedule_trip->name;
//			$trip->direction_id = $direction_id;
//			$trip->start_time = $schedule_trip->start_time;
//			$trip->mid_time = $schedule_trip->mid_time;
//			$trip->end_time = $schedule_trip->end_time;
//
//			// получаем дату+время в формате unixtime
//			$trip->date = strtotime(date('d.m.Y', $unixdate));
//			//$trip->created_at = time();
//
//			$trips[] = $trip;
//		}
//
//		$rows = ArrayHelper::getColumn($trips, 'attributes');
//
//		return Yii::$app->db->createCommand()->batchInsert(self::tableName(), $trip->attributes(), $rows)->execute();
//	}

}
