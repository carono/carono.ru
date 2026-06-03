<?php

namespace app\modules\api\v1\controllers;

use app\models\Article;
use app\models\Category;
use app\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class ArticleController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET', 'HEAD'],
                    'view' => ['GET', 'HEAD'],
                    'view-by-slug' => ['GET', 'HEAD'],
                    'create' => ['POST'],
                    'update' => ['PUT', 'PATCH'],
                    'delete' => ['DELETE'],
                    'publish' => ['POST'],
                    'unpublish' => ['POST'],
                    'cover' => ['POST'],
                    'og-image' => ['POST'],
                ],
            ],
        ]);
    }

    protected function getOptionalActions(): array
    {
        return ['index', 'view', 'view-by-slug'];
    }

    public function actionIndex(): ActiveDataProvider
    {
        $request = Yii::$app->request;
        $query = Article::find()->with(['author', 'categories', 'tags']);

        $isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->can('manageContent');
        if (!$isAdmin) {
            $query->andWhere(['status' => Article::STATUS_PUBLISHED])
                ->andWhere(['<=', 'published_at', time()]);
        } elseif (($status = $request->get('status')) !== null && $status !== '') {
            $query->andWhere(['status' => (int)$status]);
        }

        if ($categorySlug = $request->get('category')) {
            $cat = Category::findOne(['slug' => $categorySlug]);
            $query->innerJoinWith('categories ac')->andWhere(['ac.id' => $cat?->id ?? 0]);
        }
        if ($tagSlug = $request->get('tag')) {
            $tag = Tag::findOne(['slug' => $tagSlug]);
            $query->innerJoinWith('tags at')->andWhere(['at.id' => $tag?->id ?? 0]);
        }
        if ($search = $request->get('q')) {
            $like = '%' . trim($search) . '%';
            $query->andWhere(['or', ['like', 'title', $like, false], ['like', 'excerpt', $like, false]]);
        }

        $sort = $request->get('sort', '-published_at');
        $allowedSort = ['published_at', '-published_at', 'created_at', '-created_at', 'view_count', '-view_count'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = '-published_at';
        }
        $field = ltrim($sort, '-');
        $direction = str_starts_with($sort, '-') ? SORT_DESC : SORT_ASC;
        $query->orderBy([$field => $direction]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => min(50, max(1, (int)$request->get('per-page', 20))),
                'defaultPageSize' => 20,
            ],
            'sort' => false,
        ]);
    }

    public function actionView(int $id): Article
    {
        $article = $this->findModel($id);
        $this->guardVisibility($article);
        return $article;
    }

    public function actionViewBySlug(string $slug): Article
    {
        $article = Article::findOne(['slug' => $slug]);
        if ($article === null) {
            throw new NotFoundHttpException('Статья не найдена');
        }
        $this->guardVisibility($article);
        return $article;
    }

    public function actionCreate(): Article
    {
        $this->requirePermission('manageContent');
        $payload = Yii::$app->request->getBodyParams();

        $article = new Article([
            'author_id' => Yii::$app->user->id,
            'status' => Article::STATUS_DRAFT,
        ]);
        $article->setAttributes($this->writableAttributes($payload));
        if (isset($payload['categoryIds'])) {
            $article->categoryIds = array_map('intval', (array)$payload['categoryIds']);
        }
        if (isset($payload['tags'])) {
            $article->tagsString = is_array($payload['tags']) ? implode(',', $payload['tags']) : (string)$payload['tags'];
        }
        if (!$article->save()) {
            return $this->validationError($article);
        }
        Yii::$app->response->statusCode = 201;
        return $article;
    }

    public function actionUpdate(int $id): Article
    {
        $this->requirePermission('manageContent');
        $article = $this->findModel($id);
        $payload = Yii::$app->request->getBodyParams();

        $article->setAttributes($this->writableAttributes($payload));
        if (array_key_exists('categoryIds', $payload)) {
            $article->categoryIds = array_map('intval', (array)$payload['categoryIds']);
        }
        if (array_key_exists('tags', $payload)) {
            $article->tagsString = is_array($payload['tags']) ? implode(',', $payload['tags']) : (string)$payload['tags'];
        }
        if (!$article->save()) {
            return $this->validationError($article);
        }
        return $article;
    }

    public function actionDelete(int $id): array
    {
        $this->requirePermission('manageContent');
        $this->findModel($id)->delete();
        Yii::$app->response->statusCode = 204;
        return [];
    }

    public function actionPublish(int $id): Article
    {
        $this->requirePermission('manageContent');
        $article = $this->findModel($id);
        $article->status = Article::STATUS_PUBLISHED;
        if (!$article->save(false, ['status', 'published_at', 'updated_at'])) {
            throw new ServerErrorHttpException('Не удалось опубликовать');
        }
        return $article;
    }

    public function actionUnpublish(int $id): Article
    {
        $this->requirePermission('manageContent');
        $article = $this->findModel($id);
        $article->status = Article::STATUS_DRAFT;
        $article->save(false, ['status', 'published_at', 'updated_at']);
        return $article;
    }

    public function actionCover(int $id): Article
    {
        return $this->handleUpload($id, 'cover_path');
    }

    public function actionOgImage(int $id): Article
    {
        return $this->handleUpload($id, 'og_image_path');
    }

    private function handleUpload(int $id, string $field): Article
    {
        $this->requirePermission('manageContent');
        $article = $this->findModel($id);
        $file = UploadedFile::getInstanceByName('file');
        if ($file === null) {
            throw new \yii\web\BadRequestHttpException('Ожидается файл в поле "file"');
        }
        if (!in_array(strtolower($file->extension), ['png', 'jpg', 'jpeg', 'webp'], true)) {
            throw new \yii\web\BadRequestHttpException('Поддерживаются png, jpg, jpeg, webp');
        }

        $sub = 'uploads/articles/' . date('Y/m');
        $dir = Yii::getAlias('@webroot/' . $sub);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $name = Yii::$app->security->generateRandomString(16) . '.' . $file->extension;
        $file->saveAs($dir . '/' . $name);

        $article->$field = $sub . '/' . $name;
        $article->save(false, [$field, 'updated_at']);
        return $article;
    }

    private function findModel(int $id): Article
    {
        $model = Article::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Статья не найдена');
        }
        return $model;
    }

    private function guardVisibility(Article $article): void
    {
        if (!$article->isPublished()) {
            if (Yii::$app->user->isGuest || !Yii::$app->user->can('manageContent')) {
                throw new NotFoundHttpException('Статья не найдена');
            }
        }
    }

    private function writableAttributes(array $payload): array
    {
        $allowed = ['title', 'slug', 'excerpt', 'content_md', 'status', 'meta_title', 'meta_description', 'published_at'];
        return array_intersect_key($payload, array_flip($allowed));
    }

    /** @return Article */
    private function validationError(Article $model): Article
    {
        Yii::$app->response->statusCode = 422;
        Yii::$app->response->data = [
            'name' => 'Validation error',
            'message' => 'Проверьте поля',
            'errors' => $model->errors,
        ];
        Yii::$app->end();
    }
}
