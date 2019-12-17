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

    public static function isValidWebMobile($mobile) {

        return preg_match('/^\+7 \([0-9]{3}\) [0-9]{3} [0-9]{2} [0-9]{2}$/', $mobile);
    }


    public static function convertWebToDBMobile($web_mobile_phone) {

        // надо телефон из формата +7 (966) 112 80 06 конвертировать в +7-966-112-8006
        $phone = str_replace('(', '', $web_mobile_phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '-', $phone);

        $del_symbol_start = strrpos($phone, '-');
        $phone = substr($phone, 0, $del_symbol_start).substr($phone, $del_symbol_start + 1);

        return $phone;
    }

    public static function convertRandomWebToDBMobile($web_mobile_phone) {

        // нужно из формата +734535353545646 преобразовать в +7-966-112-8006
        $phone = substr($web_mobile_phone, 0, 2).'-'.substr($web_mobile_phone, 2, 3).'-'.substr($web_mobile_phone, 5, 3).'-'.substr($web_mobile_phone, 8);

        return $phone;
    }

    public static function convertDBToWebMobile($db_mobile_phone) {

        // надо телефон из формата +7-966-112-8006 конвертировать в +7 (966) 112 80 06
        $phone = str_replace('-', ' ', $db_mobile_phone); // +7 966 112 8006
        $phone = substr($phone, 0, 13) . ' '.substr($phone, 13);// +7 966 112 80 06
        $phone = substr($phone, 0, 3) . '(' . substr($phone, 3, 3) . ')' . substr($phone, 6);

        return $phone;
    }
}