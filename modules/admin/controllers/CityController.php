<?php

namespace app\modules\admin\controllers;

use app\models\YandexPoint;
use app\models\YandexPointSearch;
use Yii;
use app\models\City;
use app\models\CitySearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
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

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


//    public function actionCreate()
//    {
//        $model = new City();
//        if (Yii::$app->request->isAjax)
//        {
//            // данные из таблицы Points
//            return $this->render('create', [
//                'model' => $model,
//                'yandexPointSearchModel' => [],
//                'yandexPointDataProvider' => [],
//            ]);
//
//        }else {
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect(['update', 'id' => $model->id]);
//            } else {
//                return $this->render('create', [
//                    'model' => $model,
//                    'yandexPointSearchModel' => [],
//                    'yandexPointDataProvider' => [],
//                ]);
//            }
//        }
//    }


//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//
//        if (Yii::$app->request->isAjax)
//        {
//            $queryParams = Yii::$app->request->queryParams;
//
//            $queryParams['YandexPointSearch']['city_id'] = $id;
//
//            $yandexPointSearchModel = new YandexPointSearch();
//            $yandexPointDataProvider = $yandexPointSearchModel->search($queryParams);
//
//            return $this->render('update', [
//                'model' => $model,
//                'yandexPointSearchModel' => $yandexPointSearchModel,
//                'yandexPointDataProvider' => $yandexPointDataProvider,
//            ]);
//
//        }else {
//
//            $queryParams = Yii::$app->request->queryParams;
//            $queryParams['YandexPointSearch']['city_id'] = $id;
//
//            $yandexPointSearchModel = new YandexPointSearch();
//            $yandexPointDataProvider = $yandexPointSearchModel->search($queryParams);
//
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect(['index']);
//            } else {
//                return $this->render('update', [
//                    'model' => $model,
//                    'yandexPointSearchModel' => $yandexPointSearchModel,
//                    'yandexPointDataProvider' => $yandexPointDataProvider,
//                ]);
//            }
//        }
//    }


//    public function actionAjaxDelete($id)
//    {
//        // если у города есть точки остановки, то запрещаем удалять
//        $yandex_point = YandexPoint::find()->where(['city_id' => $id])->one();
//        if($yandex_point != null) {
//            Yii::$app->response->format = 'json';
//            throw new ForbiddenHttpException('Нельзя удалить город, так как у него есть точки (удалите вначале все точки города)');
//        }
//
//        $this->findModel($id)->delete();
//    }

    // редактирование яндекс-точек на клиентском сервере отключаю
//    public function actionAjaxGetCityYandexPointsData($city_id) {
//
//        Yii::$app->response->format = 'json';
//
//        $city = City::find()->where(['id' => $city_id])->one();
//        if($city == null) {
//            throw new ForbiddenHttpException('Город не найден');
//        }
//
//        return [
//            'city' => $city,
//            'yandex_points' => $city->yandexPoints
//        ];
//    }


    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
