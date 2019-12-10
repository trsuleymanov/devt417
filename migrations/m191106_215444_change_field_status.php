<?php

use app\models\ClientExt;
use yii\db\Migration;

/**
 * Class m191106_215444_change_field_status
 */
class m191106_215444_change_field_status extends Migration
{
    public function up()
    {
        // были:  created, canceled, pending_call, pending_send, sended
        // будут: created_with_time_confirm, created_without_time_confirm, canceled_by_client, canceled_by_operator,
        //          canceled_auto, created_with_time_sat, sended,
        //$this->alterColumn('client_ext', 'status', $this->string(15)->defaultValue('')->comment('Статус'));

        // $this->renameColumn('client_ext', 'status', 'status_old');
        $this->dropColumn('client_ext', 'status');
        $this->addColumn('client_ext', 'status', "ENUM('', 'created_with_time_confirm', 'created_without_time_confirm', 'canceled_by_client', 'canceled_by_operator', 'canceled_auto', 'created_with_time_sat', 'sended') DEFAULT '' after main_server_order_id");
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'status');
        $this->addColumn('client_ext', 'status', $this->string(15)->defaultValue('')->comment('Статус')->after('main_server_order_id'));
        // $this->renameColumn('client_ext', 'status_old', 'status');
    }
}
