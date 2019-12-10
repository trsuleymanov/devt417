<?php

use yii\db\Migration;

/**
 * Class m180416_130450_create_table_account_transaction
 */
class m180416_130450_create_table_account_transaction extends Migration
{
    public function up()
    {
        $this->createTable('account_transaction', [ // денежные транзакции
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment('Пользователь'),
            'money' => $this->decimal(8, 2)->defaultValue(0)->comment('Сумма перевода в рублях'),
            'operation_type' => $this->boolean()->comment('0 - списание со счета, 1 - начисление на счет'),
            'created_at' => $this->integer()->comment('Время создания'),
            'clientext_id' => $this->integer()->comment('id заявки связанной с начислением или со списанием со счета'),
        ]);
    }

    public function down()
    {
        $this->dropTable('account_transaction');
    }
}
