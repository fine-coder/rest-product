<?php

namespace frontend\models\rest;

class Product extends \common\models\Product
{
    public function fields()
    {
        //return ['id', 'name', 'url', 'price'];
        return parent::fields();
    }

    public function extraFields()
    {
        return [
            'category'
        ];
    }
}
