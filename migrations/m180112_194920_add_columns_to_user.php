<?php

use yii\db\Migration;

/**
 * Class m180112_194920_add_columns_to_user
 */
class m180112_194920_add_columns_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'last_login_date', $this->integer()->comment('Время последней попытки входа на сайт')->after('main_server_client_id'));
        $this->addColumn('user', 'last_ip', $this->string(20)->comment('IP адрес (последнего входа на сайт)')->after('phone'));
        $this->addColumn('user', 'attempt_count', $this->smallInteger(6)->defaultValue(0)->comment('Количество неудачных попыток последнего входа на сайт ')->after('last_ip'));
        $this->addColumn('user', 'attempt_date', $this->integer()->comment('Время последней попытки входа на сайт')->after('attempt_count'));
        $this->addColumn('user', 'blocked', $this->smallInteger(1)->defaultValue(0)->comment('Заблокирован')->after('sync_date'));
    }

    public function down()
    {
        $this->dropColumn('user', 'blocked');
        $this->dropColumn('user', 'attempt_date');
        $this->dropColumn('user', 'attempt_count');
        $this->dropColumn('user', 'last_ip');
        $this->dropColumn('user', 'last_login_date');
    }
}
