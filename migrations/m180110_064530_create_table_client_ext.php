<?php

use yii\db\Migration;

/**
 * Class m180110_064530_create_table_client_ext
 */
class m180110_064530_create_table_client_ext extends Migration
{
    public function up()
    {
        $this->createTable('client_ext', [  // заказы клиентов
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger()->comment('Статус заказа'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'direction' => $this->string(50)->comment('Направление'),
            'data' => $this->string(8)->comment('Дата'),
            'time' => $this->string(5)->comment('Время'),
            'created_at' => $this->integer()->comment('Время создания'),
            'updated_at' => $this->integer()->comment('Время изменения'),
        ]);
    }

    public function down()
    {
        $this->dropTable('client_ext');
    }
}
