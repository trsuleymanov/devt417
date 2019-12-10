<?php

use yii\db\Migration;

/**
 * Class m180203_151814_delete_field_sync_date_from_user
 */
class m180203_151814_delete_field_sync_date_from_user extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'sync_date');
    }

    public function down()
    {
        $this->addColumn('user', 'sync_date', $this->integer()->comment('Дата синхронизации с основным сервером'));
    }
}
