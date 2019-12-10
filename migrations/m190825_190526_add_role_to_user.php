<?php

use yii\db\Migration;

/**
 * Class m190825_190526_add_role_to_user
 */
class m190825_190526_add_role_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'role', "ENUM('admin','client') DEFAULT 'client' after last_login_date ");
    }

    public function down()
    {
        $this->dropColumn('user', 'but_checkout');
    }
}
