<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

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
            'name',
            'url',
            'price',
            ['attribute' => 'categoryName','label' => 'Категория', 'value'=>'category.name'],

            //['class' => 'yii\grid\ActionColumn'],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add} {view} {update} {delete}',
                'buttons' => [
                    'add' => function ($url,$model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', '/admin/product-property/create?product='.$model->id, ['class' => '', 'target' => '_blank', 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
