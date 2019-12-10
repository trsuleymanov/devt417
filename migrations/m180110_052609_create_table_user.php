<?php

use yii\db\Migration;

/**
 * Class m180110_052609_create_table_user
 */
class m180110_052609_create_table_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [ // пользователи
            'id' => $this->primaryKey(),
            //'last_login_date' => $this->integer()->comment('Время последней попытки входа на сайт'),
            'auth_key' => $this->string(32),
            //'auth_seans_finish' => $this->integer()->comment('Время окончания сеанса пользователя'),
            'password_hash' => $this->string(255),
            'token' => $this->string(255)->comment('Токен устройства'),
            'username' => $this->string(50)->comment('Логин'),
            'email' => $this->string(50)->comment('Электронная почта'),
            'fio' => $this->string(100)->comment('ФИО'),
            'phone' => $this->string(20)->comment('Телефон'),
            //'city' => $this->string(50)->comment('Город'),
            //'address' => $this->string(255)->comment('Адрес'),
            //'last_ip' => $this->string(20)->comment('IP адрес (последнего входа на сайт)'),
            //'attempt_count' => $this->smallInteger(6)->defaultValue(0)->comment('Количество неудачных попыток последнего входа на сайт '),
            //'attempt_date' => $this->integer()->comment('Время последней попытки входа на сайт'),
            'created_at' => $this->integer()->comment('Время создания'),
            'updated_at' => $this->integer()->comment('Время изменения'),
            //'blocked' => $this->smallInteger(1)->defaultValue(0)->comment('Заблокирован')
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }

}
