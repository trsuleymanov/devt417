<?php

namespace app\controllers;

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

        $user = User::find()->where(['phone' => $current_reg->mobile_phone])->one();
        $user->setField('email_is_confirmed', true);
        Yii::$app->user->login($user, 0);

//        if(!$current_reg->createUser()) {
//            throw new ErrorException('Не удалось создать пользователя');
//        }

//        if(!$current_reg->delete()) {
//            throw new ErrorException('Не удалось удалить регистрационную запись');
//        }



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
}
