<?php

namespace app\modules\serverapi\actions\request;

use app\models\NewYearRequest;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\models\ClientExt;

class SetSyncToRequestsAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Установка записям из таблицы new_year_request даты синхронизации
     *
     * запрос: curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/request/set-sync-to-requests?ids=1,2,3,7
     * запрос с кодом доступа: curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/request/set-sync-to-requests?ids=1,2,3,7
     */
    public function run($ids)
    {
        $aIds = explode(',', $ids);
        $aClearIds = [];
        foreach($aIds as $id) {
            $id = intval($id);
            if($id > 0) {
                $aClearIds[] = $id;
            }
        }

        $requests = NewYearRequest::find()->where(['id' => $aClearIds])->all();
        if(count($requests) == 0) {
            throw new ForbiddenHttpException('Заявки не найдены');
        }

        $sql = 'UPDATE `'.NewYearRequest::tableName().'` SET sync_date = '.time().' WHERE id IN ('.implode(',', ArrayHelper::map($requests, 'id', 'id')).')';
        Yii::$app->db->createCommand($sql)->execute();


        return [
            'success' => true,
            'ids' => $ids
        ];

    }
}
