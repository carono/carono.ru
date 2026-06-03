<?php
/** @var yii\web\View $this */
/** @var int $articleCount */
/** @var int $publishedCount */
/** @var int $draftCount */
/** @var int $categoryCount */
/** @var int $tagCount */
/** @var app\models\Article[] $recentArticles */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Дашборд';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Дашборд</h1>
    <?= Html::a('+ Новая статья', ['/admin/article/create'], ['class' => 'btn btn-primary']) ?>
</div>

<div class="row g-3 mb-5">
    <div class="col-md-3"><div class="card-stat"><div class="card-stat-value"><?= $articleCount ?></div><div class="card-stat-label">Всего статей</div></div></div>
    <div class="col-md-3"><div class="card-stat"><div class="card-stat-value text-success"><?= $publishedCount ?></div><div class="card-stat-label">Опубликовано</div></div></div>
    <div class="col-md-3"><div class="card-stat"><div class="card-stat-value text-warning"><?= $draftCount ?></div><div class="card-stat-label">Черновиков</div></div></div>
    <div class="col-md-3"><div class="card-stat"><div class="card-stat-value"><?= $categoryCount ?> / <?= $tagCount ?></div><div class="card-stat-label">Категорий / тегов</div></div></div>
</div>

<h2 class="h4 mb-3">Последние правки</h2>
<?php if (empty($recentArticles)): ?>
    <p class="text-muted">Пока пусто.</p>
<?php else: ?>
    <div class="list-group">
        <?php foreach ($recentArticles as $a): ?>
            <a href="<?= Url::to(['/admin/article/update', 'id' => $a->id]) ?>" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between">
                    <strong><?= Html::encode($a->title) ?></strong>
                    <span class="badge <?= $a->status === \app\models\Article::STATUS_PUBLISHED ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $a->status === \app\models\Article::STATUS_PUBLISHED ? 'опубликовано' : 'черновик' ?>
                    </span>
                </div>
                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($a->updated_at) ?></small>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
