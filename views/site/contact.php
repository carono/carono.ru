<?php
/** @var yii\web\View $this */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Контакты · ' . Yii::$app->params['siteName'];
?>
<section class="page-header">
    <h1>Контакты</h1>
</section>

<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
    <div class="alert alert-success">Спасибо! Сообщение отправлено, я отвечу при первой возможности.</div>
<?php else: ?>
    <div class="page-body">
        <p>Если есть что обсудить — заполните форму ниже или напишите на
            <a href="mailto:<?= Html::encode(Yii::$app->params['adminEmail']) ?>"><?= Html::encode(Yii::$app->params['adminEmail']) ?></a>.
        </p>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'fieldConfig' => [
            'options' => ['class' => 'mb-3'],
            'labelOptions' => ['class' => 'form-label'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'invalid-feedback d-block'],
        ],
    ]); ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'subject') ?>
        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
