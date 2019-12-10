<?php

use yii\db\Migration;

/**
 * Class m190822_112310_add_field_fio_to_client_ext
 */
class m190822_112310_add_field_fio_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'fio', $this->string(100)->comment('ФИО')->after('user_id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'fio');
    }
}
