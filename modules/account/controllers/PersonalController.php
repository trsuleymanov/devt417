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
            if(isset($_POST['fio']))
            {
                $user->fio = Yii::$app->request->post('fio');
                if(!empty($user->fio)) { // устанавливаем значение

                    if($user->validate() == true) {
                        $user->setField('fio', $user->fio);
                        $user->setField('sync_date', null);

                        return ['output' => $user->fio, 'message' => ''];
                    }else {
                        throw new ForbiddenHttpException(implode('. ', $user->getErrors('fio')));
                    }

                }else { // очищаем значение
                    $user->setField('fio', '');
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


                if($user->validate() == true) {
                    $user->setField('phone', $user->phone);
                    $user->setField('sync_date', null);

                    return ['output' => $user->phone, 'message' => ''];
                }else {
                    throw new ForbiddenHttpException(implode('. ', $user->getErrors('phone')));
                }

            }elseif(isset($_POST['password'])) {

                $user->password = Yii::$app->request->post('password');

                if($user->validate() == true) {

                    $user->scenario = 'set_password';
                    $user->setPasswordHash($user->password);
                    if(!$user->save()) {
                        throw new ErrorException('Не удалось сохранить новый пароль');
                    }

                    return ['output' => $user->password, 'message' => 'Пароль установлен'];
                }else {
                    throw new ForbiddenHttpException(implode('. ', $user->getErrors('password')));
                }

            }else {
                return ['output' => '', 'message'=>'Неизвестное поле'];
            }


        }else {
            throw new ForbiddenHttpException('Формат запроса не верен');
        }
    }
}
