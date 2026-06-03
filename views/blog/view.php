<?php
/** @var yii\web\View $this */
/** @var app\models\Article $article */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $article->getMetaTitle();
$this->params['meta_description'] = $article->getMetaDescription();
$this->params['canonical'] = Url::to(['blog/view', 'slug' => $article->slug], true);

$og = [
    'og:type' => 'article',
    'og:title' => $article->getMetaTitle(),
    'og:description' => $article->getMetaDescription(),
    'og:url' => $this->params['canonical'],
    'article:published_time' => $article->published_at ? date('c', $article->published_at) : null,
    'article:author' => $article->author?->username,
];
$ogImage = $article->getOgImageUrl();
if ($ogImage) {
    $og['og:image'] = Url::to($ogImage, true);
}
$this->params['og'] = array_filter($og);
?>
<article>
    <header class="article-header">
        <div class="article-header-meta">
            <?php if ($article->published_at): ?>
                <time datetime="<?= date('c', $article->published_at) ?>">
                    <?= Yii::$app->formatter->asDate($article->published_at, 'long') ?>
                </time>
            <?php endif; ?>
            <?php foreach ($article->categories as $i => $cat): ?>
                <a href="<?= $cat->getUrl() ?>"><?= Html::encode($cat->title) ?></a>
            <?php endforeach; ?>
            <?php if ($article->author): ?>
                <span>· <?= Html::encode($article->author->username) ?></span>
            <?php endif; ?>
        </div>
        <h1><?= Html::encode($article->title) ?></h1>
        <?php if ($article->excerpt): ?>
            <p class="article-header-excerpt"><?= Html::encode($article->excerpt) ?></p>
        <?php endif; ?>
    </header>

    <?php if ($article->cover_path): ?>
        <figure class="article-cover">
            <img src="<?= Html::encode($article->getCoverUrl()) ?>" alt="<?= Html::encode($article->title) ?>">
        </figure>
    <?php endif; ?>

    <div class="article-body">
        <?= $article->getRenderedHtml() ?>
    </div>

    <footer class="article-footer">
        <?php if (!empty($article->tags)): ?>
            <div class="tag-list">
                <?php foreach ($article->tags as $tag): ?>
                    <a href="<?= $tag->getUrl() ?>">#<?= Html::encode($tag->title) ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="ms-auto">
            <a href="<?= Url::to(['blog/index']) ?>" class="btn btn-outline-secondary btn-sm">← К ленте</a>
        </div>
    </footer>
</article>
