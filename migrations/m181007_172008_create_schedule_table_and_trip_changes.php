<?php

use app\models\Direction;
use app\models\Schedule;
use yii\db\Migration;

/**
 * Class m181007_172008_create_schedule_table_and_trip_changes
 */
class m181007_172008_create_schedule_table_and_trip_changes extends Migration
{
    public function up()
    {
        $this->createTable('schedule', [ // список расписаний
            'id' => $this->primaryKey(),
            'direction_id' => $this->integer()->comment('Направление'),
            'name' => $this->string(50)->comment('Название'),
            'start_date' => $this->integer()->comment('Дата запуска расписания'),
            'disabled_date' => $this->integer()->comment('Дата деактивации расписания'),
        ]);

        $directions = Direction::find()->all();
        foreach($directions as $direction) {
            $this->BatchInsert('schedule', ['direction_id', 'name', 'start_date'], [
                [$direction->id, 'Стандартное расписание', 1],
            ]);
        }


        $this->createTable('schedule_trip', [ // новая таблица рейсов статических
            'id' => $this->primaryKey(),
            'schedule_id' => $this->integer()->comment('Расписание'),
            'name' => $this->string(50)->comment('Название'),
            'start_time' => $this->string(5)->comment('Начало сбора'),
            'mid_time' => $this->string(5)->comment('Середина сбора'),
            'end_time' => $this->string(5)->comment('Конец сбора'),
        ]);

        $schedules = Schedule::find()->all();
        foreach($schedules as $schedule) {

            // {3:30, 4:00, 5:00, 6:00, 8:00, 10:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00,
            // 18:00, 19:00, 20:00, 21:00}
            $this->BatchInsert('schedule_trip',
                ['schedule_id', 'name', 'start_time', 'mid_time', 'end_time'],
                [
                    [$schedule->id, '3:30', '02:30', '3:00',  '03:30'],
                    [$schedule->id, '4:00', '03:00', '03:30', '04:00'],
                    [$schedule->id, '5:00', '04:00', '04:30', '05:00'],
                    [$schedule->id, '6:00', '05:00', '05:30', '06:00'],
                    [$schedule->id, '8:00', '07:00', '07:30', '08:00'],
                    [$schedule->id, '10:00','09:00', '09:30', '10:00'],
                    [$schedule->id, '12:00','11:00', '11:30', '12:00'],
                    [$schedule->id, '13:00','12:00', '12:30', '13:00'],
                    [$schedule->id, '14:00','13:00', '13:30', '14:00'],
                    [$schedule->id, '15:00','14:00', '14:30', '15:00'],
                    [$schedule->id, '16:00','15:00', '15:30', '16:00'],
                    [$schedule->id, '17:00','16:00', '16:30', '17:00'],
                    [$schedule->id, '18:00','17:00', '17:30', '18:00'],
                    [$schedule->id, '19:00','18:00', '18:30', '19:00'],
                    [$schedule->id, '20:00','19:00', '19:30', '20:00'],
                    [$schedule->id, '21:00','20:00', '20:30', '21:00'],
                ]
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('schedule_trip');
        $this->dropTable('schedule');
    }
}
