<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PropertyValue;

/**
 * PropertyValueSearch represents the model behind the search form of `common\models\PropertyValue`.
 */
class PropertyValueSearch extends PropertyValue
{
    public $propertyName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'property_id'], 'integer'],
            [['value', 'propertyName'], 'safe'],
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
        $query = PropertyValue::find();
        $query->joinWith(['property']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['propertyName'] = [
            'asc' => [Property::tableName().'.name' => SORT_ASC],
            'desc' => [Property::tableName().'.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            PropertyValue::tableName().'.id' => $this->id,
            //'property_id' => $this->property_id,
        ]);

        $query->andFilterWhere(['like', PropertyValue::tableName().'.value', $this->value]);
        $query->andFilterWhere(['like', Property::tableName().'.name', $this->propertyName]);

        return $dataProvider;
    }
}
