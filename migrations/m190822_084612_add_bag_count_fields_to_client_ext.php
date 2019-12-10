<?php

use yii\db\Migration;

/**
 * Class m190822_084612_add_bag_count_fields_to_client_ext
 */
class m190822_084612_add_bag_count_fields_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'suitcase_count', $this->smallInteger()->comment('Количество больших чемоданов')->after('places_count'));
        $this->addColumn('client_ext', 'bag_count', $this->smallInteger()->comment('Количество ручной клади')->after('suitcase_count'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'suitcase_count');
        $this->dropColumn('client_ext', 'bag_count');
    }
}
