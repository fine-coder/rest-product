<?php

namespace frontend\models\rest;

class Property extends \common\models\Property
{
    public function fields()
    {
        return parent::fields();
    }

    public function extraFields()
    {
        return [
            'category'
        ];
    }
}
