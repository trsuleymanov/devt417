<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_ext_child".
 *
 * @property int $id
 * @property int $clientext_id Заказ
 * @property string $age
 * @property int $self_baby_chair Свое детское кресло
 */
class ClientExtChild extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'client_ext_child';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clientext_id', 'self_baby_chair'], 'integer'],
            [['age'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clientext_id' => 'Заказ',
            'age' => 'Возраст',
            'self_baby_chair' => 'Свое детское кресло',
        ];
    }

//    public static function getAges() {
//        return [
//            '<1' => "Меньше года",
//            '1-2' => "От 1 до 2 лет",
//            '3-6' => "От 3 до 6 лет",
//            '7-10' => "От 7 до 10 лет",
//        ];
//    }

    public static function getAges() {

        return [
            '<1' => "Младенец в люльке",
            '1-7' => "Ребенок от года до семи",
            '>7' => "Ребенок старше 7 лет"
        ];
    }

    public function getAgeName() {
        return (isset(self::getAges()[$this->age]) ? self::getAges()[$this->age] : '');
    }
}
