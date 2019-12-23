<?php

use yii\db\Migration;

/**
 * Class m191219_134913_add_field_cancellation_click_time_to_clientext
 */
class m191219_134913_add_field_cancellation_click_time_to_clientext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'cancellation_click_time', $this->integer()->comment('Время отмены')->after('status_setting_time'));
        $this->addColumn('client_ext', 'cancellation_clicker_id', $this->integer()->comment('Пользователь совершивший отмену')->after('cancellation_click_time'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'cancellation_click_time');
        $this->dropColumn('client_ext', 'cancellation_clicker_id');
    }
}
