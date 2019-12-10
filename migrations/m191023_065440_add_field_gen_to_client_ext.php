<?php

use yii\db\Migration;

/**
 * Class m191023_065440_add_field_gen_to_client_ext
 */
class m191023_065440_add_field_gen_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'gen', "ENUM('female', 'male') after email");
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'gen');
    }
}
