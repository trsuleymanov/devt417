<?php

use yii\db\Migration;

/**
 * Class m191226_144951_add_field_payment_source_to_order
 */
class m191226_144951_add_field_payment_source_to_order extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'payment_source', "ENUM('client_site', 'application', 'crm', '') DEFAULT '' AFTER is_paid");
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'payment_source');
    }
}
