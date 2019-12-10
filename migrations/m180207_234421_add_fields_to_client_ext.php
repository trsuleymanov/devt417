<?php

use yii\db\Migration;

/**
 * Class m180207_234421_add_fields_to_client_ext
 */
class m180207_234421_add_fields_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'status_setting_time', $this->integer()->comment('Время установки статуса')->after('status'));

        $this->addColumn('client_ext', 'time_confirm', $this->integer()->comment('ВРПТ (Время подтверждения)')->after('time'));
        $this->addColumn('client_ext', 'trip_name', $this->string(50)->comment('Название рейса')->after('time_confirm'));
        $this->addColumn('client_ext', 'street_from', $this->string(50)->comment('Улица откуда')->after('trip_name'));
        $this->addColumn('client_ext', 'point_from', $this->string(50)->comment('Точка откуда')->after('street_from'));
        $this->addColumn('client_ext', 'street_to', $this->string(50)->comment('Улица куда')->after('point_from'));
        $this->addColumn('client_ext', 'point_to', $this->string(50)->comment('Точка куда')->after('street_to'));
        $this->addColumn('client_ext', 'places_count', $this->smallInteger(2)->comment('Количество мест всего')->after('street_to'));
        $this->addColumn('client_ext', 'transport_car_reg', $this->string(20)->comment('Гос. номер т/с')->after('places_count'));
        $this->addColumn('client_ext', 'transport_model', $this->string(50)->comment('Марка т/с')->after('transport_car_reg'));
        $this->addColumn('client_ext', 'transport_color', $this->string(50)->comment('Цвет т/с')->after('transport_model'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'status_setting_time');
        $this->dropColumn('client_ext', 'time_confirm');
        $this->dropColumn('client_ext', 'trip_name');
        $this->dropColumn('client_ext', 'street_from');
        $this->dropColumn('client_ext', 'point_from');
        $this->dropColumn('client_ext', 'street_to');
        $this->dropColumn('client_ext', 'point_to');
        $this->dropColumn('client_ext', 'places_count');
        $this->dropColumn('client_ext', 'transport_car_reg');
        $this->dropColumn('client_ext', 'transport_model');
        $this->dropColumn('client_ext', 'transport_color');
    }
}
