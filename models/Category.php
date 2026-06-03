<?php

namespace app\models;

use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 * @property-read Article[] $articles
 */
class Category extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%category}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
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
            [['description'], 'string'],
        ];
    }

    public function fields(): array
    {
        return [
            'id', 'slug', 'title', 'description', 'created_at', 'updated_at',
            'url' => fn(self $m) => $m->getUrl(),
        ];
    }

    public function extraFields(): array
    {
        return ['articles'];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Название',
            'description' => 'Описание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['id' => 'article_id'])
            ->viaTable('{{%article_category}}', ['category_id' => 'id']);
    }

    public function getUrl(bool $absolute = false): string
    {
        return Url::to(['/blog/category', 'slug' => $this->slug], $absolute ? true : false);
    }
}
