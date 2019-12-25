<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password;
    public $rememberMe = false;

    public static function tableName()
    {
        return '{{%user}}';
    }


    public function rules()
    {
        return [
            [['email', 'fio', 'phone'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'required', 'skipOnEmpty' => false, 'on' => 'set_password'],
            //[['username', 'email'], 'checkUsernameEmail', 'skipOnEmpty' => false],
            [['last_ip', 'password'], 'string', 'min' => 6, 'max' => 20],
            [['email', 'phone'], 'unique'],
            [['fio'], 'string', 'max' => 100],
            [['phone'], 'checkPhone'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'token', 'restore_code'], 'string', 'max' => 255],
            [['code_for_friends', 'friend_code'], 'string', 'min' => 6, 'max' => 6],
            [['account'], 'double'],
            [['created_at', 'updated_at', 'last_login_date',
                'attempt_count', 'attempt_date', 'blocked', //'confirmed',
                //'main_server_client_id'
                'sync_date', 'current_year_sended_places', 'current_year_sended_prize_places', 'current_year_penalty',
                'phone_is_confirmed'
            ], 'integer'],
            [['push_token'], 'string', 'max' => 255],
            ['password', 'validatePassword2', 'skipOnEmpty' => false, 'on' => 'login'],
            [['cashback',], 'safe']
        ];
    }


    public function checkPhone($attribute)
    {
        if (!preg_match('/^\+7\-[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен быть в формате +7-***-***-****');
        }else {
            return true;
        }
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'main_server_client_id' => 'id связанного клиента на основном сервере',
            'last_login_date' => 'Время последней попытки входа на сайт',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'token' => 'Токен устройства',
            'push_token' => 'Токен мобильного устройства для пушей',
            'email' => 'Электронная почта',
            'email_is_confirmed' => 'Эл.почта была подтверждена',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'phone_is_confirmed' => 'Телефон подтвержден',
            'cashback' => 'Кэш-бэк счет',

            'current_year_sended_places' => 'Число отправленных мест',
            'current_year_sended_prize_places' => 'Число отправленных призовых поездок в текущем году',
            'current_year_penalty' => 'Число штрафов в текущем году',

            'last_ip' => 'IP адрес (последнего входа на сайт)',
            'attempt_count' => 'Количество неудачных попыток последнего входа на сайт',
            'attempt_date' => 'Время последней попытки входа на сайт',
            //'confirmed' => 'Подтвержденный клиент',
            'restore_code' => 'Код восстановления доступа',

            'code_for_friends' => 'Код "Приведи друга"',
            'friend_code' => 'Код переданный от друга',
            'account' => 'Счет, руб.',

            'created_at' => 'Время создания',
            'updated_at' => 'Время изменения',
            'sync_date' => 'Дата синхронизации с диспетчерской',
            'blocked' => 'Заблокирован',

            'password' => 'Пароль'
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();

            // этот код при регистрации из приложения убрал, т.к. при создании регистрации пользователя на сайте пароль переписывается.

//            $this->password = Yii::$app->getSecurity()->generateRandomString(6);
//            $this->setPasswordHash($this->password);
        }else {
            $this->updated_at = time();
        }

        $this->sync_date = null;

        return parent::beforeSave($insert);
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();


        // сценарий создания заказа при нажатии на кнопку "Записать"
        $scenarios['sync_with_main_server'] = [
            'fio',
            'phone',
            'cashback',
            'created_at',
            'updated_at'
        ];

        // сценарий для всех остальных операций с заказом
        $scenarios['typical'] = [
            'auth_key',
            'password_hash',
            'token',
            'email',
            'fio',
            'phone',
            'cashback',
            'created_at',
            'updated_at',
        ];

        $scenarios['set_password'] = [
            'password', 'password_hash'
        ];

        $scenarios['create_client_ext'] = [
            'email',
            'phone',
            'cashback',
        ];

        $scenarios['login'] = [
            'password',
        ];

        return $scenarios;
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(["token" => $token]);
    }


    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->one();
    }

    public function setPasswordHash($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === $password;
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function validatePassword2($attribute, $params)
    {
        if (!$this->hasErrors()) {
//            $user = $this->getUser();
//            if($user == null) {
//                $this->addError($attribute, 'Пользователь с таким логином или электронной почтой не найден');
//            }elseif (!$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Неправильный пароль.');
//            }

            if (!$this->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный пароль. <a id="open-restore-password-form" href = "#">Восстановить</a>');
            }
        }
    }




    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        // проверка валидности нового устанавливаемого пароля
        if(mb_strlen($password, 'UTF-8') < 6) {
            throw new ForbiddenHttpException('Пароль не может быть меньше 6 символов');
        }
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);

        return true;
    }

    public function getRandomPassword() {

        $al = "abcdefghiklmnoprstulkeDFGRTGFHFrzjmnflkjrreiQowPHDGERG936431234567";

        $password = '';
        for ($i = 1; $i < 9; $i++) {
            $password .= $al[rand(1, strlen($al)) - 1];
        }

        return $password;
    }

    public function generateRestoreCode() {

        $this->restore_code = md5($this->email . '.lsshal&3HJ' . $this->fio . time());

        return true;
    }


    public function sendConfirmEmail() {

        $current_reg = CurrentReg::find()->where(['email' => $this->email])->one();
        if($current_reg == null) {
            throw new ErrorException('Регистрация не найдена');
        }

        $message = Yii::$app->mailer->compose();
        $message->setFrom(\Yii::$app->params['callbackEmail']);
        $message->setTo($this->email);
        $message->setSubject('Подтверждение регистрации на сайте '.Yii::$app->params['siteUrl']);
        $message->setHtmlBody(Yii::$app->mailer->render('registration_code', [
            'registration_url' =>  Yii::$app->params['siteUrl'].'/user/confirm-registration/?registration_code='.$current_reg->registration_code,
            'site' => Yii::$app->params['siteUrl'],
            'img' => $message->embed(Yii::$app->params['siteUrl'].'/images/417.gif'),
            'email' => $this->email,
            'phone' => $this->phone,
        ]));
        return $message->send();

        //return true;
    }

    public function sendRestoreCode() {

        return Yii::$app->mailer->compose('restore_code', [
            'restore_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/restore-access/?restore_code='.$this->restore_code,
            'site' => $_SERVER['HTTP_HOST']
        ])
            ->setFrom(\Yii::$app->params['callbackEmail'])
            ->setBcc(\Yii::$app->params['fromEmail'])
            ->setTo($this->email)
            ->setSubject('Код восстановления доступа')
            ->send();

        // return true;
    }

    public function sendTempPassword($password) {

        return Yii::$app->mailer->compose('temp_password', [
            //'restore_url' =>  $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/user/restore-access/?restore_code='.$this->restore_code,
            //'site' => $_SERVER['HTTP_HOST']
            'password' => $password,
        ])
            ->setFrom(\Yii::$app->params['callbackEmail'])
            ->setBcc(\Yii::$app->params['fromEmail'])
            ->setTo($this->email)
            ->setSubject('Временный пароль для входа на сайт')
            ->send();

        //return true;
    }


    public function sendInfo($aData) {

        return Yii::$app->mailer->compose('info', $aData)
            ->setFrom(\Yii::$app->params['callbackEmail'])
            ->setBcc(\Yii::$app->params['fromEmail'])
            ->setTo($this->email)
            ->setSubject('Временный пароль для входа на сайт')
            ->send();

        //return true;
    }



    public static function generateCodeForFriends() {

        $code = Yii::$app->getSecurity()->generateRandomString(6);

        $user = User::find()->where(['code_for_friends' => $code])->one();
        if($user != null) {
            $code = self::generateCodeForFriends();
        }

        return $code;
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

    /*
     * Начисление пользователю на счет денег за привод друга
     */
    public function addMoneyForFriend($client_id) {

        $old_account_transaction = AccountTransaction::find()
            //->where(['user_id' => $this->id])
            ->where(['clientext_id' => $client_id])
            ->andWhere(['operation_type' => 1])
            ->one();
        if($old_account_transaction != null) {
            throw new ForbiddenHttpException('Транзакция начисления за друга по данному заказу ранее была произведена. Текущая транзакция отменена.');
        }


        $account_transaction = new AccountTransaction();
        $account_transaction->user_id = $this->id;
        $account_transaction->money = AccountTransaction::$friend_bonus;
        $account_transaction->operation_type = 1;
        $account_transaction->clientext_id = $client_id;

        if(!$account_transaction->save()) {
            throw new ErrorException('Не удалось создать транзакцию');
        }

        return true;
    }

    /*
     * Списание со счета пользователя скидки
     */
    public function subMoney($client_id, $money) {

        $old_account_transaction = AccountTransaction::find()
            //->where(['user_id' => $this->id])
            ->where(['clientext_id' => $client_id])
            ->andWhere(['operation_type' => 0])
            ->one();
        if($old_account_transaction != null) {
            throw new ForbiddenHttpException('Транзакция списания со счета по данному заказу ранее была произведена. Текущая транзакция отменена.');
        }

        $account_transaction = new AccountTransaction();
        $account_transaction->user_id = $this->id;
        $account_transaction->money = $money;
        $account_transaction->operation_type = 0;
        $account_transaction->clientext_id = $client_id;

        if(!$account_transaction->save()) {
            throw new ErrorException('Не удалось создать транзакцию');
        }

        return true;
    }

    // функция возвращает массив скидок за 1 место для всех направлений
    // используется для мобильного api
//    public function getDirectionsPlaceDiscountList() {
//
//        $aDiscounts = [];
//
//        $clientext_count = ClientExt::find()
//            ->where(['user_id' => $this->id])
//            ->andWhere(['status' => 'sended'])
//            ->count();
//        $ordinal_number = bcmod($clientext_count, '5') + 1;
//
//        $place_discount = ClientExt::getPlaceDiscount($ordinal_number);
//
//        $directions = Direction::find()->all();
//        foreach($directions as $direction) {
//
//            $direction_name = $direction->cityFrom->name.'-'.$direction->cityTo->name;
//
//            //$aDiscounts[$direction_name] = $place_discount;
//            $aDiscounts[] = [
//                'direction_name' => $direction_name,
//                'place_discount' => $place_discount,
//                'discount_level' => $ordinal_number - 1
//            ];
//        }
//
//        return $aDiscounts;
//    }

    // функция возвращает двумерный массив цен для всех направлений и возможных мест в условном заказе
    // используется для мобильного api
//    public function getDirectionsPlacesDiscountList() {
//
//        $aPrices = [];
//
//        // количество ранее отъезженных заказов клиента
//        $clientext_count = ClientExt::find()
//            ->where(['user_id' => $this->id])
//            ->andWhere(['status' => 'sended'])
//            ->count();
//        $ordinal_number = bcmod($clientext_count, '5') + 1;
//
//        //$place_discount = ClientExt::getPlaceDiscount($ordinal_number);
//
//        $directions = Direction::find()->all();
//        foreach($directions as $direction) {
//
//            $direction_name = $direction->cityFrom->name.'-'.$direction->cityTo->name;
//
//            for($places_count = ClientExt::$min_places_count; $places_count < ClientExt::$max_places_count; $places_count++) {
//                //$aPrices[$direction_name][$places_count] = ClientExt::getClientextPrice($ordinal_number, $places_count);
//                $aPrices[] = [
//                    'direction_name' => $direction_name,
//                    'places_count' => $places_count,
//                    'discount' => (($places_count==0 ? 1 : $places_count)*ClientExt::$full_price - ClientExt::getClientextPrice($ordinal_number, $places_count)),
//                ];
//            }
//        }
//
//        return $aPrices;
//    }
}
