<?php

use yii\db\Migration;

/**
 * Class m180111_082338_add_field_main_server_client_id_to_user
 */
class m180111_082338_add_field_main_server_client_id_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'main_server_client_id', $this->integer()->defaultValue(0)->comment('id клиента на основном сервере')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('user', 'main_server_client_id');
    }
}
