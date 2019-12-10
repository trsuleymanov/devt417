<?php

use yii\db\Migration;

/**
 * Class m190606_181954_create_table_yandex_payment
 */
class m190606_181954_create_table_yandex_payment extends Migration
{
    public function up()
    {
        $this->createTable('yandex_payment', [
            'id' => $this->primaryKey(),
            'type' => "ENUM('payment','return_payment')",
            'source_type' => "ENUM('site','app')",
            'yandex_payment_id' => $this->string(36)->comment('id текущего платежа/возврата в системе яндекса'),
            'payment_token' => $this->string(40)->comment('токен для провещения мобильного платежа'),
            'source_yandex_payment_id' => $this->string(36)->comment('id платежа в системе яндекса по которой производиться возврат'),
            'source_payment_id' => $this->integer()->comment('id платежа в текущей таблице по которой производиться возврат'),
            'client_ext_id' => $this->integer()->comment('Заявка'),
            'value' => $this->decimal(8, 2)->defaultValue(0)->comment('Сумма, руб'),
            'currency' => $this->string(4)->comment('Валюта'),
            'payment_type' => $this->string(16)->comment('Тип платежной системы с помощью которой произведена оплата (например bank_card)'),
            'status' => "ENUM('pending', 'waiting_for_capture', 'succeeded', 'canceled')",
            'created_at' => $this->integer()->comment('Создан'),
            'pending_at' => $this->integer()->comment('Время перехода платежа в статус pending'),
            'waiting_for_capture_at' => $this->integer()->comment('Время перехода платежа в статус waiting_for_capture'),
            'succeeded_at' => $this->integer()->comment('Время перехода платежа в статус succeeded'),
            'canceled_at' => $this->integer()->comment('Время перехода платежа в статус canceled'),
        ]);
    }

    public function down()
    {
        $this->dropTable('yandex_payment');
    }
}
