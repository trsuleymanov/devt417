<?php

use yii\db\Migration;

/**
 * Class m191128_042737_add_field_input_mobile_at_to_current_reg
 */
class m191128_042737_add_field_input_mobile_at_to_current_reg extends Migration
{
    public function up()
    {
        $this->addColumn('current_reg', 'input_mobile_at', $this->integer()->comment('Время ввода телефона при регистрации')->after('mobile_phone'));
    }

    public function down()
    {
        $this->dropColumn('current_reg', 'input_mobile_at');
    }
}
