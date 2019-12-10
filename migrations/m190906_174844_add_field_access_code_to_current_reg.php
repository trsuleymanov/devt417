<?php

use yii\db\Migration;

/**
 * Class m190906_174844_add_field_access_code_to_current_reg
 */
class m190906_174844_add_field_access_code_to_current_reg extends Migration
{
    public function up()
    {
        $this->addColumn('current_reg', 'access_code', $this->string(32)->defaultValue(false)->comment('Уникальный код доступа к регистрации')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('current_reg', 'access_code');
    }
}
