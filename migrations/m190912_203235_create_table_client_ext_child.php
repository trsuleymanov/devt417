<?php

use yii\db\Migration;

/**
 * Class m190912_203235_create_table_client_ext_child
 */
class m190912_203235_create_table_client_ext_child extends Migration
{
    public function up()
    {
        $this->createTable('client_ext_child', [
            'id' => $this->primaryKey(),
            'clientext_id' => $this->integer()->comment('Заказ'),
            'age' => "ENUM('<1', '1-2', '3-6', '7-10')",
            'self_baby_chair' => $this->boolean()->defaultValue(0)->comment('Свое детское кресло'),
        ]);
    }

    public function down()
    {
        $this->dropTable('client_ext_child');
    }
}
