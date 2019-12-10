<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "push".
 *
 * @property int $id
 * @property int $created_at Создан
 * @property string $title Заголовок пуша
 * @property string $text Текст пуша
 * @property string $send_event Событие при наступлении которого происходит отправка пуша
 * @property int $client_ext_id id заявки
 * @property int $sended_at Время когда был отправлен пуш
 */
class Push extends \yii\db\ActiveRecord
{

    public static $firebase_server_key = 'AAAAcz-CVIY:APA91bFj_q-GgIpqvE2HrUSieZxvgxTc8ngVy-SQpsOhvckjIGesfph1M_RU1KTp9mE8hVjgIgVfFA7ZhQuaNF8Ci6THZBx3CdEC4WizGkQ-5JKwpz6O_vyFPhDG59kzkb01Z4BDZz0V';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'push';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'client_ext_id', 'sended_at', 'confirm_time_at', 'reject_time_at', 'sync_answer_time_at'], 'integer'],
            [['title', 'text'], 'string', 'max' => 50],
            [['send_event'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'confirm_time_at' => 'Время согласия при получении пуша',
            'reject_time_at' => 'Время отказа при получении пуша',
            'title' => 'Заголовок пуша',
            'text' => 'Текст пуша',
            'recipient_user_id' => 'Пользователь - получатель',
            'send_event' => 'Событие при наступлении которого происходит отправка пуша',
            'client_ext_id' => 'id заявки',
            'sended_at' => 'Время когда был отправлен пуш',
            'sync_answer_time_at' => 'Время отсылки ответа на основной сервер'
        ];
    }


    public function send() {

        $recipient_user = $this->recipientUser;
        if(empty($recipient_user->push_token)) {
            return false;
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $request_body = [
            'to' => $recipient_user->push_token,
//            'notification' => [
//                'title' => $title,
//                'body' => $text,
//            ],
        ];

        $data = [];
        $data['push_id'] = $this->id;
        $data['title'] = $this->title;
        $data['text'] = $this->text;
        $request_body['data'] = $data;


        $fields = json_encode($request_body);
        $request_headers = [
            'Content-Type: application/json',
            'Authorization: key='.self::$firebase_server_key,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $aResponse = json_decode($result);

        if(isset($aResponse->success)) {
            $this->setField('sended_at', time());
            return true;
        }else {
            return false;
        }
    }


    public function getRecipientUser() {
        return $this->hasOne(User::className(), ['id' => 'recipient_user_id']);
    }


    public function setField($field_name, $field_value)
    {
        if(!empty($field_value)) {
            $field_value = htmlspecialchars($field_value);
        }

        if($field_value === false) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = false WHERE id = '.$this->id;
        }elseif(empty($field_value)) {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = NULL WHERE id = '.$this->id;
        }else {
            $sql = 'UPDATE '.self::tableName().' SET '.$field_name.' = "'.$field_value.'" WHERE id = '.$this->id;
        }

        return Yii::$app->db->createCommand($sql)->execute();
    }
}
