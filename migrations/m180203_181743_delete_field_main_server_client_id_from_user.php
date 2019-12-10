<?php

use yii\db\Migration;

/**
 * Class m180203_181743_delete_field_main_server_client_id_from_user
 */
class m180203_181743_delete_field_main_server_client_id_from_user extends Migration
{
    public function up()
    {
        $this->dropColumn('user', 'main_server_client_id');
    }

    public function down()
    {
        $this->addColumn('user', 'main_server_client_id', $this->integer()->comment('id клиента на основном сервере')->after('id'));
    }
}
