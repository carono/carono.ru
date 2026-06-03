<?php
/** @var app\models\Category $model */

use yii\helpers\Html;

$this->title = 'Редактирование · ' . $model->title;
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Редактирование категории</h1>
    <?= Html::a('← К списку', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>
<?= $this->render('_form', ['model' => $model]) ?>
