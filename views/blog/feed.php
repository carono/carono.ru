<?php
/** @var yii\web\View $this */
/** @var app\models\Article[] $articles */

use yii\helpers\Html;
use yii\helpers\Url;

$siteUrl = rtrim(Yii::$app->params['siteUrl'], '/');
$updated = !empty($articles) ? max(array_map(fn($a) => $a->published_at ?: $a->updated_at, $articles)) : time();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?= Html::encode(Yii::$app->params['siteName']) ?></title>
        <link><?= $siteUrl ?>/</link>
        <description><?= Html::encode(Yii::$app->params['siteDescription']) ?></description>
        <language>ru</language>
        <lastBuildDate><?= date(DATE_RSS, $updated) ?></lastBuildDate>
        <atom:link href="<?= Url::to(['blog/feed'], true) ?>" rel="self" type="application/rss+xml"/>
        <?php foreach ($articles as $article): ?>
        <item>
            <title><?= Html::encode($article->title) ?></title>
            <link><?= Url::to(['blog/view', 'slug' => $article->slug], true) ?></link>
            <guid isPermaLink="true"><?= Url::to(['blog/view', 'slug' => $article->slug], true) ?></guid>
            <pubDate><?= date(DATE_RSS, $article->published_at ?: $article->created_at) ?></pubDate>
            <?php if ($article->author): ?>
            <dc:creator xmlns:dc="http://purl.org/dc/elements/1.1/"><?= Html::encode($article->author->username) ?></dc:creator>
            <?php endif; ?>
            <description><![CDATA[<?= $article->excerpt ?: strip_tags($article->getRenderedHtml()) ?>]]></description>
            <content:encoded><![CDATA[<?= $article->getRenderedHtml() ?>]]></content:encoded>
        </item>
        <?php endforeach; ?>
    </channel>
</rss>
