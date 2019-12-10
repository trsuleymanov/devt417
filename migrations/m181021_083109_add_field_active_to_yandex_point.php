<?php

use yii\db\Migration;

/**
 * Class m181021_083109_add_field_active_to_yandex_point
 */
class m181021_083109_add_field_active_to_yandex_point extends Migration
{
    public function up()
    {
        $this->addColumn('yandex_point', 'active', $this->boolean()->defaultValue(false)->comment('Активна')->after('id'));
    }

    public function down()
    {
        $this->dropColumn('yandex_point', 'active');
    }
}
