<?php

namespace app\modules\access\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\di\Instance;
use yii\base\Module;
//use yii\web\User;
use app\models\User;
use yii\web\ForbiddenHttpException;
use yii\web\Cookie;

/**
 * Глобальное поведение проверки прав доступа.
 *
 * Class AccessBehavior
 * @package backend\modules\access\behaviors
 */
class AccessBehavior extends AttributeBehavior
{
    // public $login_url = '/site/login';
    public $login_url = '/';

    /**
     * @return array
     */
    public function events()
    {
        return [Module::EVENT_BEFORE_ACTION => 'interception'];
    }


    /**
     * @param $event
     * @throws ForbiddenHttpException
     */
    public function interception($event)
    {
//        if(
//            strpos(Yii::$app->request->url, '/site/login') !== false
//            || Yii::$app->request->url == '/site/logout'
//            || strpos(Yii::$app->request->url, '/api/') !== false
//            || strpos(Yii::$app->request->url, '/debug/') !== false
//            || strpos(Yii::$app->request->url, '/serverapi/') !== false
//        ) {
//            return true;
//        }


        $user = Yii::$app->user->identity;
        if(strpos(Yii::$app->request->url, '/admin') !== false && $user == null) {
            Yii::$app->response->redirect($this->login_url)->send();
            exit(); // Exit нужно производить потому что ->redirect сразу не срабатывает, а вначале выводиться html
        }

        if(strpos(Yii::$app->request->url, '/admin') !== false && $user->role != 'admin') {
            //throw new ForbiddenHttpException('Только у админов есть доступ к админке');
            exit('Только у админов есть доступ к админке');
        }

        if(strpos(Yii::$app->request->url, '/account') !== false && $user == null) {
            Yii::$app->response->redirect($this->login_url)->send();
            exit(); // Exit нужно производить потому что ->redirect сразу не срабатывает, а вначале выводиться html
        }

    }
}
