<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $category common\models\Category */
/* @var $properties common\models\Property */
/* @var $products common\models\Product */

use yii\helpers\Html;

$this->title = $category->name;
//$this->params['breadcrumbs'][] = $this->title;

$css = <<<CSS

.category .row .sidebar,
.category .row .content .property-item {
    background: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 4px;
    padding: 20px 25px;
    margin: 15px 0;
    color: #333333;
}

.category .row .sidebar h3 {
    margin-bottom: 20px;
    font-size: 20px;
}

.category .row .sidebar label {
    font-weight: 300;
}

.category .row .content a {
    text-decoration: none;
}

.category .row .content .property-item .price {
    margin-bottom: 10px;
    font-size: 16px;
}

.category .row .content .property-item .caption {
    margin-bottom: 2px;
    font-size: 16px;
}

CSS;

$this->registerCss($css, ["type" => "text/css"]);

/*
echo '<pre>';
print_r($products);
echo '</pre>';

exit;
*/

?>

<div class="category">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="sidebar">
                <h3>Некое подобие фильтра</h3>

                <?php foreach ($properties as $property): ?>
                <div class="property">
                    <h4><?= $property->name ?></h4>

                    <?php foreach ($property->propertyValues as $key => $val): ?>
                    <div>
                        <input type="checkbox" id="k<?= $key ?>" />
                        <label for="k<?= $key ?>"><?= $val->value ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="content">

                <?php foreach ($products as $product): ?>
                <a href="/category/<?= $category->id ?>/product/<?= $product['url'] ?>">
                    <div class="property-item">
                        <h4><?= $product['name'] ?></h4>
                        <div class="price">Цена: <?= $product['price'] ?> руб.</div>
                        <div class="caption">Свойства</div>

                        <?php foreach ($product['productProperties'] as $prop): ?>
                            <div><?= $prop['property']['name'] ?>: <?= $prop['propertyValue']['value'] ?></div>
                        <?php endforeach; ?>
                    </div>
                </a>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
