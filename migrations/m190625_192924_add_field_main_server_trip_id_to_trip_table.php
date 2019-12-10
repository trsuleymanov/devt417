<?php

use yii\db\Migration;

/**
 * Class m190625_192924_add_field_main_server_trip_id_to_trip_table
 */
class m190625_192924_add_field_main_server_trip_id_to_trip_table extends Migration
{
    public function up()
    {
        $this->addColumn('trip', 'main_server_trip_id', $this->integer()->defaultValue(0)->comment('id рейса на основном сайте')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('trip', 'main_server_trip_id');
    }
}
