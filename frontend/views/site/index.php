<?php

/* @var $this yii\web\View */
/* @var $categories common\models\Category */

$this->title = 'Главная';

$css = <<<CSS

.category-grid .link {
	display: block;
	margin: 15px 0;
	text-decoration: none;
}

.category-grid .post {
	background: #ffffff;
	border: 1px solid #cccccc;
	border-radius: 4px;
	padding: 20px 25px;
	color: #333333;
}

CSS;

$this->registerCss($css, ["type" => "text/css"]);

?>

<div class="category-grid">
    <h1 class="text-center">Категории</h1>
    <div class="row">

        <?php foreach ($categories as $category): ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <a class="link" href="/category/<?= $category->url ?>">
                    <div class="post">
                        <h4><?= $category->name ?></h4>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
