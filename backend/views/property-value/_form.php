<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyValue */
/* @var $properties common\models\Property */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-value-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'property_id')->dropDownList($properties) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
