<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\models\Category;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Категории';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Категории</h1>
    <?= Html::a('+ Новая категория', ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-hover align-middle'],
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => fn(Category $c) => Html::a(Html::encode($c->title), ['update', 'id' => $c->id]),
        ],
        'slug',
        [
            'class' => ActionColumn::class,
            'template' => '{update} {delete}',
            'contentOptions' => ['style' => 'width: 90px;'],
        ],
    ],
]) ?>
