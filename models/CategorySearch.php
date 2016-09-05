<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['CategoryID','ParentID'], 'string'],
            [['SortOrder', 'UpdateTime'], 'integer'],
            [['CategoryName', 'Description'], 'safe'],
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
        $query = Category::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'CategoryID' => $this->CategoryID,
            'ParentID' => $this->ParentID,
            'SortOrder' => $this->SortOrder,
            'UpdateTime' => $this->UpdateTime,
            'CategoryName' => $this->CategoryName
        ]);

        $query->andFilterWhere(['like', 'Description', $this->Description]);

        return $dataProvider;
    }
    
}
