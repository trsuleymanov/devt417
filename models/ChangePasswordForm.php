<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\base\Model;
use yii\web\ForbiddenHttpException;


class ChangePasswordForm extends Model
{
    public $new_password;

    public function rules()
    {
        return [
            [['new_password',], 'required'],
            [['new_password'], 'string', 'min' => 6, 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_password' => 'Новый пароль',
        ];
    }
}
