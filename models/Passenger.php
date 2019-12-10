<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "passenger".
 *
 * @property int $id
 * @property int $created_at Создан
 * @property int $client_id Клиент
 * @property string $fio ФИО
 * @property int $gender Пол
 * @property int $date_of_birth Дата рождения
 * @property string $document_type
 * @property string $citizenship Гражданство
 * @property string $series_number Серия и номер документа
 */
class Passenger extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'passenger';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'date_of_birth', 'document_type', 'fio', 'series_number', /*'tariff_type'*/], 'required'],
            [['created_at', 'client_id', 'gender', 'date_of_birth'], 'integer'],
            [['document_type'], 'string'],
            [['fio'], 'string', 'max' => 100],
            [['citizenship'], 'string', 'max' => 50],
            [['series_number', /*'tariff_type'*/], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'client_id' => 'Клиент',
            //'tariff_type' => 'Тип тарифа: полный, студент, ребенок,...',
            'fio' => 'ФИО',
            'gender' => 'Пол',
            'date_of_birth' => 'Дата рождения',
            'document_type' => 'Тип документа',
            'citizenship' => 'Гражданство',
            'series_number' => 'Серия и номер документа',
        ];
    }


//    public static function getTariffTypes() {
//
//        return [
//            'standart' => 'Обычный тариф',
//            'student' => 'Студенческий тариф',
//            'child' => 'Детский тариф'
//        ];
//    }

//    public static function getTariffsPrices() {
//
//        return [
//            'standart' => 500,
//            'student' => 450,
//            'child' => 400
//        ];
//    }

    public static function getGenders() {

        return [
            0 => 'Женский',
            1 => 'Мужской',
        ];
    }

    public static function getDocumentTypes() {

        return [
            'passport' => 'Паспорт',
            'birth_certificate' => 'Свидетельство о рождении',
            'international_passport' => 'Заграничный паспорт',
            'foreign_passport' => 'Иностранный паспорт',
        ];
    }

    public static function getDocumentTypesPlaceholders() {

        return [
            'passport' => '1234 123456',
            'birth_certificate' => 'VI-БА № 123456',
            'international_passport' => '12 321123',
            'foreign_passport' => '',
        ];
    }


    public function getClientExtPassengers()
    {
        return $this->hasMany(ClientExtPassenger::className(), ['passenger_id' => 'id']);
    }

}
