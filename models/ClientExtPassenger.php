<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "passenger".
 *
 * @property int $id
 * @property int $order_id Заказ
 * @property int $passenger_id Пассажир
 */
class ClientExtPassenger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_ext_passenger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_ext_id', 'passenger_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_ext_id' => 'Заказ',
            'passenger_id' => 'Пассажир',
        ];
    }


    public function getClientExt()
    {
        return $this->hasOne(ClientExt::className(), ['id' => 'client_ext_id']);
    }

    public function getPassenger()
    {
        return $this->hasOne(Passenger::className(), ['id' => 'passenger_id']);
    }
}
