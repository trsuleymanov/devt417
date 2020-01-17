<?php

use yii\db\Migration;

/**
 * Class m200116_192851_add_field_registration_code_created_at_to_current_reg
 */
class m200116_192851_add_field_registration_code_created_at_to_current_reg extends Migration
{
    public function up()
    {
        $this->addColumn('current_reg', 'registration_code_created_at', $this->integer()->comment('Время создания регистрационного кода')->after('registration_code'));
    }

    public function down()
    {
        $this->dropColumn('current_reg', 'registration_code_created_at');
    }
}
