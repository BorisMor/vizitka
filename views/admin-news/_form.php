<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\NewsCategory;

/* @var $this yii\web\View */
/* @var $model \app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if($model->alias) {
        echo $form->field($model, 'alias')->textInput(['disabled'=>true]);
    } ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        NewsCategory::getList(),
        ['prompt' => '']
    ) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'text_short')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text_main')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Создать') : Yii::t('app', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
