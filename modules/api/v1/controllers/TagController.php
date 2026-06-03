<?php

namespace app\modules\api\v1\controllers;

use app\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class TagController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET', 'HEAD'],
                    'view' => ['GET', 'HEAD'],
                    'create' => ['POST'],
                    'update' => ['PUT', 'PATCH'],
                    'delete' => ['DELETE'],
                ],
            ],
        ]);
    }

    protected function getOptionalActions(): array
    {
        return ['index', 'view'];
    }

    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Tag::find()->orderBy('title'),
            'pagination' => ['pageSize' => 200],
        ]);
    }

    public function actionView(int $id): Tag
    {
        return $this->findModel($id);
    }

    public function actionCreate(): Tag
    {
        $this->requirePermission('manageContent');
        $model = new Tag();
        $model->setAttributes(Yii::$app->request->getBodyParams());
        if (!$model->save()) {
            Yii::$app->response->statusCode = 422;
            Yii::$app->response->data = ['errors' => $model->errors];
            Yii::$app->end();
        }
        Yii::$app->response->statusCode = 201;
        return $model;
    }

    public function actionUpdate(int $id): Tag
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

    private function findModel(int $id): Tag
    {
        $model = Tag::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Тег не найден');
        }
        return $model;
    }
}
