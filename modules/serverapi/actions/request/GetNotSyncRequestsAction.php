<?php

namespace app\modules\serverapi\actions\request;

use app\models\NewYearRequest;
use Yii;
use yii\helpers\ArrayHelper;


class GetNotSyncRequestsAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Возвращается список не синхронизированных записей из таблицы new_year_request
     *
     * запрос: curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/request/get-not-sync-requests
     * запрос с кодом доступа: curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/request/get-not-sync-requests
     */
    public function run()
    {
        // нужны поля клиента: id, name, mobile_phone, логин - нет такого, пароль - нет такого
        \Yii::$app->response->format = 'json';


        $requests = NewYearRequest::find()
            ->where(['sync_date' => NULL])
            ->limit(100)
            ->all();

        $aDirections = [
            'из Альметьевска в Казань' => 'АК',
            'из Казани в Альметьевск' => 'КА'
        ];


        $aRequests = [];
        if(count($requests) > 0) {
            foreach($requests as $request) {
                $aRequests[] = [
                    'id' => $request->id,
                    'created_at' => $request->created_at,
                    'direction' => (isset($aDirections[$request->direction]) ? $aDirections[$request->direction] : ''),
                    'date' => $request->date,
                    'phone' => $request->phone,
                ];
            }
        }

        return $aRequests;
    }
}
