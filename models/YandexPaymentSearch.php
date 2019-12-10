<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\YandexPayment;

/**
 * YandexPaymentSearch represents the model behind the search form of `app\models\YandexPayment`.
 */
class YandexPaymentSearch extends YandexPayment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source_payment_id', 'client_ext_id', 'created_at', 'pending_at', 'waiting_for_capture_at', 'succeeded_at', 'canceled_at'], 'integer'],
            [['type', 'source_type', 'yandex_payment_id', 'source_yandex_payment_id', 'currency', 'payment_type', 'status'], 'safe'],
            [['value'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = YandexPayment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'source_payment_id' => $this->source_payment_id,
            'source_type' => $this->source_type,
            'client_ext_id' => $this->client_ext_id,
            'value' => $this->value,
            'created_at' => $this->created_at,
            'pending_at' => $this->pending_at,
            'waiting_for_capture_at' => $this->waiting_for_capture_at,
            'succeeded_at' => $this->succeeded_at,
            'canceled_at' => $this->canceled_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'yandex_payment_id', $this->yandex_payment_id])
            ->andFilterWhere(['like', 'source_yandex_payment_id', $this->source_yandex_payment_id])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'payment_type', $this->payment_type])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
