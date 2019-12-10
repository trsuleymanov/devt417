<?php

use yii\db\Migration;

/**
 * Class m180415_153728_create_table_direction
 */
class m180415_153728_create_table_direction extends Migration
{
    public function up()
    {
        $this->createTable('direction', [ // направления
            'id' => $this->primaryKey(),
            'sh_name' => $this->string(20)->comment('Название'),
            'city_from' => $this->integer()->comment('Город отправления'),
            'city_to' => $this->integer()->comment('Город прибытия'),
            'distance'  => $this->smallInteger()->comment('Дистанция, км'),
            'created_at' => $this->integer()->comment('Время создания'),
            'updated_at' => $this->integer()->comment('Время изменения'),
        ]);

        $this->BatchInsert('direction',
            ['sh_name', 'city_from', 'city_to', 'distance', 'created_at'],
            [
                ['АК', 2, 1, 270, time()],
                ['КА', 1, 2, 270, time()],
            ]
        );
    }

    public function down()
    {
        $this->dropTable('direction');
    }
}
