<?php

use yii\db\Migration;

/**
 * Class m190616_144228_add_field_payment_in_process_to_clientext
 */
class m190616_144228_add_field_payment_in_process_to_clientext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'payment_in_process', $this->boolean()->defaultValue(0)->comment('Платеж обрабатывается')->after('penalty_cash_back'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'payment_in_process');
    }
}
