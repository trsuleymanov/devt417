<?php

use yii\db\Migration;

/**
 * Class m190912_193622_add_places_counts_fields_to_client_ext
 */
class m190912_193622_add_places_counts_fields_to_client_ext extends Migration
{
    public function up()
    {
        $this->addColumn('client_ext', 'student_count', $this->smallInteger(2)->comment('Количество мест студентов')->after('places_count'));
        $this->addColumn('client_ext', 'child_count', $this->smallInteger(2)->comment('Количество детских мест')->after('student_count'));
    }

    public function down()
    {
        $this->dropColumn('client_ext', 'student_count');
        $this->dropColumn('client_ext', 'child_count');
    }
}
