<?php

namespace app\models;

use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property int $created_at
 * @property-read Article[] $articles
 */
class Tag extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%tag}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => fn() => time(),
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 160],
            [['slug'], 'match', 'pattern' => '/^[a-z0-9\-]+$/'],
            [['slug'], 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Тег',
            'created_at' => 'Создан',
        ];
    }

    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['id' => 'article_id'])
            ->viaTable('{{%article_tag}}', ['tag_id' => 'id']);
    }

    public function getUrl(): string
    {
        return Url::to(['blog/tag', 'slug' => $this->slug]);
    }

    public static function findOrCreate(string $title): self
    {
        $title = trim($title);
        $tag = static::findOne(['title' => $title]);
        if ($tag === null) {
            $tag = new static(['title' => $title]);
            $tag->save();
        }
        return $tag;
    }
}
