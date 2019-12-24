<?php
namespace app\modules\account\controllers;

use app\models\Setting;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use app\models\ClientExt;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class OrderController extends Controller
{

    public function actionHistory()
    {
        $orders = ClientExt::find()
            ->where(['user_id' => Yii::$app->getUser()->getId()])
            ->andWhere(['status' => ['sended', 'canceled_by_client', 'canceled_by_operator']])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('history', [
            'orders' => $orders
        ]);
    }

    public function actionReservation() {

        $orders = ClientExt::find()
            ->where(['user_id' => Yii::$app->getUser()->getId()])
            //->andWhere(['!=', 'status', ''])
            ->andWhere(['but_checkout' => ['reservation', '']])
            ->andWhere(['status' => ['created_with_time_confirm', 'created_without_time_confirm', 'created_with_time_sat']]) // pending_send - не беру, 'sended' - не беру
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('reservation', [
            'orders' => $orders
        ]);
    }

    /**
     * @param $id
     * @throws ForbiddenHttpException
     * @throws ErrorException
     */
    public function actionAjaxCancelOrder($id = 0, $c = '') {

        Yii::$app->response->format = 'json';

        if($id > 0) {
            $client_ext = ClientExt::find()->where(['id' => $id])->one();
        }else {
            $client_ext = ClientExt::find()->where(['access_code' => $c])->one();
        }
        if ($client_ext == null) {
            throw new ForbiddenHttpException('Заказ не найден');
        }

        $client_ext->setStatus('canceled_by_client');

        return [
            'success' => true
        ];
    }
}
