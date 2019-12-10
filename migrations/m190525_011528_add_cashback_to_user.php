<?php

use yii\db\Migration;

/**
 * Class m190525_011528_add_cashback_to_user
 */
class m190525_011528_add_cashback_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'cashback', $this->decimal(8, 2)->defaultValue(0)->comment('Кэш-бэк счет')->after('phone'));
    }

    public function down()
    {
        $this->dropColumn('user', 'cashback');
    }
}
