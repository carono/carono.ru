<?php
/** @var yii\web\View $this */
/** @var app\models\Article $article */

use yii\helpers\Html;
use yii\helpers\StringHelper;
?>
<li class="article-card">
    <?php if ($article->cover_path): ?>
        <a href="<?= $article->getUrl() ?>" class="article-card-cover d-block">
            <img src="<?= Html::encode($article->getCoverUrl()) ?>" alt="<?= Html::encode($article->title) ?>" loading="lazy">
        </a>
    <?php endif; ?>
    <div class="article-card-meta">
        <?php if ($article->published_at): ?>
            <time datetime="<?= date('c', $article->published_at) ?>"><?= Yii::$app->formatter->asDate($article->published_at, 'long') ?></time>
        <?php endif; ?>
        <?php foreach ($article->categories as $cat): ?>
            · <a href="<?= $cat->getUrl() ?>"><?= Html::encode($cat->title) ?></a>
        <?php endforeach; ?>
    </div>
    <h2><a href="<?= $article->getUrl() ?>"><?= Html::encode($article->title) ?></a></h2>
    <?php if ($article->excerpt): ?>
        <p class="article-card-excerpt"><?= Html::encode(StringHelper::truncate($article->excerpt, 240)) ?></p>
    <?php endif; ?>
    <a href="<?= $article->getUrl() ?>" class="article-card-readmore">Читать дальше →</a>
</li>
