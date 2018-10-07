<?php

namespace app\models\component;

use app\models\News;

/**
 * Модель для фильтра News
 * Class NewsSearch
 * @package app\models\component
 */
class NewsSearch extends News {

    public function rules()
    {
        return [
            [['id', 'alias', 'title', 'category_id', 'user_create_id'], 'safe'],
        ];
    }

    /**
     * Построитель запроса
     * @return \yii\db\ActiveQuery
     */
    public function getQuery()
    {
        $query = News::find();

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'user_create_id' => $this->user_create_id,
        ]);

        $query
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $query;
    }
}
