<?php
/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$githubUrl = Yii::$app->params['social']['github'] ?? '';
if (!$githubUrl) {
    return;
}
$username = preg_match('~github\.com/([^/]+)~', $githubUrl, $m) ? $m[1] : null;
if (!$username) {
    return;
}
?>
<section class="github-widget">
    <div class="github-widget-head">
        <h2>Активность на GitHub</h2>
        <a href="<?= Html::encode($githubUrl) ?>" target="_blank" rel="noopener" class="github-widget-link">
            @<?= Html::encode($username) ?> →
        </a>
    </div>
    <a href="<?= Html::encode($githubUrl) ?>" target="_blank" rel="noopener" class="github-widget-chart" aria-label="Контрибуты <?= Html::encode($username) ?> на GitHub">
        <img src="<?= Url::to(['widget/github-contributions']) ?>"
             alt="Контрибуты <?= Html::encode($username) ?> за последний год"
             loading="lazy"
             width="800" height="100">
    </a>
</section>
