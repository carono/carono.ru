<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $pageTitle */
/** @var string|null $pageDescription */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = $pageTitle;
if (!empty($pageDescription)) {
    $this->params['meta_description'] = $pageDescription;
}
?>
<section class="page-header">
    <h1><?= Html::encode($pageTitle) ?></h1>
    <?php if (!empty($pageDescription)): ?>
        <p class="text-muted mt-2 mb-0"><?= Html::encode($pageDescription) ?></p>
    <?php endif; ?>
</section>

<?php $models = $dataProvider->getModels(); ?>
<?php if (empty($models)): ?>
    <p class="text-muted">Здесь пока ничего нет.</p>
<?php else: ?>
    <ul class="article-list">
        <?php foreach ($models as $article): ?>
            <?= $this->render('_article-card', ['article' => $article]) ?>
        <?php endforeach; ?>
    </ul>

    <?php if ($dataProvider->pagination->pageCount > 1): ?>
        <div class="pagination-wrap d-flex justify-content-center">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => 'pagination'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'disabledListItemSubTagOptions' => ['class' => 'page-link', 'tag' => 'span'],
            ]) ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
