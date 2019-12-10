<?php

use yii\db\Migration;

/**
 * Class m180204_213154_add_field_restore_code_to_user
 */
class m180204_213154_add_field_restore_code_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'restore_code', $this->string(255)->comment('Код восстановления доступа')->after('confirmed'));
    }

    public function down()
    {
        $this->dropColumn('user', 'restore_code');
    }
}
