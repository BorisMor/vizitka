<?php

namespace app\models\component;

use app\models\NewsCategory;

/**
 * Модель для фильтрации категорий новостей
 * Class NewsCategorySearch
 * @package app\models\component
 */
class NewsCategorySearch extends NewsCategory{

    public function rules()
    {
        return [
            [['id', 'title', 'parent_id', 'active'], 'safe'],
        ];
    }

    public function getQuery()
    {
        $query = NewsCategory::find();

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'active' => $this->active,
        ]);
        $query->andFilterWhere(['<>', 'id', 1]);
        $query->andFilterWhere(['like', 'alias', $this->title]);

        return $query;
    }
}
