<?php

use yii\db\Migration;

/**
 * Class m181014_195508_create_table_clientext_passenger
 */
class m181014_195508_create_table_clientext_passenger extends Migration
{
    public function up()
    {
        $this->createTable('client_ext_passenger', [
            'id' => $this->primaryKey(),
            'client_ext_id' => $this->integer()->comment('Заказ'),
            'passenger_id' => $this->integer()->comment('Пассажир'),
        ]);
    }

    public function down()
    {
        $this->dropTable('client_ext_passenger');
    }
}
