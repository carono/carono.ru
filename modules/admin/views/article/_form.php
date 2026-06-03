<?php
/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var array $categories */

use app\models\Article;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'options' => ['class' => 'mb-3'],
        'labelOptions' => ['class' => 'form-label'],
        'inputOptions' => ['class' => 'form-control'],
        'errorOptions' => ['class' => 'invalid-feedback d-block'],
    ],
]); ?>

<div class="row g-4">
    <div class="col-lg-8">
        <?= $form->field($model, 'title')->textInput(['autofocus' => true, 'maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['placeholder' => 'оставьте пустым — сгенерируется автоматически']) ?>
        <?= $form->field($model, 'excerpt')->textarea(['rows' => 3, 'placeholder' => 'Краткое описание для превью и SEO']) ?>
        <?= $form->field($model, 'content_md')->textarea(['rows' => 25, 'id' => 'content-md-editor']) ?>
    </div>

    <div class="col-lg-4">
        <div class="admin-sidecard mb-4">
            <h3 class="h6">Публикация</h3>
            <?= $form->field($model, 'status')->dropDownList([
                Article::STATUS_DRAFT => 'Черновик',
                Article::STATUS_PUBLISHED => 'Опубликовано',
            ]) ?>
            <div class="d-grid gap-2 mt-3">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                <?php if (!$model->isNewRecord && $model->isPublished()): ?>
                    <?= Html::a('Открыть на сайте →', $model->getUrl(true), ['class' => 'btn btn-outline-secondary', 'target' => '_blank', 'rel' => 'noopener']) ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="admin-sidecard mb-4">
            <h3 class="h6">Категории и теги</h3>
            <?= $form->field($model, 'categoryIds')->checkboxList($categories, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $checkedAttr = $checked ? ' checked' : '';
                    return '<div class="form-check"><input class="form-check-input" type="checkbox" name="' . $name . '" value="' . $value . '" id="cat-' . $value . '"' . $checkedAttr . '><label class="form-check-label" for="cat-' . $value . '">' . Html::encode($label) . '</label></div>';
                },
            ]) ?>
            <?= $form->field($model, 'tagsString')->textInput([
                'placeholder' => 'через запятую: php, yii, devops',
            ])->hint('Существующие теги будут переиспользованы, новые — созданы') ?>
        </div>

        <div class="admin-sidecard mb-4">
            <h3 class="h6">Обложка</h3>
            <?php if ($model->cover_path): ?>
                <img src="<?= Html::encode($model->getCoverUrl()) ?>" alt="" class="img-fluid mb-2 rounded">
            <?php endif; ?>
            <?= $form->field($model, 'coverFile')->fileInput(['accept' => 'image/*'])->label('Загрузить новую') ?>
        </div>

        <div class="admin-sidecard">
            <h3 class="h6">SEO</h3>
            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => $model->title ?: 'по умолчанию — заголовок']) ?>
            <?= $form->field($model, 'meta_description')->textarea(['rows' => 3]) ?>
            <?= $form->field($model, 'ogFile')->fileInput(['accept' => 'image/*'])->label('OG-картинка (опц.)') ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
