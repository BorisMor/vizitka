<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var \app\models\component\PageListNews $model */

$this->title = Yii::t('app', 'Новости');
$newOrder =  ($model->order == 'asc') ? 'desc' : 'asc';

?>
<div class="news-index">

    <?php if (!empty($model->filterModel->category_id)): ?>
        <h1>Категория:
            <span style="color:red">
            <?= $model->filterModel->category->title ?>
            </span>

        </h1>
    <?php endif; ?>

    Текущая сортировка: <a href="<?= \yii\helpers\Url::toRoute(['/site/index', 'order' => $newOrder])  ?>">
        <?= $model->order == 'asc' ? 'По дате' : 'Сначала новые'  ?>
    </a>

    <p>
    </p>
    <?php Pjax::begin(); ?>
    <?= ListView::widget([
        'dataProvider' => $model->getNewsDataProvider(),
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_newsItem',
        'layout' => "\n{items}\n{pager}\n",
        // 'layout' => "\n{summary}\n{items}\n{pager}",
    ]) ?>
    <?php Pjax::end(); ?>

</div>
