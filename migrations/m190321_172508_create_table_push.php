<?php

use yii\db\Migration;

/**
 * Class m190321_172508_create_table_push
 */
class m190321_172508_create_table_push extends Migration
{
    public function up()
    {
        $this->createTable('push', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->comment('Создан'),
            'title' => $this->string(50)->comment('Заголовок пуша'),
            'text' => $this->string(255)->comment('Текст пуша'),
            'recipient_user_id' => $this->integer()->comment('Пользователь - получатель'),
            //'send_event' => $this->string(20)->comment('Событие при наступлении которого происходит отправка пуша'),
            'send_event' => "ENUM('with_sync_clientext', 'immediately')",
            'client_ext_id' => $this->integer()->comment('id заявки'),
            'sended_at' => $this->integer()->comment('Время когда был отправлен пуш'),
            'confirm_time_at' => $this->integer()->comment('Время согласия при получении пуша'),
            'reject_time_at' => $this->integer()->comment('Время отказа при получении пуша'),
            'sync_answer_time_at' => $this->integer()->comment('Время отсылки ответа на основной сервер'),
        ]);
    }

    public function down()
    {
        $this->dropTable('push');
    }
}
