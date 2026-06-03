<?php
/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var array $categories */

use yii\helpers\Html;

$this->title = 'Редактирование · ' . $model->title;
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Редактирование</h1>
    <?= Html::a('← К списку', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>
<?= $this->render('_form', ['model' => $model, 'categories' => $categories]) ?>
