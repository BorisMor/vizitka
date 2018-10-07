<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "news_category".
 *
 * @property int $id
 * @property string $title Название
 * @property int $parent_id Родительская категория
 * @property int $active Активность категории
 *
 * @property News[] $news
 * @property NewsCategory $parent
 * @property NewsCategory[] $newsCategories
 */
class NewsCategory extends \yii\db\ActiveRecord
{

    /** Ключ кэшка для пунктов главного меню */
    const KEY_CACHE_MAIN_MENU = 'key_cache_main_menu';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_category';
    }

    public function init()
    {
        parent::init();
        $this->active = 1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id', 'active'], 'default', 'value' => 1],
            [['parent_id', 'active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Название'),
            'parent_id' => Yii::t('app', 'Родительская категория'),
            'active' => Yii::t('app', 'Активность категории'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategories()
    {
        return $this->hasMany(NewsCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * Получить список категорий
     *
     * @param array $deletedIds Исключить из списка категорий
     * @return array
     */
    public static function getList($deletedIds = [])
    {
        $result = [];

        /** @var \yii\db\Query $query */
        $query = new Query();
        $query
            ->select(['t.id', 't.title'])
            ->from('news_category t')
            ->orderBy('t.parent_id, t.title');

        if(!empty($deletedIds)) {
            $query->andWhere(['not in', 't.id', $deletedIds]);
        }

        $res = $query->all();
        foreach ($res as $item) {
            $result[$item['id']] = $item['title'];
        }

        return $result;
    }

    /**
     * Получить список категорий кроме текущей
     *
     * @return array
     */
    public function getListOtherCategory()
    {
        return self::getList($this->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasMany(NewsCategory::className(), ['id' => 'parent_id']);
    }

    public function getActiveLabel()
    {
        return empty($this->active) ? 'Нет' : 'Да';
    }

    /**
     * Рекурсивный обход по родителю
     *
     * @param $parentId
     * @return array
     */
    private static function _getRecurseMainMenu($parentId)
    {
        $result = [];
        $items = NewsCategory::find()
            ->select(['id', 'title', 'parent_id'])
            ->andWhere('[[active]]=1')
            ->andWhere(['parent_id'=>$parentId])
            ->all();

        foreach ($items as $item){
            $idMenu = $item['id'];
            $itemMenu = ['label' => $item['title']];
            $itemMenu['template'] = '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>';

            $subMenuItems = self::_getRecurseMainMenu($idMenu);
            if(empty($subMenuItems)) {
                $itemMenu['url'] = ['/site/news-category/', 'category_id' => $idMenu];
            }
            else {
                $itemMenu['items'] = $subMenuItems;
            }

            $result[] = $itemMenu;
        }

        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->cache->delete(self::KEY_CACHE_MAIN_MENU);
        return parent::afterSave($insert, $changedAttributes);
    }

    public function afterDelete()
    {
        Yii::$app->cache->delete(self::KEY_CACHE_MAIN_MENU);
        return parent::afterDelete();
    }

    public static function getMainMenu()
    {

        $result = Yii::$app->cache->get(self::KEY_CACHE_MAIN_MENU);
        if($result == false) {
            $result = self::_getRecurseMainMenu(1);
            Yii::$app->cache->set(self::KEY_CACHE_MAIN_MENU, $result, 60);
        }

        return $result;
    }
}
