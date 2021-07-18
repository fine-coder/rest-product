<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductProperty */
/* @var $products common\models\Product */
/* @var $properties common\models\Property */
/* @var $property_values common\models\PropertyValue */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Свойства продуктов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="product-property-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', compact('model', 'products', 'properties', 'property_values')) ?>

</div>
