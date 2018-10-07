<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\helper\Utils;

/* @var $this yii\web\View */
/* @var $model \app\models\component\PageListNews */


$this->title = Yii::t('app', 'Новости');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Создать'), ['admin-news/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $model->getNewsDataProvider(),
        'filterModel' => $model->filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'alias',
            'title',
            [
                'attribute'=>'active',
                'filter' => Utils::$yesNo,
                'value' => function($data) {
                    return Utils::valueActive($data->active);
                }
            ],
            [
                'attribute'=>'category_id',
                'value' => function($data) {
                    return $data->getCategory()->one()->title;
                }
            ],
            // 'text_short:ntext',
            // 'text_main:ntext',
            // 'user_create_id',
            // 'date_create',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
