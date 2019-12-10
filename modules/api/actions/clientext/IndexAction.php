<?php

namespace app\modules\api\actions\clientext;

use app\models\ClientExt;
use Yii;
use yii\base\ErrorException;
use yii\web\ForbiddenHttpException;


class IndexAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Список заявок-заказов
     */
    public function run()
    {
        $statuses = [];
        if(!empty(Yii::$app->getRequest()->getBodyParam('status'))) {
            $statuses = explode(',', Yii::$app->getRequest()->getBodyParam('status'));
        }

        $clientexts_query = ClientExt::find()->where(['user_id' => Yii::$app->user->identity->id]);
        if(count($statuses) > 0) {
            $clientexts_query->andWhere(['status' => $statuses]);
        }
        $clientexts = $clientexts_query->orderBy(['id' => SORT_DESC])->all();


        return [
            'orders_list' => $clientexts,
            'count_all_orders' => ClientExt::find()->where(['user_id' => Yii::$app->user->identity->id])->count()
        ];
    }
}