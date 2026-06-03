<?php
/** @var app\models\Tag $model */

use yii\helpers\Html;

$this->title = 'Редактирование · ' . $model->title;
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 mb-0">Редактирование тега</h1>
    <?= Html::a('← К списку', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
</div>
<?= $this->render('_form', ['model' => $model]) ?>
