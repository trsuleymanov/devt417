<?php

use yii\db\Migration;

/**
 * Class m180705_023232_add_field_commercial_to_trip
 */
class m180705_023232_add_field_commercial_to_trip extends Migration
{
    public function up()
    {
        $this->addColumn('trip', 'commercial', $this->boolean()->defaultValue(0)->comment('Коммерческий рейс')->after('direction_id'));
    }

    public function down()
    {
        $this->dropColumn('trip', 'commercial');
    }
}
