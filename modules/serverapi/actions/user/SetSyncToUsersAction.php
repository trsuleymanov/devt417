<?php

namespace app\modules\serverapi\actions\user;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use app\models\User;

class SetSyncToUsersAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Установка заявкам даты синхронизации
     *
     * запрос: curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/user/set-sync-to-users?ids=1,2,3,7
     * запрос с кодом доступа: curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/user/set-sync-to-users?ids=1,2,3,7
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

        $users = User::find()->where(['id' => $aClearIds])->all();
        if(count($users) == 0) {
            throw new ForbiddenHttpException('Пользователи не найдены');
        }

        $sql = 'UPDATE '.User::tableName().' SET sync_date = '.time().' WHERE id IN ('.implode(',', ArrayHelper::map($users, 'id', 'id')).')';
        Yii::$app->db->createCommand($sql)->execute();


        return [
            'success' => true,
            'ids' => $ids
        ];

    }
}
