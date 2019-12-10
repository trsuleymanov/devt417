<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "new_year_request".
 *
 * @property int $id
 * @property int $created_at Создан
 * @property string $direction Направление
 * @property int $mktime_date Время выезда
 * @property string $time Время выезда
 * @property string $date Дата выезда
 * @property string $phone Телефон
 * @property string $time_for_call Время для звонка
 */
class NewYearRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'new_year_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'sync_date'], 'integer'],
            [['direction', 'date', 'time', 'time_for_call', 'phone'], 'required'],
            [['direction'], 'string', 'max' => 100],
            [['time', 'time_for_call'], 'string', 'max' => 50],
            [['date'], 'string', 'max' => 10],
            [['phone'], 'string', 'max' => 15],
            [['phone'], 'checkPhone'],
            //[['mktime_date'], 'safe']
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
            'direction' => 'Направление',
            //'mktime_date' => 'Время выезда',
            'time' => 'Время выезда',
            'date' => 'Дата выезда',
            'phone' => 'Телефон',
            'time_for_call' => 'Время для звонка',
            'sync_date' => 'Время выгрузки заявки на основной сервер',
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }

        return parent::beforeSave($insert);
    }


    public function checkPhone($attribute)
    {
        if (!preg_match('/^\+7\-[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен быть в формате +7-***-***-****');
        }else {
            return true;
        }
    }

    public function getAccessCode() {
        return md5($this->id.'dskljtl_w934SDf');
    }
}
