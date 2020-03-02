<?php

use yii\db\Migration;

/**
 * Class m200302_205048_change_order_status
 */
class m200302_205048_change_order_status extends Migration
{
    public function up()
    {
        $this->alterColumn('client_ext', 'status', "ENUM('', 'created_with_time_confirm', 'created_without_time_confirm', 'canceled_not_ready_order_by_client', 'canceled_not_ready_order_auto', 'canceled_by_client', 'canceled_by_operator', 'created_with_time_sat', 'sended') DEFAULT '' after main_server_order_id");
    }

    public function down()
    {
        $this->alterColumn('client_ext', 'status', "ENUM('', 'created_with_time_confirm', 'created_without_time_confirm', 'canceled_by_client', 'canceled_by_operator', 'canceled_auto', 'created_with_time_sat', 'sended') DEFAULT '' after main_server_order_id");
    }
}
