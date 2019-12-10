<?php

use app\models\Setting;
use yii\db\Migration;

/**
 * Class m190624_191322_create_table_setting
 */
class m190624_191322_create_table_setting extends Migration
{
    /**
     * @return bool|void
     * @throws ErrorException
     */
    public function up()
    {
        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'count_hours_before_trip_to_cancel_order' => $this->smallInteger()->comment('Количество часов до первой точки рейса, меньше которых запрещено отменять заказ')
        ]);

        $setting = new Setting();
        $setting->count_hours_before_trip_to_cancel_order = 1;
        if(!$setting->save(false)){
            throw new ErrorException('Не удалось сохранить настройки');
        }
    }

    public function down()
    {
        $this->dropTable('setting');
    }
}
