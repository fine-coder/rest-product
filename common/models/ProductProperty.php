<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_property".
 *
 * @property int $id
 * @property int $product_id
 * @property int $property_id
 * @property int $property_value_id
 *
 * @property Product $product
 * @property Property $property
 * @property PropertyValue $propertyValue
 */
class ProductProperty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'property_id', 'property_value_id'], 'required'],
            [['product_id', 'property_id', 'property_value_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::className(), 'targetAttribute' => ['property_id' => 'id']],
            [['property_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyValue::className(), 'targetAttribute' => ['property_value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'property_id' => 'Property ID',
            'property_value_id' => 'Property Value ID',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::className(), ['id' => 'property_id']);
    }

    /**
     * Gets query for [[PropertyValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyValue()
    {
        return $this->hasOne(PropertyValue::className(), ['id' => 'property_value_id']);
    }
}
