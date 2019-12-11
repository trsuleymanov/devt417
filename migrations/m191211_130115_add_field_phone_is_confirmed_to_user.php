<?php

use yii\db\Migration;

/**
 * Class m191211_130115_add_field_phone_is_confirmed_to_user
 */
class m191211_130115_add_field_phone_is_confirmed_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'phone_is_confirmed', $this->boolean()->defaultValue(false)->comment('Телефон подтвержден')->after('phone'));
    }

    public function down()
    {
        $this->dropColumn('user', 'phone_is_confirmed');
    }
}
