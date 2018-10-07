<?php

namespace app\models\component;

use app\models\News;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Данные для страницу со списокм новостей
 * Class NewsMain
 * @package app\models\component
 */
class PageListNews extends Model {

    /** @var NewsSearch Модель для фильтрации */
    public $filterModel;

    /** @var string Сортировка */
    public $order;

    /** @var int номер страницы */
    public $page;

    /** @var int Количество элементов на странице */
    public $limit;

    private $_newsDataProvider;

    public function init()
    {
        parent::init();
        $this->filterModel = new NewsSearch();
        $this->limit = 3;
    }

    public function rules()
    {
        return [
            ['page', 'default', 'value' => 1],
            ['order', 'default', 'value' => 'asc']
        ];
    }

    public function setAttributes($values, $safeOnly = true)
    {
        $this->filterModel->attributes = $values['NewsSearch']??[];
        parent::setAttributes($values, $safeOnly);
    }

    /**
     * Номер страницы для пагинатора
     * @return int
     */
    protected function getPagePagination()
    {
        $value = empty($this->page) || $this->page < 1 ? 1: $this->page;
        return $value-1;
    }

    /**
     * Провайдет до новостей
     * @return ActiveDataProvider
     */
    public function getNewsDataProvider()
    {
        if (!empty($this->_newsDataProvider)) {
            return $this->_newsDataProvider;
        }

        $query = $this->filterModel->getQuery();
        $query->orderBy('date_create '.$this->order);

        return $this->_newsDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $this->getPagePagination(),
                'pageSize' => $this->limit,
            ],
        ]);
    }
}
