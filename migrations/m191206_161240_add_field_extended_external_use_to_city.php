<?php

use yii\db\Migration;

/**
 * Class m191206_161240_add_field_extended_external_use_to_city
 */
class m191206_161240_add_field_extended_external_use_to_city extends Migration
{
    public function up()
    {
        $this->addColumn('city', 'extended_external_use', $this->boolean()->defaultValue(false)->comment('Расширенное внешнее использование')->after('name'));
    }

    public function down()
    {
        $this->dropColumn('city', 'extended_external_use');
    }
}
