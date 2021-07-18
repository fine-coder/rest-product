<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductProperty */
/* @var $products common\models\Product */
/* @var $properties common\models\Property */
/* @var $property_values common\models\PropertyValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-property-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($products) ?>

    <?= $form->field($model, 'property_id')->dropDownList($properties) ?>

    <?= $form->field($model, 'property_value_id')->dropDownList($property_values) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
