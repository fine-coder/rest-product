<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyValue */
/* @var $properties common\models\Property */

$this->title = 'Добавить значение свойства';
$this->params['breadcrumbs'][] = ['label' => 'Значения свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'properties' => $properties
    ]) ?>

</div>
