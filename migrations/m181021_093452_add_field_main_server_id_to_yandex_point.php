<?php

use yii\db\Migration;

class m181021_093452_add_field_main_server_id_to_yandex_point extends Migration
{
    public function up()
    {
        $this->truncateTable('yandex_point');
        $this->addColumn('yandex_point', 'main_server_id', $this->integer()->comment('id точки на основном сервере')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('yandex_point', 'main_server_id');
    }
}
