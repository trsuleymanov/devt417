<?php

use yii\db\Migration;

/**
 * Class m180111_095840_add_field_sync_date_to_user
 */
class m180111_095840_add_field_sync_date_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'sync_date', $this->integer()->comment('Дата синхронизации с основным сервером'));
    }

    public function down()
    {
        $this->dropColumn('user', 'sync_date');
    }
}
