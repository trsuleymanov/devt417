<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Cookie;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionCallSettings() {


        $model = Setting::find()->where(['id' => 1])->one();
        if($model == null) {
            $model = new Setting();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись сохранена');
            return $this->render('call-settings', [
                'model' => $model,
            ]);
        } else {
            return $this->render('call-settings', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Добавляет в сессию выбранное пользователем отображаемое кол-во строк в таблицах
     * backend/helpers/table/PageSizeHelper.php
     *
     * @param int $rows кол-во строк в таблице
     * @return mixed
     */
    public function actionTableRows($rows = 20)
    {
        Yii::$app->session->set('table-rows', $rows);
        if (Yii::$app->user->returnUrl != '/') {
            return $this->goBack();
        } else {
            return Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
        }
    }


    /**
     * Открытие закрытие главного меню в админке
     */
    public function actionMainMenuStatus()
    {
        $request = Yii::$app->request;

        $status = $request->post('status');

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'main-menu',
            'value' => $status,
        ]));
    }
}
