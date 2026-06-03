<?php
/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error-page text-center py-5">
    <h1 class="display-1 mb-3"><?= Html::encode($name) ?></h1>
    <p class="lead text-muted mb-4"><?= nl2br(Html::encode($message)) ?></p>
    <a href="<?= \yii\helpers\Url::home() ?>" class="btn btn-outline-secondary">На главную</a>
</div>
