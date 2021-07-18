<?php

namespace frontend\models\rest;

class Category extends \common\models\Category
{
    public function fields()
    {
        return parent::fields();
    }

    public function extraFields()
    {
        return [];
    }
}
