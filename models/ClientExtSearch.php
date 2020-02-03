<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ClientExt;

/**
 * ClientExtSearch represents the model behind the search form of `app\models\ClientExt`.
 */
class ClientExtSearch extends ClientExt
{
    //public $username = "";
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'main_server_order_id', 'user_id', 'yandex_point_from_id',
                'yandex_point_to_id', 'places_count', 'is_paid', 'payment_in_process',
                'suitcase_count', 'bag_count', 'prize_trip_count',
                'student_count', 'child_count', 'paid_time', ], 'integer'],
            [['status', 'direction_id', 'data', 'time', 'trip_name',
                // 'street_from', 'point_from',
                'yandex_point_from_name',
                // 'street_to', 'point_to',
                'yandex_point_to_name', 'transport_car_reg', 'transport_model',
                'transport_color', 'friend_code', 'status_setting_time', 'time_confirm',
                'created_at', 'updated_at', 'sync_date', // 'fio',
                'last_name', 'first_name'
                ], 'safe'],
            [['yandex_point_from_lat', 'yandex_point_from_long', 'yandex_point_to_lat', 'yandex_point_to_long',
                'price', 'paid_summ',
                'accrual_cash_back', 'penalty_cash_back', 'used_cash_back',
                'discount'], 'number'],
            [['time_air_train_arrival', 'time_air_train_departure', 'but_checkout', 'is_not_places', //'gen',
                'payment_source'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ClientExt::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->session->get('table-rows', 20)
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'main_server_order_id' => $this->main_server_order_id,
            'direction_id' => $this->direction_id,
            //'status_setting_time' => $this->status_setting_time,
            'status' => $this->status,
            'user_id' => $this->user_id,
            //'time_confirm' => $this->time_confirm,
            'yandex_point_from_id' => $this->yandex_point_from_id,
            'yandex_point_from_lat' => $this->yandex_point_from_lat,
            'yandex_point_from_long' => $this->yandex_point_from_long,
            'yandex_point_to_id' => $this->yandex_point_to_id,
            'yandex_point_to_lat' => $this->yandex_point_to_lat,
            'yandex_point_to_long' => $this->yandex_point_to_long,
            'time_air_train_arrival' => $this->time_air_train_arrival,
            'time_air_train_departure' => $this->time_air_train_departure,
            'places_count' => $this->places_count,
            'student_count' => $this->student_count,
            'child_count' => $this->child_count,
            'is_not_places' => $this->is_not_places,
            'suitcase_count' => $this->suitcase_count,
            'bag_count' => $this->bag_count,
            'prize_trip_count' => $this->prize_trip_count,
            'price' => $this->price,
            'paid_summ' => $this->paid_summ,
            'payment_source' => $this->payment_source,
            'accrual_cash_back' => $this->accrual_cash_back,
            'penalty_cash_back' => $this->penalty_cash_back,
            'used_cash_back' => $this->used_cash_back,
            'discount' => $this->discount,
            'payment_in_process' => $this->payment_in_process,
            'is_paid' => $this->is_paid,
            'paid_time' => $this->paid_time,
            'but_checkout' => $this->but_checkout,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'sync_date' => $this->sync_date,
//            'data' => $this->data,
        ]);


        $query
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'trip_name', $this->trip_name])
            //->andFilterWhere(['like', 'street_from', $this->street_from])
            //->andFilterWhere(['like', 'point_from', $this->point_from])
            ->andFilterWhere(['like', 'yandex_point_from_name', $this->yandex_point_from_name])
            //->andFilterWhere(['like', 'street_to', $this->street_to])
            //->andFilterWhere(['like', 'point_to', $this->point_to])
            ->andFilterWhere(['like', 'yandex_point_to_name', $this->yandex_point_to_name])
            ->andFilterWhere(['like', 'transport_car_reg', $this->transport_car_reg])
            ->andFilterWhere(['like', 'transport_model', $this->transport_model])
            ->andFilterWhere(['like', 'transport_color', $this->transport_color])
            ->andFilterWhere(['like', 'friend_code', $this->friend_code]);

        if (!empty($this->status_setting_time)) {
            $status_setting_time = strtotime($this->status_setting_time);
            $query->andFilterWhere(['<', $this->tableName().'.status_setting_time', $status_setting_time + 86400]);
            $query->andFilterWhere(['>=', $this->tableName().'.status_setting_time', $status_setting_time]);
        }
        if (!empty($this->time_confirm)) {
            $time_confirm = strtotime($this->time_confirm);
            $query->andFilterWhere(['<', $this->tableName().'.time_confirm', $time_confirm + 86400]);
            $query->andFilterWhere(['>=', $this->tableName().'.time_confirm', $time_confirm]);
        }
        if (!empty($this->created_at)) {
            $created_at = strtotime($this->created_at);
            $query->andFilterWhere(['<', $this->tableName().'.created_at', $created_at + 86400]);
            $query->andFilterWhere(['>=', $this->tableName().'.created_at', $created_at]);
        }
        if (!empty($this->updated_at)) {
            $updated_at = strtotime($this->updated_at);
            $query->andFilterWhere(['<', $this->tableName().'.updated_at', $updated_at + 86400]);
            $query->andFilterWhere(['>=', $this->tableName().'.updated_at', $updated_at]);
        }
        if (!empty($this->sync_date)) {
            $sync_date = strtotime($this->sync_date);
            $query->andFilterWhere(['<', $this->tableName().'.sync_date', $sync_date + 86400]);
            $query->andFilterWhere(['>=', $this->tableName().'.sync_date', $sync_date]);
        }
//        if (!empty($this->data)) {
//            $data = strtotime($this->data);
//            $query->andFilterWhere(['<', $this->tableName().'.data', $data + 86400]);
//            $query->andFilterWhere(['>=', $this->tableName().'.data', $data]);
//        }

        return $dataProvider;
    }
}
