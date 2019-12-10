<?php

use yii\db\Migration;

/**
 * Class m190318_005154_add_field_push_token_to_user
 */
class m190318_005154_add_field_push_token_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'push_token', $this->string(255)->comment('Токен мобильного устройства для пушей')->after('token'));
    }

    public function down()
    {
        $this->dropColumn('user', 'push_token');
    }
}
