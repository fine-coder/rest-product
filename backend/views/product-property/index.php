<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductPropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Свойства продуктов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-property-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute' => 'productName','label' => 'Продукт', 'value'=>'product.name'],
            ['attribute' => 'propertyName','label' => 'Свойство', 'value'=>'property.name'],
            ['attribute' => 'propertyNameValue','label' => 'Значение', 'value'=>'propertyValue.value'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
