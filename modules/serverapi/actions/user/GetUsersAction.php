<?php

namespace app\modules\serverapi\actions\user;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\User;


class GetUsersAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * Возвращается список не синхронизированных пользователей
     *
     * запрос: curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/user/get-users
     * запрос с кодом доступа: curl -i -H "Authorization: SecretKey zLitjs_lUIthw908y" "Accept:application/json" -H "Content-Type:application/json" -XPOST http://tobus-client.ru/serverapi/user/get-users
     */
    public function run()
    {
        // нужны поля клиента: id, name, mobile_phone, логин - нет такого, пароль - нет такого
        \Yii::$app->response->format = 'json';

        $users = User::find()
            ->where(['sync_date' => NULL])
            ->limit(50)
            ->all();


        // у каждого клиента есть массив с данными пассажиров
        $aUsers = [];
        if(count($users) > 0) {
            foreach($users as $user) {

                $aUsers[] = [
                    'id' => $user->id,
                    'fio' => $user->fio,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'cashback' => $user->cashback,
                    'current_year_sended_places' => $user->current_year_sended_places,
                    'current_year_sended_prize_places' => $user->current_year_sended_prize_places,
                    'current_year_penalty' => $user->current_year_penalty,
                ];
            }
        }

        return $aUsers;
    }
}
