<?php

use yii\db\Migration;

/**
 * Class m190907_002902_delete_field_password_in_current_reg
 */
class m190907_002902_delete_field_password_in_current_reg extends Migration
{
    // $this->string(30)->comment('Пароль')

    public function up()
    {
        $this->dropColumn('current_reg', 'password');
    }

    public function down()
    {
        $this->addColumn('current_reg', 'password', $this->string(30)->comment('Пароль')->after('mobile_phone'));
    }
}
