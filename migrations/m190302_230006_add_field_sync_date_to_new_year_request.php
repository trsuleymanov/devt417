<?php

use yii\db\Migration;

/**
 * Class m190302_230006_add_field_sync_date_to_new_year_request
 */
class m190302_230006_add_field_sync_date_to_new_year_request extends Migration
{
    public function up()
    {
        $this->addColumn('new_year_request', 'sync_date', $this->integer()->comment('Время выгрузки заявки на основной сервер'));
    }

    public function down()
    {
        $this->dropColumn('new_year_request', 'sync_date');
    }
}
