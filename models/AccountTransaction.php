<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;

/**
 * This is the model class for table "account_transaction".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property string $money Сумма перевода в рублях
 * @property int $operation_type 0 - списание со счета, 1 - начисление на счет
 * @property int $created_at Время создания
 * @property int $clientext_id id заявки связанной с начислением или со списанием со счета
 */
class AccountTransaction extends \yii\db\ActiveRecord
{
    // сколько получает пользователь на счет за привод друга в систему
    public static $friend_bonus = 200.00;


    public static function tableName()
    {
        return 'account_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'operation_type', 'created_at', 'clientext_id'], 'integer'],
            [['money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'money' => 'Деньги',
            'operation_type' => 'Тип операций',
            'created_at' => 'Дата создания',
            'clientext_id' => 'Заявка',
        ];
    }

    public static function getOperationTypes() {
        return [
            0 => 'списание со счета',
            1 => 'начисление на счет'
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }else {
            throw new ErrorException('Изменение существующей транзакции невозможно');
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        $user = $this->user;
        if($user == null) {
            throw new ErrorException('Не найден друг для начисления бонуса');
        }
        if($this->operation_type == 1) { // увеличим счет пользователя
            $user->account = $user->account + doubleval($this->money);
        }else { // уменьшим счет пользователя
            $user->account = $user->account - doubleval($this->money);
        }
        $user->setField('account', $user->account);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
