<?php

namespace app\controllers;

use app\components\Helper;
use app\models\CurrentReg;
use app\models\User;
use Yii;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UserController extends Controller
{
    public function actionConfirmRegistration($registration_code)
    {
        $current_reg = CurrentReg::find()->where(['registration_code' => $registration_code])->one();
        if($current_reg == null) {
            throw new ForbiddenHttpException('Регистрационный код не найден');
        }

        // пока проверка на "истечение времени действия ссылки" - не нужна
//        if(time() - $current_reg->registration_code_created_at > 300) { // прошло 5 минут от начале регистрации
//            throw new ForbiddenHttpException('Время для подтверждения почты 5 минут - истекло. Пожалуйста...');
//        }

        $user = User::find()->where(['phone' => $current_reg->mobile_phone])->one();

        // при смене почты в профиле, новая почта записывается вначале в $current_reg, затем после подтверждения
        // меняется почта у пользователя
        $user->setField('email', $current_reg->email);
        $user->setField('sync_date', null);

        $user->setField('email_is_confirmed', true);

        Yii::$app->user->login($user, 0);


        return $this->render('сonfirm-registration-success');
    }

    public function actionRestoreAccess($restore_code) {

        $user = User::find()->where(['restore_code' => $restore_code])->one();
        if($user == null) {
            throw new ForbiddenHttpException('Код восстановления не найден или устарел. Запросите заново восстановление пароля на сайте.');
        }
        $user->scenario = 'set_password';

        if ($user->load(Yii::$app->request->post())) {

            $user->setPassword($user->password);
            $user->restore_code = NULL;
            if(!$user->save(false)) {
                throw new ErrorException('Не удалось сохранить пользователя');
            }else {
                Yii::$app->user->login($user, 31536000);
            }

            return Yii::$app->response->redirect(['user/set-password-success']);
        }


        return $this->render('set-password-form', [
            'model' => $user
        ]);
    }

    public function actionSetPasswordSuccess() {
        return $this->render('set-password-success');
    }

    public function actionAjaxCheckPhone($phone) {

        Yii::$app->response->format = 'json';

        $phone = trim($phone);
        if($phone[0] != "+") {
            $phone = "+".$phone;
        }

        $phone = Helper::convertWebToDBMobile($phone);
        $user = User::find()->where(['phone' => $phone])->one();

        return [
            'success' => true,
            'user_is_exist' => ($user != null),
        ];
    }

    public function actionAjaxCheckEmail($email) {

        Yii::$app->response->format = 'json';


        $user = User::find()->where(['email' => $email])->one();

        return [
            'success' => true,
            'user_is_exist' => ($user != null),
        ];
    }

    public function actionAjaxGetCallAuth($number, $reg_number, $reg_time_limit) {

        $url = 'http://82.146.45.127:9000/add?number='. $number .'&reg_number='. $reg_number .'&reg_time_limit='. $reg_time_limit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $reg_time_limit);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);
        return $result;

    }

    public function actionAjaxGetAuthResult($number, $user_phone) {

        Yii::$app->response->format = 'json';

        $url = 'http://82.146.45.127:9000/result?number='. $number;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result);
        if( $result->success && $result->auth ):

            $current_reg = CurrentReg::find()->where(['mobile_phone' => '+'. trim($user_phone)])->one();
            $current_reg->setField('is_confirmed_mobile_phone', true);
            $result->access_code = $current_reg->access_code;

        endif;

        curl_close($ch);
        return $result;

    }



    public function actionTestEmail() {

        if (Yii::$app->user->isGuest) {

            throw new ForbiddenHttpException('Нужна вначале авторизоваться на сайте, чтобы тестировать отправку писем');
        }

        $user = User::find()->where(['id' => Yii::$app->user->getId()])->one();


        // // 1. Подтверждения e-mail;
        // if($user->sendConfirmEmail()) {
        //     echo "письмо Подтверждения e-mail ушло";
        // }else {
        //     echo "Подтверждения e-mail - не работает!";
        // }

        
        // // 2. Восстановление пароля; - отправка письма со ссылкой на сайт чтобы можно было восстановить доступ
        // if($user->sendRestoreCode()) {
        //     echo "письмо Восстановление пароля ушло";
        // }else {
        //     echo "Восстановление пароля - не работает!";
        // }
        


        
        // // 2. Восстановление пароля; - отправка временного пароля (хотя я пока не уверен на 100% что это письмо нужно),
        // //   но оно в старой логике точно использовалось
        // if($user->sendTempPassword('123456')) {
        //     echo "письмо sendTempPassword ушло";
        // }else {
        //     echo "sendTempPassword - не работает!";
        // }
        


        // // 3. Инфо сообщение 1
        // $aData = [  // какой-то произвольный набор данных для сообщения
        //     'xz' => 'бла бла бла',
        //     'test_field' => 'wwwww'
        // ];
        // if($user->sendInfo($aData)) {
        //     echo "письмо sendInfo1 ушло";
        // }else {
        //     echo "sendInfo1 - не работает!";
        // }


        /*
        // 4. Инфо сообщение 2
        $aData = [  // какой-то произвольный набор данных для сообщения
            'xz' => 'бла бла бла',
            'test_field2' => 'qqq'
        ];
        if($user->sendInfo($aData)) {
            echo "письмо sendInfo2 ушло";
        }else {
            echo "sendInfo2 - не работает!";
        }
*/
    }

}
