<?php

use yii\db\Migration;

/**
 * Class m190816_165210_add_max_time_short_trip_fields_to_settings
 */
class m190816_165210_add_max_time_short_trip_fields_to_settings extends Migration
{
    public function up()
    {
        $this->addColumn('setting', 'max_time_short_trip_AK', $this->integer()->defaultValue(2400));
        $this->addColumn('setting', 'max_time_short_trip_KA', $this->integer()->defaultValue(2400));
    }

    public function down()
    {
        $this->dropColumn('setting', 'max_time_short_trip_AK');
        $this->dropColumn('setting', 'max_time_short_trip_KA');
    }
}
