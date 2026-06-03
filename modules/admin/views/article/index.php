<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string|null $statusFilter */

use app\models\Article;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Статьи';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Статьи</h1>
    <?= Html::a('+ Новая статья', ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<div class="btn-group mb-3" role="group">
    <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary <?= $statusFilter === null ? 'active' : '' ?>">Все</a>
    <a href="<?= Url::to(['index', 'status' => Article::STATUS_PUBLISHED]) ?>" class="btn btn-outline-secondary <?= (string)$statusFilter === (string)Article::STATUS_PUBLISHED ? 'active' : '' ?>">Опубликованные</a>
    <a href="<?= Url::to(['index', 'status' => Article::STATUS_DRAFT]) ?>" class="btn btn-outline-secondary <?= (string)$statusFilter === (string)Article::STATUS_DRAFT ? 'active' : '' ?>">Черновики</a>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-hover align-middle'],
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => fn(Article $a) => Html::a(Html::encode($a->title), ['update', 'id' => $a->id]),
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => fn(Article $a) => $a->status === Article::STATUS_PUBLISHED
                ? '<span class="badge bg-success">опубликовано</span>'
                : '<span class="badge bg-secondary">черновик</span>',
            'contentOptions' => ['style' => 'width: 130px'],
        ],
        [
            'attribute' => 'published_at',
            'format' => 'datetime',
            'value' => fn(Article $a) => $a->published_at,
            'contentOptions' => ['style' => 'width: 150px'],
        ],
        [
            'attribute' => 'view_count',
            'label' => 'Просм.',
            'contentOptions' => ['style' => 'width: 80px; text-align: right;'],
        ],
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
            'contentOptions' => ['style' => 'width: 90px;'],
        ],
    ],
]) ?>
