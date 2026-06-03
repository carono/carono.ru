<?php
/** @var app\models\Category $model */

use yii\helpers\Html;

$this->title = 'Новая категория';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Новая категория</h1>
    <?= Html::a('← К списку', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>
<?= $this->render('_form', ['model' => $model]) ?>
