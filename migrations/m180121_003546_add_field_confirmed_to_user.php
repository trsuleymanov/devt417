<?php

use yii\db\Migration;


class m180121_003546_add_field_confirmed_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'confirmed', $this->boolean()->defaultValue(false)->comment('Подтвержден')->after('attempt_date'));
    }

    public function down()
    {
        $this->dropColumn('user', 'confirmed');
    }
}
