<?php

namespace app\models\component;

use app\models\NewsCategory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Данные для страницы со списком категорий новостей
 * Class PageListNewsCategory
 * @package app\models\component
 */
class PageListNewsCategory extends Model {

    /** @var NewsCategorySearch Модель для фильтрации */
    public $filterModel;

    /** @var int номер страницы */
    public $page;

    /** @var int Количество элементов на странице */
    public $limit;

    private $_newsDataProvider;

    public function init()
    {
        parent::init();
        $this->filterModel = new NewsCategorySearch();
        $this->limit = 10;
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
        $this->filterModel->attributes = $values['NewsCategorySearch']??[];
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
    public function getDataProvider()
    {
        if (!empty($this->_newsDataProvider)) {
            return $this->_newsDataProvider;
        }

        $query = $this->filterModel->getQuery();

        return $this->_newsDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $this->getPagePagination(),
                'pageSize' => $this->limit,
            ],
        ]);
    }



}
