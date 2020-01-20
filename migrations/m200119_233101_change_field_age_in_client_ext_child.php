<?php

use yii\db\Migration;

/**
 * Class m200119_233101_change_field_age_in_client_ext_child
 */
class m200119_233101_change_field_age_in_client_ext_child extends Migration
{
    public function up()
    {
        $this->dropTable('client_ext_child');

        $this->createTable('client_ext_child', [
            'id' => $this->primaryKey(),
            'clientext_id' => $this->integer()->comment('Заказ'),
            'age' => "ENUM('<1', '1-7', '>7')",
            'self_baby_chair' => $this->boolean()->defaultValue(0)->comment('Свое детское кресло'),
        ]);
    }

    public function down()
    {
        $this->dropTable('client_ext_child');

        $this->createTable('client_ext_child', [
            'id' => $this->primaryKey(),
            'clientext_id' => $this->integer()->comment('Заказ'),
            'age' => "ENUM('<1', '1-2', '3-6', '7-10')",
            'self_baby_chair' => $this->boolean()->defaultValue(0)->comment('Свое детское кресло'),
        ]);
    }
}
