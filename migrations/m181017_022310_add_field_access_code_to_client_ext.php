<?php

use yii\db\Migration;

/**
 * Class m181017_022310_add_field_access_code_to_client_ext
 */
class m181017_022310_add_field_access_code_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'access_code', $this->string(32)->comment('Уникальный код доступа к заказу')->after('friend_code'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'access_code');
    }
}
