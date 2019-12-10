<?php

use yii\db\Migration;

/**
 * Class m190821_085858_add_fields_to_yandex_point
 */
class m190821_085858_add_fields_to_yandex_point extends Migration
{
    public function up()
    {
        $this->addColumn('yandex_point', 'point_of_arrival', $this->boolean()->defaultValue(0)->after('long')->comment('Является точкой прибытия'));
        $this->addColumn('yandex_point', 'critical_point', $this->boolean()->defaultValue(0)->after('point_of_arrival')->comment('Критическая точка'));
        $this->addColumn('yandex_point', 'alias', $this->string(10)->defaultValue('')->comment('Доп.поле означающее принадлежность точки к чему-либо, например к аэропорту')->after('critical_point'));
    }

    public function down()
    {
        $this->dropColumn('yandex_point', 'alias');
        $this->dropColumn('yandex_point', 'critical_point');
        $this->dropColumn('yandex_point', 'point_of_arrival');
    }
}
