<?php
/** @var yii\web\View $this */
/** @var app\models\Article[] $articles */
/** @var app\models\Category[] $categories */
/** @var app\models\Tag[] $tags */

use yii\helpers\Url;

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= Url::home(true) ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= Url::to(['blog/index'], true) ?></loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= Url::to(['site/about'], true) ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php foreach ($articles as $article): ?>
    <url>
        <loc><?= Url::to(['blog/view', 'slug' => $article->slug], true) ?></loc>
        <lastmod><?= date('Y-m-d', $article->updated_at) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($categories as $cat): ?>
    <url>
        <loc><?= Url::to(['blog/category', 'slug' => $cat->slug], true) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($tags as $tag): ?>
    <url>
        <loc><?= Url::to(['blog/tag', 'slug' => $tag->slug], true) ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
    </url>
    <?php endforeach; ?>
</urlset>
