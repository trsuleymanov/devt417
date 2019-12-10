<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property int $count_hours_before_trip_to_cancel_order Количество часов до первой точки рейса, меньше которых запрещено отменять заказ
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count_hours_before_trip_to_cancel_order', 'max_time_short_trip_AK', 'max_time_short_trip_KA',
                'reg_time_limit'], 'integer'],
            [['phone_number'], 'string', 'min' => 6, 'max' => 20],
            ['disable_number_validation', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count_hours_before_trip_to_cancel_order' => 'Количество часов до первой точки рейса, меньше которых запрещено отменять заказ',
            'max_time_short_trip_AK' => 'Максимальное время короткого сбора для АК',
            'max_time_short_trip_KA' => 'Максимальное время короткого сбора для КА',

            'phone_number' => 'Номер телефона',
            'reg_time_limit' => 'Время в течение которого можно позвонить на номер подтверждения при регистрации, сек',
            'disable_number_validation' => 'Отключить валидацию номеров',
        ];
    }

    public function setField($field_name, $field_value)
    {
        if(!empty($field_value)) {
            $field_value = htmlspecialchars($field_value);
        }

        if($field_value === false) {
            $sql = 'UPDATE `'.self::tableName().'` SET '.$field_name.' = false WHERE id = '.$this->id;
        }elseif(empty($field_value)) {
            $sql = 'UPDATE `'.self::tableName().'` SET '.$field_name.' = NULL WHERE id = '.$this->id;
        }else {
            $sql = 'UPDATE `'.self::tableName().'` SET '.$field_name.' = "'.$field_value.'" WHERE id = '.$this->id;
        }

        $res = Yii::$app->db->createCommand($sql)->execute();
        return $res;
    }
}
