<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;


class RestorePasswordForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            [['email',], 'required'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Эл.почта',
        ];
    }


}
