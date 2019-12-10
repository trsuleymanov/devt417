<?php

use yii\db\Migration;

/**
 * Class m180331_101302_create_and_fill_table_city
 */
class m180331_101302_create_and_fill_table_city extends Migration
{
    public function up()
    {
        $this->createTable('city', [ // Города
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Название'),
            'center_lat' => $this->double()->defaultValue(0)->comment('Широта'),
            'center_long' => $this->double()->defaultValue(0)->comment('Долгота'),
            'map_scale'  => $this->smallInteger()->defaultValue(10)->comment('Масштаб яндекс карты'),
            'search_scale' => $this->smallInteger(6)->defaultValue(16)->comment('Приближение карты при поиске'),
            'point_focusing_scale' => $this->smallInteger(6)->defaultValue(12)->comment('Масштаб фокусировки точки'),
            'all_points_show_scale' => $this->smallInteger(6)->defaultValue(12)->comment('Масшаб карты на котором появляются все точки'),
        ]);

        // `name`, `city_id`, `lat`, `long`
        $aCities = [
            [1, 'Казань', 55.79, 49.11, 10, 16, 12, 15],
            [2, 'Альметьевск', 54.9, 52.3, 12, 16, 16, 14],
        ];

        $this->BatchInsert('city', ['id', 'name', 'center_lat', 'center_long', 'map_scale', 'search_scale', 'point_focusing_scale', 'all_points_show_scale'], $aCities);
    }

    public function down()
    {
        $this->dropTable('city');
    }
}
