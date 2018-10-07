<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \app\models\component\PageViewNews $model
 */

$modelComment = $model->newComment;
?>

<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->errorSummary($modelComment) ?>
        <div class="form-group">
            <?= $form->field($modelComment,'news_id')->hiddenInput(); ?>
            <?= $form->field($modelComment,'name')->textInput(); ?>
            <?= $form->field($modelComment,'comment')->textarea(); ?>
            <?= Html::submitButton(Yii::t('app', 'Оставить'), ['class' => $modelComment->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php foreach ($model->news->getNewsComments()->all() as $item): ?>
    <div class="row">
        <strong><?= $item->name ?></strong><br>
        <p>
            <?= $item->comment; ?>
        </p>
    </div>
<?php endforeach; ?>
