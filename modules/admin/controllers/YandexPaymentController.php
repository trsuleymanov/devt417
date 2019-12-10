<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\YandexPayment;
use app\models\YandexPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * YandexPaymentController implements the CRUD actions for YandexPayment model.
 */
class YandexPaymentController extends Controller
{
    /**
     * Lists all YandexPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new YandexPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = YandexPayment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
