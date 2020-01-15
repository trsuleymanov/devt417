<?php

namespace app\models;

use yii\base\Model;
use yii\web\ForbiddenHttpException;


class InputPhoneForm extends Model {

    public $mobile_phone;
    public $mobile_phone2;

    public function rules()
    {
        return [
            [['mobile_phone',], 'required'],
            [['mobile_phone', 'mobile_phone2'], 'string', 'max' => 20],
            [['mobile_phone', ], 'checkPhone', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mobile_phone' => 'Телефон',
            'mobile_phone2' => 'Телефон',
        ];
    }

    public function checkPhone($attribute)
    {
        $settings = Setting::find()->where(['id' => 1])->one();
        if($settings->disable_number_validation == true) {
            return true;
        }

        // может быть формат: +7 (966) 112 80 06
        if( strpos($this->$attribute, '+7 (9') === false ) {

            $this->addError($attribute, 'Проверьте правильность ввода номера. Мы работаем только с мобильными операторами из России');

        } elseif (!preg_match('/^\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2} [0-9]{2}$/', $this->$attribute)) {
            //$this->addError($attribute, 'Телефон должен быть в формате +7-***-***-****');
            $this->addError($attribute, 'Телефон должен быть в формате +7 (***) *** ** **');
        } else {
            return true;
        }
    }
}