<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;

/**
 * This is the model class for table "current_reg".
 *
 * @property int $id
 * @property string $email Электронная почта
 * @property string $fio ФИО
 * @property string $mobile_phone Мобильный телефон
 * @property string $password Пароль
 * @property string $registration_code Код идентифицирующий пользователя
 * @property int $created_at Время создания
 * @property int $updated_at Время изменения
 */
class CurrentReg extends \yii\db\ActiveRecord
{
    public $password = '';
    // public $confirm_password = '';
    public $check_code;

    public static $max_sms_count = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'current_reg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'fio', 'mobile_phone', 'password'], 'required'],
            [['email', 'fio'], 'filter', 'filter' => 'trim'],
            [['created_at', 'updated_at', 'sended_sms_code_at', 'count_sended_sms', 'is_confirmed_mobile_phone', 'input_mobile_at'], 'integer'],
            [['email'], 'string', 'max' => 50],
            [['fio'], 'string', 'max' => 100],
            ['access_code', 'string', 'min' => 32, 'max' => 32],
            [['mobile_phone'], 'string', 'max' => 20],
            [['mobile_phone'], 'checkPhone', 'skipOnEmpty' => false],
            [['password', /*'confirm_password'*/], 'string', 'min' => 6, 'max' => 30],
            [['registration_code'], 'string', 'max' => 255],
            //['confirm_password', 'checkConfirmPassword', 'skipOnEmpty' => false],
            [['sms_code', 'check_code'], 'string', 'min' => 4, 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'access_code' => 'Уникальный код доступа к регистрации',
            'email' => 'Электроная почта',
            'fio' => 'ФИО',
            'mobile_phone' => 'Мобильный телефон',
            'is_confirmed_mobile_phone' => 'Подтвержден мобильный телефон',
            'password' => 'Пароль',
            //'confirm_password' => 'Пароль - Повторите ввод пароля',
            'registration_code' => 'Код идентификации пользователя',
            'sms_code' => 'Код подтверждения телефона пользователя',
            'check_code' => 'Код подтверждения телефона пользователя',
            'sended_sms_code_at' => 'Время отправки кода',
            'count_sended_sms' => 'Количество отправок кода',
            'input_mobile_at' => 'Время ввода телефона при регистрации',
            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['start_registration'] = [
            //'email',
            'mobile_phone'
        ];

        $scenarios['send_sms_code'] = [
            'sended_sms_code_at',
            'count_sended_sms',
            'sms_code',
            'is_confirmed_mobile_phone'
        ];

        $scenarios['end_registration'] = [
            'email',
            //'fio',
            'password',
            'registration_code',
            //'confirm_password'
        ];

        return $scenarios;
    }


    public function checkPhone($attribute)
    {
        if (!preg_match('/^\+7-[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен быть в формате +7-***-***-****');
        }else {
            return true;
        }
    }

    public function checkConfirmPassword($attribute) {

        if($this->confirm_password != $this->password) {
            $this->addError($attribute, 'Повтор пароля и пароль не совпадают');
        }else {
            return true;
        }
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }else {
            $this->updated_at = time();
        }

        return parent::beforeSave($insert);
    }


    public function generateRegistrationCode() {

        $this->registration_code = md5($this->fio . 'sixwoal#$_Djd937' . $this->mobile_phone . $this->email);

        return true;
    }


    // функция генерирует уникальный код идентифицирующий заказ (чтобы можно было неавторизованному пользователю открыть страницу с заказом)
    public function generateAccessCode() {

        $access_code = Yii::$app->security->generateRandomString(); // 32 символа

//        $current_reg = CurrentReg::find()->where(['access_code' => $access_code])->one();
//        if($current_reg != null) {
//            return $this->generateAccessCode();
//        }else {
//            return $access_code;
//        }

        return $access_code;
    }


    public function sendRegistrationCode() {

//        Yii::$app->mailer->compose('registration_code', [
//            'registration_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/confirm-registration/?registration_code='.$this->registration_code,
//            'site' => $_SERVER['HTTP_HOST']
//        ])
//            ->setFrom(\Yii::$app->params['callbackEmail'])
//            ->setBcc(\Yii::$app->params['fromEmail'])
//            ->setTo($this->email)
//            //->setTo('nara-dress@yandex.ru')
//            ->setSubject('Регистрационный код')
//            //->setTextBody('Текст сообщения')
//            //->setHtmlBody('<b>текст сообщения в формате HTML</b>')
//            ->send();


        $message = Yii::$app->mailer->compose();
        $message->setFrom(\Yii::$app->params['callbackEmail']);
        $message->setTo($this->email);
        $message->setSubject('Подтверждение регистрации на сайте '.Yii::$app->params['siteUrl']);
        $message->setHtmlBody(Yii::$app->mailer->render('registration_code', [
            'registration_url' =>  Yii::$app->params['siteUrl'].'/user/confirm-registration/?registration_code='.$this->registration_code,
            'site' => Yii::$app->params['siteUrl'],
            'img' => $message->embed(Yii::$app->params['siteUrl'].'/images/417.gif'),
            'email' => $this->email,
            'phone' => $this->mobile_phone,
        ]));
        $message->send();

        return true;
    }


    public function createOrUpdateUser() {

        // если пользователя связанного не существует, то создам его, иначе перепишу данные
        $user = User::find()
            ->where(['email' => $this->email])
            ->orWhere(['phone' => $this->mobile_phone])
            ->one();
        if($user == null) {
            $user = new User();
        }

        $user->email = $this->email;
        $user->fio = $this->fio;
        $user->phone = $this->mobile_phone;
        $user->setPassword($this->password);

        if($user->validate() && $user->save()) {
            return true;
        }else {
            $aResultErrors = [];
            foreach($user->getErrors() as $field => $aErrors) {
                $aResultErrors[] = implode('. ', $aErrors);
            }

            throw new ErrorException(implode('. ', $aResultErrors));
        }
    }


    public static function generateCode() {

        $str = '';
        for($i = 0; $i < 4; $i++) {
            $str .= rand(0, 9);
        }

        return $str;
    }


    public function generateAndSendSmsCode() {

        if($this->count_sended_sms >= self::$max_sms_count) {
            // проверяем тогда прошел ли 1 час
            if(time() - $this->sended_sms_code_at < 86400) {
                throw new ForbiddenHttpException('Запрещено отправлять за сутки более '.self::$max_sms_count.'-х СМС. Можно будет повторно отправить код '.date('d.m.Y в H:i', $this->sended_sms_code_at + 86400));
            }else {
                $this->count_sended_sms = 0;
            }
        }

        $this->sms_code = CurrentReg::generateCode();
        $to = str_replace('+7', '', $this->mobile_phone);
        $to = str_replace('-', '', $to);
        // почему-то наличие пробела в тексте приводит к тому что только код приходит,
        //   а приходит если заключить в кавычки, но тогда ковычки и в смс приходят
        //$text = 'Проверочный код: '.$this->sms_code;
        $text = $this->sms_code;
        Sms::send($to, $text);

        $this->sended_sms_code_at = time();
        $this->count_sended_sms = intval($this->count_sended_sms) + 1;
        $this->is_confirmed_mobile_phone = false;
        $this->scenario = 'send_sms_code';
        if(!$this->save(false)) {
            throw new ForbiddenHttpException('Не удалось отправить смс с проверочным кодом');
        }
    }

    public function setField($field_name, $field_value)
    {
        if(!empty($field_value)) {
            $field_value = htmlspecialchars($field_value);
        }

        if($field_value === false) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = false WHERE id = '.$this->id;
        }elseif(empty($field_value)) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = NULL WHERE id = '.$this->id;
        }else {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = "'.$field_value.'" WHERE id = '.$this->id;
        }

        return Yii::$app->db->createCommand($sql)->execute();
    }
}
