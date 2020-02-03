<?php

use yii\db\Migration;

/**
 * Class m200202_010547_add_field_time_air_train_departure_to_clientext
 */
class m200202_010547_add_field_time_air_train_departure_to_clientext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'time_air_train_departure', $this->string(5)->comment('Время отправления поезда / начало регистрации авиарейса')->after('yandex_point_to_id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'time_air_train_departure');
    }
}
