<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\YandexPoint;

/**
 * YandexPointSearch represents the model behind the search form of `app\models\YandexPoint`.
 */
class YandexPointSearch extends YandexPoint
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'city_id', 'active', 'critical_point', 'super_tariff_used'], 'integer'],
            [['lat', 'long'], 'number'],
            [['alias'], 'string', 'max' => 10],
            [['name', 'description', 'point_of_arrival',
                'popular_departure_point', 'popular_arrival_point'], 'safe'],
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
        $query = YandexPoint::find();

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
            'city_id' => $this->city_id,
            'lat' => $this->lat,
            'long' => $this->long,
            'active' => $this->active,
            'point_of_arrival' => $this->point_of_arrival,
            'super_tariff_used' => $this->super_tariff_used,
            'critical_point' => $this->critical_point,
            'popular_departure_point' => $this->popular_departure_point,
            'popular_arrival_point' => $this->popular_arrival_point,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
