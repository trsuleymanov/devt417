<?php

use yii\db\Migration;

/**
 * Class m181017_151849_add_field_trip_id_to_client_ext
 */
class m181017_151849_add_field_trip_id_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'trip_id', $this->integer()->comment('Рейс')->after('time_confirm'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'trip_id');
    }
}
