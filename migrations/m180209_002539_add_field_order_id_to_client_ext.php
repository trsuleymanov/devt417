<?php

use yii\db\Migration;

class m180209_002539_add_field_order_id_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'main_server_order_id', $this->integer()->comment('id заказа на основном сервере')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'main_server_order_id');
    }
}
