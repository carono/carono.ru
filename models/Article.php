<?php

namespace app\models;

use cebe\markdown\GithubMarkdown;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string|null $excerpt
 * @property string $content_md
 * @property string|null $cover_path
 * @property int $status
 * @property int|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $og_image_path
 * @property int $author_id
 * @property int $view_count
 * @property int $created_at
 * @property int $updated_at
 * @property-read User $author
 * @property-read Category[] $categories
 * @property-read Tag[] $tags
 */
class Article extends ActiveRecord
{
    public const STATUS_DRAFT = 0;
    public const STATUS_PUBLISHED = 1;

    /** @var int[]|null Категории к сохранению (для формы) */
    public ?array $categoryIds = null;

    /** @var string|null Теги в виде строки через запятую (для формы) */
    public ?string $tagsString = null;

    /** @var \yii\web\UploadedFile|null */
    public $coverFile;

    /** @var \yii\web\UploadedFile|null */
    public $ogFile;

    public static function tableName(): string
    {
        return '{{%article}}';
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
            [['title', 'content_md'], 'required'],
            [['title', 'meta_title', 'cover_path', 'og_image_path'], 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 160],
            [['slug'], 'match', 'pattern' => '/^[a-z0-9\-]+$/'],
            [['slug'], 'unique'],
            [['excerpt', 'content_md'], 'string'],
            [['meta_description'], 'string', 'max' => 500],
            [['status'], 'in', 'range' => [self::STATUS_DRAFT, self::STATUS_PUBLISHED]],
            [['author_id'], 'integer'],
            [['published_at'], 'integer'],
            [['view_count'], 'integer'],
            [['categoryIds'], 'each', 'rule' => ['integer']],
            [['tagsString'], 'string'],
            [['coverFile', 'ogFile'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 4 * 1024 * 1024, 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Заголовок',
            'excerpt' => 'Краткое описание',
            'content_md' => 'Содержимое (Markdown)',
            'cover_path' => 'Обложка',
            'status' => 'Статус',
            'published_at' => 'Опубликовано',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'og_image_path' => 'OG-картинка',
            'author_id' => 'Автор',
            'view_count' => 'Просмотры',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'categoryIds' => 'Категории',
            'tagsString' => 'Теги',
        ];
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $status = (int)$this->status;
        if ($status === self::STATUS_PUBLISHED && empty($this->published_at)) {
            $this->published_at = time();
        }
        if ($status === self::STATUS_DRAFT) {
            $this->published_at = null;
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->categoryIds !== null) {
            $this->syncCategories($this->categoryIds);
        }
        if ($this->tagsString !== null) {
            $this->syncTagsFromString($this->tagsString);
        }
        Yii::$app->cache->delete($this->renderedCacheKey());
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('{{%article_category}}', ['article_id' => 'id']);
    }

    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }

    public static function findPublished(): ActiveQuery
    {
        return static::find()
            ->where(['status' => self::STATUS_PUBLISHED])
            ->andWhere(['<=', 'published_at', time()])
            ->orderBy(['published_at' => SORT_DESC]);
    }

    public function isPublished(): bool
    {
        return (int)$this->status === self::STATUS_PUBLISHED
            && $this->published_at !== null
            && (int)$this->published_at <= time();
    }

    public function getUrl(bool $absolute = false): string
    {
        return Url::to(['blog/view', 'slug' => $this->slug], $absolute ? true : false);
    }

    public function getCoverUrl(): ?string
    {
        return $this->cover_path ? Yii::getAlias('@web/' . ltrim($this->cover_path, '/')) : null;
    }

    public function getOgImageUrl(): ?string
    {
        $path = $this->og_image_path ?: $this->cover_path;
        return $path ? Yii::getAlias('@web/' . ltrim($path, '/')) : null;
    }

    public function getMetaTitle(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getMetaDescription(): string
    {
        if ($this->meta_description) {
            return $this->meta_description;
        }
        if ($this->excerpt) {
            return StringHelper::truncate(strip_tags($this->excerpt), 200);
        }
        return StringHelper::truncate(strip_tags($this->renderHtml()), 200);
    }

    public function getRenderedHtml(): string
    {
        $key = $this->renderedCacheKey();
        return Yii::$app->cache->getOrSet($key, fn() => $this->renderHtml(), 3600);
    }

    private function renderHtml(): string
    {
        $parser = new GithubMarkdown();
        $parser->html5 = true;
        $parser->keepListStartNumber = true;
        $html = $parser->parse((string)$this->content_md);
        return HtmlPurifier::process($html, [
            'Attr.AllowedFrameTargets' => ['_blank'],
            'HTML.Allowed' => 'h1,h2,h3,h4,h5,h6,p,br,strong,em,a[href|title|target|rel],ul,ol,li,blockquote,code,pre,img[src|alt|title|width|height],hr,table,thead,tbody,tr,td[colspan|rowspan],th[colspan|rowspan]',
        ]);
    }

    private function renderedCacheKey(): string
    {
        return 'article:rendered:' . $this->id . ':' . $this->updated_at;
    }

    public function syncCategories(array $ids): void
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));
        Yii::$app->db->createCommand()->delete('{{%article_category}}', ['article_id' => $this->id])->execute();
        foreach ($ids as $id) {
            Yii::$app->db->createCommand()->insert('{{%article_category}}', [
                'article_id' => $this->id,
                'category_id' => $id,
            ])->execute();
        }
    }

    public function syncTagsFromString(string $raw): void
    {
        $titles = array_filter(array_map('trim', preg_split('/[,;]+/', $raw)));
        $tagIds = [];
        foreach ($titles as $title) {
            $tagIds[] = Tag::findOrCreate($title)->id;
        }
        Yii::$app->db->createCommand()->delete('{{%article_tag}}', ['article_id' => $this->id])->execute();
        foreach (array_unique($tagIds) as $tagId) {
            Yii::$app->db->createCommand()->insert('{{%article_tag}}', [
                'article_id' => $this->id,
                'tag_id' => $tagId,
            ])->execute();
        }
    }

    public function loadFormFields(array $post): void
    {
        $this->categoryIds = $post['Article']['categoryIds'] ?? [];
        $this->tagsString = $post['Article']['tagsString'] ?? '';
    }

    public function fillTagsString(): void
    {
        $this->tagsString = implode(', ', array_map(fn(Tag $t) => $t->title, $this->tags));
    }

    public function fillCategoryIds(): void
    {
        $this->categoryIds = array_map(fn(Category $c) => $c->id, $this->categories);
    }

    public function incrementViewCount(): void
    {
        static::updateAllCounters(['view_count' => 1], ['id' => $this->id]);
    }
}
