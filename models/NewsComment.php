<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news_comment".
 *
 * @property int $id
 * @property int $news_id Новость
 * @property int $user_id Пользователь
 * @property int $active Активность
 * @property string $comment Комментрий
 * @property string $date_create Дата
 * @property string $name Имя
 *
 * @property News $news
 * @property Users $user
 */
class NewsComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id','comment', 'name'], 'required'],
            [['news_id', 'user_id'], 'default', 'value' => null],
            [['active'], 'default', 'value' =>1],
            [['news_id', 'user_id', 'active'], 'integer'],
            [['comment'], 'string'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'news_id' => Yii::t('app', 'Новость'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'active' => Yii::t('app', 'Активность'),
            'comment' => Yii::t('app', 'Комментрий'),
            'date_create' => Yii::t('app', 'Дата'),
            'name' => Yii::t('app', 'Имя'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
