<?php
use yii\helpers\Html;
/**
 * @var \app\models\component\PageViewNews $model
 *
 */

$this->title = $model->news->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($model->news->title) ?></h1>
<span style="color:#a94848"><?= $model->news->showDateCreate() ?></span>
<br>
<?= nl2br(Html::encode($model->news->text_main)); ?>



<hr>
<h3>Комментарии</h3>
<?= $this->render('_newsComment', [
    'model' => $model
]) ?>
