<?php

use yii\db\Migration;

/**
 * Class m181230_013726_create_table_new_year_request
 */
class m181230_013726_create_table_new_year_request extends Migration
{
    public function up()
    {
        $this->createTable('new_year_request', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->comment('Создан'),
            'direction' => $this->string(100)->comment('Направление'),
            //'mktime_date' => $this->integer()->comment('Время выезда'),
            'time' => $this->string(50)->comment('Время выезда'),
            'date' => $this->string(10)->comment('Дата выезда'),
            'phone' => $this->string(15)->comment('Телефон'),
            'time_for_call' =>$this->string(50)->comment('Время для звонка'),
        ]);
    }

    public function down()
    {
        $this->dropTable('new_year_request');
    }
}
