<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Tag;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Теги';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Теги</h1>
    <?= Html::a('+ Новый тег', ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-hover align-middle'],
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => fn(Tag $t) => Html::a(Html::encode($t->title), ['update', 'id' => $t->id]),
        ],
        'slug',
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
            'contentOptions' => ['style' => 'width: 90px;'],
        ],
    ],
]) ?>
