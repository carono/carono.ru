<?php
/** @var yii\web\View $this */
/** @var app\models\Article[] $articles */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->params['siteName'] . ' — ' . Yii::$app->params['siteTagline'];
$this->params['meta_description'] = Yii::$app->params['siteDescription'];
?>
<section class="hero">
    <h1>Привет. Я <?= Html::encode(Yii::$app->params['siteAuthor']) ?>.</h1>
    <p><?= Html::encode(Yii::$app->params['siteDescription']) ?></p>
</section>

<section>
    <h2 class="h4 mb-4 text-muted text-uppercase" style="letter-spacing: 0.06em; font-size: 0.8rem;">Последнее в блоге</h2>
    <?php if (empty($articles)): ?>
        <p class="text-muted">Пока пусто. Первая статья скоро появится.</p>
    <?php else: ?>
        <ul class="article-list">
            <?php foreach ($articles as $article): ?>
                <?= $this->render('//blog/_article-card', ['article' => $article]) ?>
            <?php endforeach; ?>
        </ul>
        <div class="mt-5 text-center">
            <a href="<?= Url::to(['blog/index']) ?>" class="btn btn-outline-secondary">Все статьи →</a>
        </div>
    <?php endif; ?>
</section>

<?= $this->render('_github-widget') ?>
