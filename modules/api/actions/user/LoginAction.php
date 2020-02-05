<?php

namespace app\modules\api\actions\user;

use app\models\ClientExt;
use Yii;
use app\models\LoginForm;



class LoginAction extends \yii\rest\Action
{
    public $modelClass = '';

    /**
     * "Инициализация пользователя": аутентификация, генерация токена и т.п.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when authentication
     */
    public function run()
    {
        $loginForm = new LoginForm();

        if ($loginForm->load(Yii::$app->getRequest()->getBodyParams(), '') && $loginForm->login()) {
            $user = $loginForm->getUser();

            if(!empty($loginForm->push_token) && $loginForm->push_token != $user->push_token) {
                $user->setField('push_token', $loginForm->push_token);
            }

            if(empty($user->code_for_friends)) {
                $user->code_for_friends = $user::generateCodeForFriends();
                $user->setField('code_for_friends', $user->code_for_friends);
            }

            return [
                //'id' => $user->id,
                'token' => $user->token,
                'code_for_friends' => $user->code_for_friends,
                'email' => $user->email,
                'fio' => $user->last_name.' '.$user->first_name,
                'phone' => $user->phone,
                'account' => $user->account,
//                'one_place_discount_list' => $user->getDirectionsPlaceDiscountList(),
//                'every_place_discount_list' => $user->getDirectionsPlacesDiscountList(),
                'place_full_price' => ClientExt::$place_full_price,
                'standart_trip_place_discount' => ClientExt::$standart_trip_place_discount,
                'commercial_trip_place_extra_charge' => ClientExt::$commercial_trip_place_extra_charge
            ];
        }else {
            $loginForm->validate();

            return $loginForm;
        }

    }
}
