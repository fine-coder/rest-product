<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Property;

/**
 * PropertySearch represents the model behind the search form of `common\models\Property`.
 */
class PropertySearch extends Property
{
    public $categoryName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['name', 'categoryName'], 'safe'],
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
        $query = Property::find();
        $query->joinWith(['category']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['categoryName'] = [
            'asc' => [Category::tableName().'.name' => SORT_ASC],
            'desc' => [Category::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            Property::tableName().'.id' => $this->id,
            //'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', Property::tableName().'.name', $this->name]);
        $query->andFilterWhere(['like', Category::tableName().'.name', $this->categoryName]);

        return $dataProvider;
    }
}
