<?php
namespace app\modules\account\controllers;

use app\components\Helper;
use app\models\InputPhoneForm;
use app\models\User;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use app\models\LoginForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class PersonalController extends Controller
{

    public function actionIndex()
    {
        //echo "admin actionIndex";
        /*$searchModel = new ContragentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);*/


        if(Yii::$app->getUser() == null) {
            throw new ForbiddenHttpException('Пользователь не авторизован. Нет доступа');
        }
        $user = User::find()->where(['id' => Yii::$app->getUser()->getId()])->one();



        return $this->render('index', [
            'user' => $user,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'searchModelCurYear' => $searchModelCurYear,
//            'dataProviderCurYear' => $dataProviderCurYear,
//            'searchModelPastYears' => $searchModelPastYears,
//            'dataProviderPastYears' => $dataProviderPastYears,
        ]);
    }


    /*
     * Функция изменяем какой-либо поле модели order и возвращает ответ в элемент kartik\editable\Editable::widget
     */
    public function actionEditableUser($id)
    {
        Yii::$app->response->format = 'json';

        $user = User::find()->where(['id' => $id])->one();

        if (isset($_POST['hasEditable']))
        {
            if(isset($_POST['last_name']))
            {
                $user->last_name = Yii::$app->request->post('last_name');
                if(!empty($user->last_name)) { // устанавливаем значение

                    $user->scenario = 'check_last_name';
                    if($user->validate() == true) {
                        $user->setField('last_name', $user->last_name);
                        $user->setField('sync_date', null);

                        return ['output' => $user->last_name, 'message' => ''];
                    }else {
                        //throw new ForbiddenHttpException(implode('. ', $user->getErrors('last_name')));
                        $aErrors = $user->getErrors();
                        echo "aErrors:<pre>"; print_r($aErrors); echo "</pre>";
                        exit;
                    }

                }else { // очищаем значение
                    $user->setField('last_name', '');
                    $user->setField('sync_date', null);
                    return ['output' => '', 'message' => ''];
                }

            }elseif(isset($_POST['first_name'])) {

                $user->first_name = Yii::$app->request->post('first_name');
                if(!empty($user->first_name)) { // устанавливаем значение

                    $user->scenario = 'check_first_name';
                    if($user->validate() == true) {
                        $user->setField('first_name', $user->first_name);
                        $user->setField('sync_date', null);

                        return ['output' => $user->first_name, 'message' => ''];
                    }else {
                        throw new ForbiddenHttpException(implode('. ', $user->getErrors('first_name')));
                    }

                }else { // очищаем значение
                    $user->setField('first_name', '');
                    $user->setField('sync_date', null);
                    return ['output' => '', 'message' => ''];
                }

            }elseif(isset($_POST['phone'])) {

                //$user->phone = Yii::$app->request->post('phone');
                $phone = Yii::$app->request->post('phone');
                if(Helper::isValidWebMobile($phone)) {
                    $user->phone = Helper::convertWebToDBMobile($phone);
                }else {
                    throw new ForbiddenHttpException('Телефон должен быть в формате +7 (***) *** ** **');
                }

                $user->scenario = 'check_phone';
                if($user->validate() == true) {
                    $user->setField('phone', $user->phone);
                    $user->setField('sync_date', null);

                    return ['output' => $user->phone, 'message' => ''];
                }else {
                    throw new ForbiddenHttpException(implode('. ', $user->getErrors('phone')));
                }

            }elseif(isset($_POST['password'])) {

                $user->password = Yii::$app->request->post('password');
                $user->scenario = 'check_password';
                if ($user->validate() == true) {

                    $user->setPasswordHash($user->password);
                    if (!$user->save()) {
                        throw new ErrorException('Не удалось сохранить новый пароль');
                    }

                    return ['output' => $user->password, 'message' => 'Пароль установлен'];
                } else {
                    throw new ForbiddenHttpException(implode('. ', $user->getErrors('password')));
                }

            }elseif(isset($_POST['email'])) {

                $user->email = Yii::$app->request->post('email');
                $user->scenario = 'check_email';
                if($user->validate() == true) {

                    $user->setField('email', $user->email);
                    $user->setField('sync_date', null);

                    return ['output' => $user->email, 'message' => 'Эл. почта записана'];
                }else {
                    throw new ForbiddenHttpException(implode('. ', $user->getErrors('email')));
                }

            }else {
                return ['output' => '', 'message'=>'Неизвестное поле'];
            }


        }else {
            throw new ForbiddenHttpException('Формат запроса не верен');
        }
    }
}
