<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \app\models\component\PageListNewsCategory */

$this->title = Yii::t('app', 'Категория новости');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Создать'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $model->getDataProvider(),
        'filterModel' => $model->filterModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'parent_id',
                'value' =>  function($data){
                    return $data->getParentCategory()->one()->title;
                }
            ],
            [
                'attribute' => 'active',
                'filter' => ['1'=>'Да', '0' => 'Нет'],
                'value' =>  function($data){
                    return $data->getActiveLabel();
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
