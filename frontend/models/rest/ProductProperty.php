<?php

namespace frontend\models\rest;

class ProductProperty extends \common\models\ProductProperty
{
    public function fields()
    {
        return parent::fields();
    }

    public function extraFields()
    {
        return [
            'product',
            'property',
            'propertyValue'
        ];
    }
}
