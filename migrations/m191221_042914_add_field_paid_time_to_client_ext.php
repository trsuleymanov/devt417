<?php

use yii\db\Migration;

/**
 * Class m191221_042914_add_field_paid_time_to_client_ext
 */
class m191221_042914_add_field_paid_time_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'paid_time', $this->integer()->comment('Телефон подтвержден')->after('phone'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'paid_time');
    }
}
