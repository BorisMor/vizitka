<?php

namespace app\models\component;

use app\models\News;
use app\models\NewsComment;
use yii\base\Model;
use yii\web\NotFoundHttpException;

/**
 * Страница просмотра новости
 * Class PageViewNews
 * @package app\models\component
 */
class PageViewNews extends Model {

    /** @var News Новость */
    public $news;
    /** @var NewsComment Новый комментарий */
    public $newComment;

    public function init()
    {
        parent::init();
        $this->initNewComment();
    }

    public function initNewComment()
    {
        $this->newComment = new NewsComment();
        $this->newComment->name = \Yii::$app->user->isGuest ? '' : \Yii::$app->user->identity->username;
        $this->newComment->news_id = empty($this->news) ? null: $this->news->id;
    }

    protected function afterLoadNews()
    {
        $this->newComment->news_id = $this->news->id;
    }

    /**
     * Загрузить новость по алиасу
     * @param $alias
     * @return $this
     * @throws NotFoundHttpException
     */
    public function loadByAlias($alias)
    {
        if (($this->news = News::find()->where(['alias'=>$alias, 'active' => 1])->one()) !== null) {
            $this->afterLoadNews();
            return $this;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
