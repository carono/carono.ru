<?php
/** @var app\models\Tag $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => ['class' => 'mb-3'],
        'labelOptions' => ['class' => 'form-label'],
        'inputOptions' => ['class' => 'form-control'],
        'errorOptions' => ['class' => 'invalid-feedback d-block'],
    ],
]); ?>
    <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
    <?= $form->field($model, 'slug')->textInput(['placeholder' => 'оставьте пустым — сгенерируется автоматически']) ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
