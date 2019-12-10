<?php

use yii\db\Migration;

/**
 * Class m190528_183543_add_field_sync_date_to_user
 */
class m190528_183543_add_field_sync_date_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'sync_date', $this->integer()->comment('Дата синхронизации с диспетчерской'));
    }

    public function down()
    {
        $this->dropColumn('user', 'sync_date');
    }
}
