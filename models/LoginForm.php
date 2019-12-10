<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    //public $username;
    public $email;
    public $password;
    public $push_token;
    public $rememberMe = true;

    private $_user = false;
    private $max_attempt_count = 10; // максимальное количество попыток неверного ввода пароля
    private $attempt_time = 100; // время пока пользователю будет запрещено пытаться войти на сайт


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            //[['username', 'email'], 'checkLogin', 'skipOnEmpty' => false],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword', 'skipOnEmpty' => false],
            [['push_token'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            //'username' => 'Логин',
            'email' => 'Эл.почта',
            'password' => 'Пароль',
            'push_token' => 'Токен мобильного устройства для пушей',
        ];
    }

//    public function checkLogin($attribute_name, $params)
//    {
//        if (empty($this->username) && empty($this->email)
//        ) {
//            $this->addError($attribute_name, 'Вы не указали логин или email пользователя');
//
//            return false;
//        }
//
//        return true;
//    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $has_error = false;
        $user = $this->getUser();
        if($user == null) {
            return false;
        }

        if($user->blocked == 1 && $user->last_ip == Yii::$app->request->getUserIP()) {
            $time = $user->attempt_date + $this->attempt_time - time();
            if($time > 0) {
                $has_error = true;
                throw new ForbiddenHttpException('Вы превысили максимальное количество попыток входа. Вы можете попробовать еще раз через '.$time.' секунд');
                //Yii::$app->session->setFlash('error', 'Вы превысили максимальное количество попыток входа. Вы можете попробовать еще раз через '.$time.' секунд');
            }
        }

        if(!$has_error)
        {
            if ($this->validate()) {
                $user->last_ip = Yii::$app->request->getUserIP();
                $user->attempt_count = 0;
                $user->last_login_date = time();
                $user->token = Yii::$app->security->generateRandomString();
                $user->save(false);

                return Yii::$app->user->login($user, $this->rememberMe ? 60 * 15 : 0);

            } else {

                if ($user->last_ip == Yii::$app->request->getUserIP()) {
                    $user->attempt_count = $user->attempt_count + 1;
                } else {
                    $user->attempt_count = 1;
                }
                $user->last_ip = Yii::$app->request->getUserIP();
                $user->attempt_date = time();

                if ($user->attempt_count >= $this->max_attempt_count) {
                    $user->blocked = 1;
                } else {
                    $user->blocked = 0;
                }

                $user->save(false);
            }
        }
        return false;
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
//            if(!empty($this->username)) {
//                $this->_user = User::findByUsername($this->username);
//            }else
            if(!empty($this->email)) {
                $this->_user = User::findByEmail($this->email);
            }
        }

        return $this->_user;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = $this->getUser();
            if($user == null) {
                $this->addError($attribute, 'Пользователь с таким логином или электронной почтой не найден');
            }elseif (!$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильный пароль.');
            }
        }
    }
}
