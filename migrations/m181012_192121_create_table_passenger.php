<?php

use yii\db\Migration;

/**
 * Class m181012_192121_create_table_passenger
 */
class m181012_192121_create_table_passenger extends Migration
{
    public function up()
    {
        $this->createTable('passenger', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->comment('Создан'),
            'client_id' => $this->integer()->defaultValue(0)->comment('Клиент'),
            'tariff_type' => $this->string(20)->comment('Тип тарифа: обычный, ребенок, студент,...'),
            'fio' => $this->string(100)->comment('ФИО'),
            'gender' => $this->boolean()->defaultValue(0)->comment('Пол'), // нужен список конечный в модели
            'date_of_birth' => $this->integer()->comment('Дата рождения'),
            'document_type' => "ENUM('passport', 'birth_certificate', 'international_passport', 'foreign_passport')",
            'citizenship' => $this->string(50)->comment('Гражданство'), // нужен список предложений
            'series_number' => $this->string(20)->comment('Серия и номер документа'),
        ]);
    }

    public function down()
    {
        $this->dropTable('passenger');
    }
}
