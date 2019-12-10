<?php

use yii\db\Migration;

/**
 * Class m190831_202008_add_fields_to_client_ext
 */
class m190831_202008_add_fields_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'is_not_places', $this->boolean()->defaultValue(0)->comment('Без места (отправляется посылка)')->after('places_count'));
        $this->addColumn('client_ext', 'prize_trip_count', $this->smallInteger(2)->defaultValue(0)->comment('Количество призовых поездок')->after('bag_count'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'is_not_places');
        $this->dropColumn('client_ext', 'prize_trip_count');
    }
}
