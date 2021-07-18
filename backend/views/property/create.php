<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Property */
/* @var $categories common\models\Category */

$this->title = 'Добавить свойство';
$this->params['breadcrumbs'][] = ['label' => 'Свойства', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
