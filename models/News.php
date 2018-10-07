<?php

namespace app\models;

use app\helper\Str;
use app\helper\Utils;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $alias алиас
 * @property string $title Заголовок
 * @property int $active Активность
 * @property int $category_id Категория
 * @property string $text_short Анонс
 * @property string $text_main Полный текст
 * @property int $user_create_id Кто создал
 * @property string $date_create Дата создания
 *
 * @property NewsCategory $category
 * @property Users $userCreate
 * @property NewsComment[] $newsComments
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
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
            [['alias', 'title', 'category_id', 'text_short', 'text_main', 'user_create_id'], 'required'],
            [['active', 'category_id', 'user_create_id'], 'integer'],
            [['active', 'category_id'], 'default', 'value' => 1],
            [['text_short', 'text_main'], 'string'],
            [['date_create'], 'safe'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => NewsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_create_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_create_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'алиас'),
            'title' => Yii::t('app', 'Заголовок'),
            'active' => Yii::t('app', 'Активность'),
            'category_id' => Yii::t('app', 'Категория'),
            'text_short' => Yii::t('app', 'Анонс'),
            'text_main' => Yii::t('app', 'Полный текст'),
            'user_create_id' => Yii::t('app', 'Кто создал'),
            'date_create' => Yii::t('app', 'Дата создания'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreate()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_create_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsComments()
    {
        return $this->hasMany(NewsComment::className(), ['news_id' => 'id']);
    }


    public function beforeValidate()
    {
        if($this->isNewRecord) {
            $this->user_create_id = Yii::$app->user->id;
        }

        if(empty($this->alias ) && !empty($this->title)) {
            $this->alias = Str::transliterationUrl($this->title);
        }


        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(NewsCategory::KEY_CACHE_MAIN_MENU);
    }

    public function showDateCreate()
    {
        return Utils::isDate($this->date_create)->format('d.m.Y');
    }
}
