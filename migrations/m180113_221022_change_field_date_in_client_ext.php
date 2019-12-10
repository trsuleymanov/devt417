<?php

use yii\db\Migration;

/**
 * Class m180113_221022_change_field_date_in_client_ext
 */
class m180113_221022_change_field_date_in_client_ext extends Migration
{
    public function up()
    {
        $this->alterColumn('client_ext', 'data', $this->string(10)->comment('Дата'));
    }

    public function down()
    {
        $this->alterColumn('client_ext', 'data', $this->string(8)->comment('Дата'));
    }
}
