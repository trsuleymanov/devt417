<?php

use yii\db\Migration;

/**
 * Class m200207_154311_add_fields_to_trip
 */
class m200207_154311_add_fields_to_trip2 extends Migration
{
    public function up()
    {
        $this->addColumn('trip', 'date_start_sending', $this->integer()->comment('Время начала отправки машины')->after('end_time_unixtime'));
        $this->addColumn('trip', 'date_issued_by_operator', $this->integer()->comment('Дата выпуска рейса оператором')->after('date_start_sending'));
        $this->addColumn('trip', 'date_sended', $this->integer()->comment('Дата/время отправки рейса')->after('date_issued_by_operator'));
    }

    public function down()
    {
        $this->dropColumn('trip', 'date_sended');
        $this->dropColumn('trip', 'date_issued_by_operator');
        $this->dropColumn('trip', 'date_start_sending');
    }
}
