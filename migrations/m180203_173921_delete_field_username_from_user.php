<?php

use yii\db\Migration;

/**
 * Class m180203_173921_delete_field_username_from_user
 */
class m180203_173921_delete_field_username_from_user extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'username');
    }

    public function down()
    {
        $this->addColumn('user', 'username', $this->string(50)->comment('Логин')->after('token'));
    }
}
