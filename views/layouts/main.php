<?php
/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if (!empty($this->params['meta_description'])): ?>
        <meta name="description" content="<?= Html::encode($this->params['meta_description']) ?>">
    <?php endif; ?>
    <?php if (!empty($this->params['canonical'])): ?>
        <link rel="canonical" href="<?= Html::encode($this->params['canonical']) ?>">
    <?php endif; ?>
    <?php if (!empty($this->params['og'])): ?>
        <?php foreach ($this->params['og'] as $prop => $val): ?>
            <meta property="<?= Html::encode($prop) ?>" content="<?= Html::encode($val) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="icon" href="<?= Url::to('@web/favicon.ico') ?>">
    <link rel="alternate" type="application/rss+xml" title="<?= Html::encode(Yii::$app->params['siteName']) ?>" href="<?= Url::to(['blog/feed'], true) ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title ?: Yii::$app->params['siteName']) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>
<header class="site-header">
    <div class="site-container d-flex align-items-center justify-content-between py-4">
        <a href="<?= Url::home() ?>" class="site-brand text-decoration-none">
            <span class="brand-mark">/</span><span class="brand-name">carono</span>
        </a>
        <nav class="site-nav d-flex align-items-center gap-4">
            <a href="<?= Url::to(['blog/index']) ?>" class="text-decoration-none">Блог</a>
            <a href="<?= Url::to(['site/about']) ?>" class="text-decoration-none">Обо мне</a>
            <a href="<?= Url::to(['site/contact']) ?>" class="text-decoration-none">Контакты</a>
            <button type="button" class="theme-toggle btn btn-sm" aria-label="Переключить тему" data-theme-toggle>
                <span class="theme-icon-light" aria-hidden="true">☼</span>
                <span class="theme-icon-dark" aria-hidden="true">☾</span>
            </button>
            <?php if (!Yii::$app->user->isGuest): ?>
                <a href="<?= Url::to(['/admin']) ?>" class="text-decoration-none">Админка</a>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'm-0 p-0 d-inline']) ?>
                    <?= Html::submitButton('Выйти', ['class' => 'btn btn-link p-0 align-baseline']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="site-main flex-grow-1 py-5">
    <div class="site-container">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <div class="alert alert-<?= $type === 'success' ? 'success' : ($type === 'error' ? 'danger' : 'info') ?> mb-4">
                <?= Html::encode($message) ?>
            </div>
        <?php endforeach; ?>
        <?= $content ?>
    </div>
</main>

<footer class="site-footer py-5 mt-auto">
    <div class="site-container d-flex flex-wrap justify-content-between gap-3">
        <div class="text-muted">© <?= date('Y') ?> <?= Html::encode(Yii::$app->params['siteAuthor']) ?></div>
        <div class="d-flex gap-3">
            <?php if (!empty(Yii::$app->params['social']['github'])): ?>
                <a href="<?= Html::encode(Yii::$app->params['social']['github']) ?>" rel="noopener" target="_blank" class="text-decoration-none">GitHub</a>
            <?php endif; ?>
            <a href="<?= Url::to(['blog/feed']) ?>" class="text-decoration-none">RSS</a>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
