<?php

use yii\db\Migration;

/**
 * Class m180204_110222_create_table_current_reg
 */
class m180204_110222_create_table_current_reg extends Migration
{
    public function up()
    {
        $this->createTable('current_reg', [  // заказы клиентов
            'id' => $this->primaryKey(),
            'email' => $this->string(50)->comment('Электронная почта'),
            'fio' => $this->string(100)->comment('ФИО'),
            'mobile_phone' => $this->string(20)->comment('Мобильный телефон'),
            'password' => $this->string(30)->comment('Пароль'),
            'registration_code' => $this->string(255)->comment('Код идентифицирующий пользователя'),
            'created_at' => $this->integer()->comment('Время создания'),
            'updated_at' => $this->integer()->comment('Время изменения'),
        ]);
    }

    public function down()
    {
        $this->dropTable('current_reg');
    }
}
