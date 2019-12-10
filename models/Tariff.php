<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class Tariff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'unprepayment_common_price', 'unprepayment_student_price', 'unprepayment_baby_price',
                'unprepayment_aero_price', 'unprepayment_parcel_price', 'unprepayment_loyal_price', 'unprepayment_reservation_cost',

                'prepayment_common_price', 'prepayment_student_price', 'prepayment_baby_price',
                'prepayment_aero_price', 'prepayment_parcel_price', 'prepayment_loyal_price', 'prepayment_reservation_cost',

                'superprepayment_common_price', 'superprepayment_student_price', 'superprepayment_baby_price',
                'superprepayment_aero_price', 'superprepayment_parcel_price', 'superprepayment_loyal_price', 'superprepayment_reservation_cost',

            ], 'number'],
            [['commercial', 'main_server_id'], 'integer'],
            [['start_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_server_id' => 'ID тарифа в диспетчерской',
            'start_date' => 'Дата запуска',
            'commercial' => 'Спец. тариф (коммерческий)',

            'unprepayment_common_price' => 'Общая стоимость проезда без предоплаты',
            'unprepayment_student_price' => 'Стоимость студенческого проезда без предоплаты',
            'unprepayment_baby_price' => 'Стоимость детского проезда без предоплаты',
            'unprepayment_aero_price' => 'Стоимость поездки в/из аэропорта без предоплаты',
            'unprepayment_parcel_price' => 'Стоимость провоза посылки (без места) без предоплаты',
            'unprepayment_loyal_price' => 'Стоимость призовой поездки без предоплаты',
            'unprepayment_reservation_cost' => 'Стоимость бронирования без предоплаты',

            'prepayment_common_price' => 'Общая стоимость проезда с предоплатой',
            'prepayment_student_price' => 'Стоимость студенческого проезда с предоплатой',
            'prepayment_baby_price' => 'Стоимость детского проезда с предоплатой',
            'prepayment_aero_price' => 'Стоимость поездки в/из аэропорта с предоплатой',
            'prepayment_parcel_price' => 'Стоимость провоза посылки (без места) с предоплатой',
            'prepayment_loyal_price' => 'Стоимость призовой поездки с предоплатой',
            'prepayment_reservation_cost' => 'Стоимость бронирования с предоплатой',

            'superprepayment_common_price' => 'Общая стоимость проезда с супер-предоплатой',
            'superprepayment_student_price' => 'Стоимость студенческого проезда с супер-предоплатой',
            'superprepayment_baby_price' => 'Стоимость детского проезда с супер-предоплатой',
            'superprepayment_aero_price' => 'Стоимость поездки в/из аэропорта с супер-предоплатой',
            'superprepayment_parcel_price' => 'Стоимость провоза посылки (без места) с супер-предоплатой',
            'superprepayment_loyal_price' => 'Стоимость призовой поездки с супер-предоплатой',
            'superprepayment_reservation_cost' => 'Стоимость бронирования с супер-предоплатой',
        ];
    }
}
