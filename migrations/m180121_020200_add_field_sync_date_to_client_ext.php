<?php

use yii\db\Migration;

/**
 * Class m180121_020200_add_field_sync_date_to_client_ext
 */
class m180121_020200_add_field_sync_date_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'sync_date', $this->integer()->comment('Дата выгрузки основным сервером текущих данных'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'sync_date');
    }
}
