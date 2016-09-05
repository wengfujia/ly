<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{

    public function rules()
    {
        return [
        	[['PostID', 'Author'], 'string'],
            [['DateCreated', 'DateModified'], 'integer'],
            [['Title', 'Slug', 'Description', 'PostContent', 'Status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /*
     * 查询
     * */
    public function search($params)
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'PostID' => $this->PostID,
            'Status' => $this->Status,
            'Author' => $this->Author,
            'DateCreated' => $this->DateCreated,
            'DateModified' => $this->DateModified
        ]);

        $query->andFilterWhere(['like', 'Title', $this->Title]);

        return $dataProvider;
    }
}
