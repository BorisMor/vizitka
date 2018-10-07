<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * @var \app\models\News $model
 * // $model, $key, $index, $widget
 */
?>

<div class="news-item">
    <h2><?= Html::encode($model->title) ?></h2>
    <?= HtmlPurifier::process($model->text_short) ?> <br>
    <?= Html::a('Перейти', ['site/view-news', 'alias'=> $model->alias]) ?>
</div>
