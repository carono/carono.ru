<?php
/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <h1 class="mb-4">Вход</h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'options' => ['class' => 'mb-3'],
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control form-control-lg'],
                'errorOptions' => ['class' => 'invalid-feedback d-block'],
            ],
        ]); ?>
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'autocomplete' => 'username']) ?>
            <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'current-password']) ?>
            <div class="form-check mb-4">
                <?= Html::activeCheckbox($model, 'rememberMe', ['class' => 'form-check-input']) ?>
                <?= Html::activeLabel($model, 'rememberMe', ['class' => 'form-check-label']) ?>
            </div>
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-lg w-100']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
