<?php

use yii\db\Migration;

/**
 * Class m180417_042226_add_field_discount_to_client_ext
 */
class m180417_042226_add_field_discount_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'discount', $this->decimal(8, 2)->defaultValue(0)->comment('Скидка в рублях')->after('price'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'discount');
    }
}
