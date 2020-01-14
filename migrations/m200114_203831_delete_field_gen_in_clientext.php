<?php

use yii\db\Migration;

/**
 * Class m200114_203831_delete_field_gen_in_clientext
 */
class m200114_203831_delete_field_gen_in_clientext extends Migration
{
    public function up()
    {
        $this->dropColumn('client_ext', 'gen');
    }

    public function down()
    {
        $this->addColumn('client_ext', 'gen', "ENUM('female', 'male') after email");
    }
}
