<?php

namespace app\modules\admin\controllers;

use app\models\Article;
use app\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ArticleController extends BaseController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function actionIndex(): string
    {
        $statusFilter = Yii::$app->request->get('status');
        $query = Article::find()->with(['author', 'categories', 'tags']);
        if ($statusFilter !== null && in_array((int)$statusFilter, [Article::STATUS_DRAFT, Article::STATUS_PUBLISHED], true)) {
            $query->andWhere(['status' => (int)$statusFilter]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['updated_at' => SORT_DESC],
                'attributes' => ['title', 'status', 'published_at', 'updated_at', 'view_count'],
            ],
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function actionCreate(): Response|string
    {
        $model = new Article([
            'author_id' => Yii::$app->user->id,
            'status' => Article::STATUS_DRAFT,
        ]);
        return $this->renderForm($model, true);
    }

    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);
        $model->fillCategoryIds();
        $model->fillTagsString();
        return $this->renderForm($model, false);
    }

    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Статья удалена');
        return $this->redirect(['index']);
    }

    private function renderForm(Article $model, bool $isNew): Response|string
    {
        $request = Yii::$app->request;
        if ($model->load($request->post())) {
            $model->loadFormFields($request->post());
            $cover = UploadedFile::getInstance($model, 'coverFile');
            if ($cover) {
                $model->cover_path = $this->saveUpload($cover);
            }
            $og = UploadedFile::getInstance($model, 'ogFile');
            if ($og) {
                $model->og_image_path = $this->saveUpload($og);
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', $isNew ? 'Статья создана' : 'Статья обновлена');
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render($isNew ? 'create' : 'update', [
            'model' => $model,
            'categories' => ArrayHelper::map(Category::find()->orderBy('title')->all(), 'id', 'title'),
        ]);
    }

    private function saveUpload(UploadedFile $file): string
    {
        $sub = 'uploads/articles/' . date('Y/m');
        $dir = Yii::getAlias('@webroot/' . $sub);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $name = Yii::$app->security->generateRandomString(16) . '.' . $file->extension;
        $file->saveAs($dir . '/' . $name);
        return $sub . '/' . $name;
    }

    private function findModel(int $id): Article
    {
        $model = Article::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Статья не найдена');
        }
        return $model;
    }
}
