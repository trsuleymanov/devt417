<?php

use app\models\Setting;
use yii\db\Migration;

/**
 * Class m190625_185549_clear_trips_clientext_payment_table
 */
class m190625_185549_clear_trips_clientext_payment_table extends Migration
{
    public function up()
    {
        $this->truncateTable('account_transaction');
        $this->truncateTable('client_ext');
        $this->truncateTable('client_ext_passenger');
        $this->truncateTable('push');
        $this->truncateTable('trip');
        $this->truncateTable('yandex_payment');
    }

    public function down()
    {

    }
}
