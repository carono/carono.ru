<?php
/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AdminAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-bs-theme="light">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <link rel="icon" href="<?= Url::to('@web/favicon.ico') ?>">
    <?php $this->registerCsrfMetaTags() ?>
    <title>Админка · <?= Html::encode($this->title ?: 'carono.ru') ?></title>
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<aside class="admin-sidebar">
    <div class="admin-brand">
        <a href="<?= Url::to(['/admin']) ?>" class="text-decoration-none">
            <span class="brand-mark">/</span><span class="brand-name">carono</span>
            <small class="d-block text-muted">админка</small>
        </a>
    </div>
    <nav class="admin-nav">
        <a href="<?= Url::to(['/admin']) ?>" class="admin-nav-link">Дашборд</a>
        <a href="<?= Url::to(['/admin/article/index']) ?>" class="admin-nav-link">Статьи</a>
        <a href="<?= Url::to(['/admin/category/index']) ?>" class="admin-nav-link">Категории</a>
        <a href="<?= Url::to(['/admin/tag/index']) ?>" class="admin-nav-link">Теги</a>
    </nav>
    <div class="admin-sidebar-footer">
        <a href="<?= Url::to(['/']) ?>" target="_blank" rel="noopener" class="text-decoration-none">Открыть сайт →</a>
        <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'm-0 p-0 mt-2']) ?>
            <?= Html::submitButton('Выйти (' . Html::encode(Yii::$app->user->identity->username) . ')', ['class' => 'btn btn-link p-0']) ?>
        <?= Html::endForm() ?>
    </div>
</aside>

<main class="admin-main">
    <div class="admin-content">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <div class="alert alert-<?= $type === 'success' ? 'success' : ($type === 'error' ? 'danger' : 'info') ?> mb-3">
                <?= Html::encode($message) ?>
            </div>
        <?php endforeach; ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
