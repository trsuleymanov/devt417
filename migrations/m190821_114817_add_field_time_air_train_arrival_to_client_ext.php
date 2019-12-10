<?php

use yii\db\Migration;

/**
 * Class m190821_114817_add_field_time_air_train_arrival_to_client_ext
 */
class m190821_114817_add_field_time_air_train_arrival_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'time_air_train_arrival', $this->string(5)->comment('Время прибытия поезда / посадки самолета')->after('yandex_point_from_id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'time_air_train_arrival');
    }
}
