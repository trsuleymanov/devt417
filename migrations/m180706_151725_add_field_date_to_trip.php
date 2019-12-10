<?php

use yii\db\Migration;

/**
 * Class m180706_151725_add_field_date_to_trip
 */
class m180706_151725_add_field_date_to_trip extends Migration
{
    public function up()
    {
        $this->addColumn('trip', 'date', $this->integer()->comment('Дата')->after('name'));
        $this->addColumn('trip', 'created_updated_at', $this->integer()->comment('Дата последнего создания/редактирования рейса')->after('end_time'));
        $this->dropColumn('trip', 'id');
    }

    public function down()
    {
        $this->dropColumn('trip', 'date');
        $this->addColumn('trip', 'id', $this->primaryKey());
        $this->dropColumn('trip', 'created_updated_at');
    }
}
