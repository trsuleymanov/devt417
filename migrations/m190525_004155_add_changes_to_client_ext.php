<?php

use yii\db\Migration;

/**
 * Class m190525_004155_add_changes_to_client_ext
 */
class m190525_004155_add_changes_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'source_type', "ENUM('client_site', 'main_site', 'application') after id");
        $this->addColumn('client_ext', 'accrual_cash_back', $this->decimal(8, 2)->defaultValue(0)->comment('Начисление кэш-бэка')->after('price'));
        $this->addColumn('client_ext', 'used_cash_back', $this->decimal(8, 2)->defaultValue(0)->comment('Использованный кэш-бэк для оплаты заказа')->after('accrual_cash_back'));
        $this->addColumn('client_ext', 'penalty_cash_back', $this->decimal(8, 2)->defaultValue(0)->comment('Списанный кэш-бэк как штраф')->after('used_cash_back'));


        $this->dropColumn('client_ext', 'street_from');
        $this->dropColumn('client_ext', 'point_from');
        $this->dropColumn('client_ext', 'street_to');
        $this->dropColumn('client_ext', 'point_to');
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'source_type');
        $this->dropColumn('client_ext', 'accrual_cash_back');
        $this->dropColumn('client_ext', 'penalty_cash_back');
        $this->dropColumn('client_ext', 'used_cash_back');

        $this->addColumn('client_ext', 'street_from', $this->string(50)->comment('Улица откуда')->after('trip_name'));
        $this->addColumn('client_ext', 'point_from', $this->string(50)->comment('Точка откуда')->after('street_from'));
        $this->addColumn('client_ext', 'street_to', $this->string(50)->comment('Улица куда')->after('point_from'));
        $this->addColumn('client_ext', 'point_to', $this->string(50)->comment('Точка куда')->after('street_to'));
    }
}
