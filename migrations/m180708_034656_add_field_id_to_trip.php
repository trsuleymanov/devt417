<?php

use yii\db\Migration;

/**
 * Class m180708_034656_add_field_id_to_trip
 */
class m180708_034656_add_field_id_to_trip extends Migration
{
    public function up()
    {
        $this->addColumn('trip', 'id', $this->primaryKey());
    }

    public function down()
    {
        $this->dropColumn('trip', 'id');
    }

}
