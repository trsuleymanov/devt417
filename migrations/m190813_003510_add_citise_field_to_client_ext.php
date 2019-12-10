<?php

use yii\db\Migration;

/**
 * Class m190813_003510_add_citise_field_to_client_ext
 */
class m190813_003510_add_citise_field_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'city_from_id', $this->integer()->after('email'));
        $this->addColumn('client_ext', 'city_to_id', $this->integer()->after('city_from_id'));
        $this->dropColumn('client_ext', 'direction');
        $this->addColumn('client_ext', 'direction_id', $this->integer()->after('city_to_id'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'city_from_id');
        $this->dropColumn('client_ext', 'city_to_id');
        $this->dropColumn('client_ext', 'direction_id');
        $this->addColumn('client_ext', 'direction', $this->string(50)->comment('Направление')->after('email'));
    }
}
