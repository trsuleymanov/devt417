<?php

use yii\db\Migration;

/**
 * Class m181014_173544_change_field_data_in_client_ext
 */
class m181014_173544_change_field_data_in_client_ext extends Migration
{
    public function up()
    {
        //$this->alterColumn('client_ext', 'data', $this->integer()->comment('Дата'));
        $this->dropColumn('client_ext', 'data');
        $this->addColumn('client_ext', 'data', $this->integer()->comment('Дата')->after('direction'));
    }

    public function down()
    {
        //$this->alterColumn('client_ext', 'data', $this->string(10)->comment('Дата'));
        $this->dropColumn('client_ext', 'data');
        $this->addColumn('client_ext', 'data', $this->string(10)->comment('Дата')->after('direction'));
    }
}
