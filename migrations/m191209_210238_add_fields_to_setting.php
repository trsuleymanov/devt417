<?php

use yii\db\Migration;

/**
 * Class m191209_210238_add_fields_to_setting
 */
class m191209_210238_add_fields_to_setting extends Migration
{
    public function up()
    {
        $this->addColumn('setting', 'phone_number', $this->string(20)->comment('Номер телефона')->after('max_time_short_trip_KA'));
        $this->addColumn('setting', 'reg_time_limit', $this->smallInteger()->defaultValue(300)->comment('Время в течение которого можно позвонить на номер подтверждения при регистрации, сек')->after('phone_number'));
        $this->addColumn('setting', 'disable_number_validation', $this->boolean()->defaultValue(false)->comment('Отключить валидацию номеров')->after('reg_time_limit'));
    }

    public function down()
    {
        $this->dropColumn('setting', 'phone_number');
        $this->dropColumn('setting', 'reg_time_limit');
        $this->dropColumn('setting', 'disable_number_validation');
    }
}
