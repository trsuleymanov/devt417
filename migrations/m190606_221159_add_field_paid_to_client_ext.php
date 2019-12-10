<?php

use yii\db\Migration;

/**
 * Class m190606_221159_add_field_paid_to_client_ext
 */
class m190606_221159_add_field_paid_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'paid_summ', $this->decimal(8, 2)->defaultValue(0)->comment('Оплачено')->after('price'));
        $this->addColumn('client_ext', 'is_paid', $this->boolean()->defaultValue(0)->comment('Заказ оплачен (да/нет)')->after('penalty_cash_back'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'paid_summ');
        $this->dropColumn('client_ext', 'is_paid');
    }
}
