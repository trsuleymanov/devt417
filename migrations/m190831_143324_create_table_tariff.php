<?php

use yii\db\Migration;

/**
 * Class m190831_143324_create_table_tariff
 */
class m190831_143324_create_table_tariff extends Migration
{
    public function up()
    {
        $this->createTable('tariff', [
            'id' => $this->primaryKey(),
            'main_server_id' => $this->integer(),
            'start_date' => $this->integer(),
            'commercial' => $this->boolean()->defaultValue(0)->comment('Спец. тариф (коммерческий)'),

            'unprepayment_common_price' => $this->decimal(8,2)->defaultValue(0)->comment('Общая стоимость проезда без предоплаты'),
            'unprepayment_student_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость студенческого проезда без предоплаты'),
            'unprepayment_baby_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость детского проезда без предоплаты'),
            'unprepayment_aero_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость поездки в/из аэропорта без предоплаты'),
            'unprepayment_parcel_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость провоза посылки (без места) без предоплаты'),
            'unprepayment_loyal_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость призовой поездки без предоплаты'),
            'unprepayment_reservation_cost' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость бронирования без предоплаты'),

            'prepayment_common_price' => $this->decimal(8,2)->defaultValue(0)->comment('Общая стоимость проезда с предоплатой'),
            'prepayment_student_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость студенческого проезда с предоплатой'),
            'prepayment_baby_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость детского проезда с предоплатой'),
            'prepayment_aero_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость поездки в/из аэропорта с предоплатой'),
            'prepayment_parcel_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость провоза посылки (без места) с предоплатой'),
            'prepayment_loyal_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость призовой поездки с предоплатой'),
            'prepayment_reservation_cost' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость бронирования с предоплатой'),

            'superprepayment_common_price' => $this->decimal(8,2)->defaultValue(0)->comment('Общая стоимость проезда с супер-предоплатой'),
            'superprepayment_student_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость студенческого проезда с супер-предоплатой'),
            'superprepayment_baby_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость детского проезда с супер-предоплатой'),
            'superprepayment_aero_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость поездки в/из аэропорта с супер-предоплатой'),
            'superprepayment_parcel_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость провоза посылки (без места) с супер-предоплатой'),
            'superprepayment_loyal_price' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость призовой поездки с супер-предоплатой'),
            'superprepayment_reservation_cost' => $this->decimal(8,2)->defaultValue(0)->comment('Стоимость бронирования с супер-предоплатой'),
        ]);
    }

    public function down()
    {
        $this->dropTable('tariff');
    }
}
