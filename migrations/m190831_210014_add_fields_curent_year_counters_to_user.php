<?php

use yii\db\Migration;

/**
 * Class m190831_210014_add_fields_curent_year_counters_to_user
 */
class m190831_210014_add_fields_curent_year_counters_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'current_year_sended_places', $this->smallInteger(2)->defaultValue(0)->comment('Число отправленных мест')->after('cashback'));
        $this->addColumn('user', 'current_year_sended_prize_places', $this->smallInteger(2)->defaultValue(0)->comment('Число отправленных призовых поездок в текущем году')->after('current_year_sended_places'));
        $this->addColumn('user', 'current_year_penalty', $this->smallInteger(2)->defaultValue(0)->comment('Число штрафов в текущем году')->after('current_year_sended_prize_places')->after('current_year_sended_prize_places'));
    }

    public function down()
    {
        $this->dropColumn('user', 'current_year_sended_places');
        $this->dropColumn('user', 'current_year_sended_prize_places');
        $this->dropColumn('user', 'current_year_penalty');
    }
}
