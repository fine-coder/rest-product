<?php

namespace frontend\models\rest;

class PropertyValue extends \common\models\PropertyValue
{
    public function fields()
    {
        return parent::fields();
    }

    public function extraFields()
    {
        return [
            'property'
        ];
    }
}
