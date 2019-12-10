<?php

use yii\db\Migration;

/**
 * Class m180210_054125_add_field_price_to_client_ext
 */
class m180210_054125_add_field_price_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'price', $this->decimal(8, 2)->defaultValue(0)->comment('Цена')->after('places_count'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'price');
    }
}
