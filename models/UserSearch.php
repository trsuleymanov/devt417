<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'last_login_date', 'attempt_count', 'attempt_date',
                //'confirmed',
                'created_at', 'updated_at', 'blocked'], 'integer'],
            [['auth_key', 'password_hash', 'token', 'email', 'fio', 'phone', 'last_ip', 'restore_code', 'code_for_friends',
                'friend_code', 'push_token', 'email_is_confirmed', 'phone_is_confirmed'], 'safe'],
            [['account'], 'number'],
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
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->session->get('table-rows', 20)
            ],
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
            'phone_is_confirmed' => $this->phone_is_confirmed,
            'last_login_date' => $this->last_login_date,
            'attempt_count' => $this->attempt_count,
            'attempt_date' => $this->attempt_date,
            //'confirmed' => $this->confirmed,
            'account' => $this->account,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'blocked' => $this->blocked,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip])
            ->andFilterWhere(['like', 'restore_code', $this->restore_code])
            ->andFilterWhere(['like', 'code_for_friends', $this->code_for_friends])
            ->andFilterWhere(['like', 'friend_code', $this->friend_code])
            ->andFilterWhere(['like', 'push_token', $this->push_token]);

        return $dataProvider;
    }
}
