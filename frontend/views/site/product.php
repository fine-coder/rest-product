<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $product common\models\Product */

use yii\helpers\Html;

$this->title = $product->name;
//$this->params['breadcrumbs'][] = $this->title;

$css = <<<CSS

.product {
    font-size: 16px;
}

.product .row .content {
    background: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 4px;
    padding: 20px 25px;
    margin: 15px 0;
    color: #333333;
}

CSS;

$this->registerCss($css, ["type" => "text/css"]);

/*
echo '<pre>';
print_r($product);
echo '</pre>';

exit;
*/

?>

<div class="product">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="text-center">Цена: <?= $product->price ?> руб.</div>

    <div class="text-center">
        <a href="/category/<?= $product->category->url ?>"><?= $product->category->name ?></a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="content">
                <h4>Свойства продукта</h4>

                <?php foreach ($product->productProperties as $property): ?>
                <div class="property">
                    <strong><?= $property->property->name ?></strong>:
                    <span><?= $property->propertyValue->value ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
