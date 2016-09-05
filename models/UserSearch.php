<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['user_id', 'register_time', 'status'], 'integer'],
            [['username', 'email', 'role'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'register_time' => $this->register_time,
            'status' => $this->status,
            'name' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        return $dataProvider;
    }
}
