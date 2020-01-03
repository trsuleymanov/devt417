<?php

use yii\db\Migration;

/**
 * Class m191228_074347_add_field_loyalty_switch_to_setting
 */
class m191228_074347_add_field_loyalty_switch_to_setting extends Migration
{
    public function up()
    {
        $this->addColumn('setting', 'loyalty_switch', "ENUM('cash_back_on', 'fifth_place_prize') DEFAULT 'fifth_place_prize' AFTER disable_number_validation");
    }

    public function down()
    {
        $this->dropColumn('setting', 'loyalty_switch');
    }
}
