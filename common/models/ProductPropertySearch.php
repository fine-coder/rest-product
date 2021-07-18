<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductProperty;

/**
 * ProductPropertySearch represents the model behind the search form of `common\models\ProductProperty`.
 */
class ProductPropertySearch extends ProductProperty
{
    public $productName;
    public $propertyName;
    public $propertyNameValue;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['productName', 'propertyName', 'propertyNameValue'], 'safe'],
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
        $query = ProductProperty::find();
        $query->joinWith(['product', 'property', 'propertyValue']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['productName'] = [
            'asc' => [Product::tableName().'.name' => SORT_ASC],
            'desc' => [Product::tableName().'.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['propertyName'] = [
            'asc' => [Property::tableName().'.name' => SORT_ASC],
            'desc' => [Property::tableName().'.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['propertyNameValue'] = [
            'asc' => [PropertyValue::tableName().'.value' => SORT_ASC],
            'desc' => [PropertyValue::tableName().'.value' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            ProductProperty::tableName().'.id' => $this->id,
            //'product_id' => $this->product_id,
            //'property_id' => $this->property_id,
            //'property_value_id' => $this->property_value_id,
        ]);

        $query->andFilterWhere(['like', Product::tableName().'.name', $this->productName]);
        $query->andFilterWhere(['like', Property::tableName().'.name', $this->propertyName]);
        $query->andFilterWhere(['like', PropertyValue::tableName().'.value', $this->propertyNameValue]);

        return $dataProvider;
    }
}
