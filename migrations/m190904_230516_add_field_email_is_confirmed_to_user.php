<?php

use yii\db\Migration;

/**
 * Class m190904_230516_add_field_email_is_confirmed_to_user
 */
class m190904_230516_add_field_email_is_confirmed_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'email_is_confirmed', $this->boolean()->defaultValue(false)->comment('Эл.почта была подтверждена')->after('email'));
    }

    public function down()
    {
        $this->dropColumn('user', 'email_is_confirmed');
    }
}
