<?php

namespace app\modules\admin\controllers;

use app\models\City;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\YandexPoint;
use app\models\YandexPointSearch;


class YandexPointController extends Controller
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


    /*
     * Ajax-создание яндекс-метки остановки (в модальном окне)
     */
    public function actionAjaxCreate($city_id)
    {
        $model = new YandexPoint();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->format = 'json';
            return [
                'form_saved' => true,
                'city_id' => $model->city_id
            ];

        }else {

            $model->city_id = $city_id;

            return $this->renderAjax('ajax_form.php', [
                'model' => $model,
            ]);
        }
    }

    /*
     * Ajax-редактирование точки остановки (в модальном окне)
     */
    public function actionAjaxUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->response->format = 'json';
            return [
                'form_saved' => true,
                'city_id' => $model->city_id
            ];
        }else {
            return $this->renderAjax('ajax_form.php', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Point model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Point the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YandexPoint::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Point model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionAjaxDelete($id)
    {
        Yii::$app->response->format = 'json';

        return $this->findModel($id)->delete();
    }


    /*
 * Создание яндекс-точки
 */
    public function actionAjaxCreateYandexPoint($city_id, $name, $lat, $long) {

        Yii::$app->response->format = 'json';

        $city = City::find()->where(['id' => $city_id])->one();
        if($city == null) {
            throw new ForbiddenHttpException('Город не найден');
        }

        $yandex_point = new YandexPoint();
        $yandex_point->city_id = $city->id;
        $yandex_point->name = $name;
        $yandex_point->lat = $lat;
        $yandex_point->long = $long;
//        $yandex_point->critical_point = Yii::$app->getRequest()->post('critical_point', 0);
//        $yandex_point->point_of_arrival = Yii::$app->getRequest()->post('point_of_arrival', 0);
//        $yandex_point->alias = Yii::$app->getRequest()->post('alias', '');

        if(!$yandex_point->save()) {
            return [
                'success' => false,
                'errors' => $yandex_point->getErrors()
            ];
        }else {
            return [
                'success' => true,
                'yandex_point' => $yandex_point
            ];
        }
    }
}
