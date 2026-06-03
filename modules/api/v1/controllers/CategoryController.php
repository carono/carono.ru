<?php

namespace app\modules\api\v1\controllers;

use app\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class CategoryController extends ApiController
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
        return new ActiveDataProvider([
            'query' => Category::find()->orderBy('title'),
            'pagination' => ['pageSize' => 100],
        ]);
    }

    public function actionView(int $id): Category
    {
        return $this->findModel($id);
    }

    public function actionViewBySlug(string $slug): Category
    {
        $model = Category::findOne(['slug' => $slug]);
        if ($model === null) {
            throw new NotFoundHttpException('Категория не найдена');
        }
        return $model;
    }

    public function actionCreate(): Category
    {
        $this->requirePermission('manageContent');
        $model = new Category();
        $model->setAttributes(Yii::$app->request->getBodyParams());
        if (!$model->save()) {
            Yii::$app->response->statusCode = 422;
            Yii::$app->response->data = ['errors' => $model->errors];
            Yii::$app->end();
        }
        Yii::$app->response->statusCode = 201;
        return $model;
    }

    public function actionUpdate(int $id): Category
    {
        $this->requirePermission('manageContent');
        $model = $this->findModel($id);
        $model->setAttributes(Yii::$app->request->getBodyParams());
        if (!$model->save()) {
            Yii::$app->response->statusCode = 422;
            Yii::$app->response->data = ['errors' => $model->errors];
            Yii::$app->end();
        }
        return $model;
    }

    public function actionDelete(int $id): array
    {
        $this->requirePermission('manageContent');
        $this->findModel($id)->delete();
        Yii::$app->response->statusCode = 204;
        return [];
    }

    private function findModel(int $id): Category
    {
        $model = Category::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Категория не найдена');
        }
        return $model;
    }
}
