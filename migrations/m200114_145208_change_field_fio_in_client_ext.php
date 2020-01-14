<?php

use yii\db\Migration;

/**
 * Class m200114_145208_change_field_fio_in_client_ext
 */
class m200114_145208_change_field_fio_in_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'last_name', $this->string(30)->comment('Фамилия')->after('fio'));
        $this->addColumn('client_ext', 'first_name', $this->string(60)->comment('Имя (иногда это: имя + отчество)')->after('last_name'));

        $this->addColumn('user', 'last_name', $this->string(30)->comment('Фамилия')->after('fio'));
        $this->addColumn('user', 'first_name', $this->string(60)->comment('Имя (иногда это: имя + отчество)')->after('last_name'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'first_name');
        $this->dropColumn('client_ext', 'last_name');

        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
    }
}
