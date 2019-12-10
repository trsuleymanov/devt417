<?php

use yii\db\Migration;

/**
 * Class m190825_162211_add_field_but_checkout_to_client_ext
 */
class m190825_162211_add_field_but_checkout_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'but_checkout', "ENUM('payment','reservation') after penalty_cash_back");
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'but_checkout');
    }
}
