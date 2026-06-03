<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Обо мне · ' . Yii::$app->params['siteName'];
?>
<section class="page-header">
    <h1>Обо мне</h1>
</section>

<div class="page-body">
    <p>
        Меня зовут <strong><?= Html::encode(Yii::$app->params['siteAuthor']) ?></strong>.
        Этот сайт — личный блог про разработку, инфраструктуру и сторонние проекты.
    </p>
    <p>
        Здесь будут заметки на темы, которые меня цепляют: PHP, Yii, Docker, Linux,
        автоматизация, базы данных, AI-инструменты и всё, что встречается по дороге.
    </p>
    <p>
        Найти меня:
        <?php if (!empty(Yii::$app->params['social']['github'])): ?>
            <a href="<?= Html::encode(Yii::$app->params['social']['github']) ?>" target="_blank" rel="noopener">GitHub</a>
        <?php endif; ?>
        ·
        <a href="<?= Url::to(['site/contact']) ?>">написать письмо</a>
        ·
        <a href="<?= Url::to(['blog/feed']) ?>">RSS</a>.
    </p>
</div>

<?= $this->render('_github-widget') ?>
