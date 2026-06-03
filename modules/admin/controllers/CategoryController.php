<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CategoryController extends BaseController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST']],
            ],
        ]);
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Category::find()->orderBy('title'),
                'pagination' => ['pageSize' => 50],
            ]),
        ]);
    }

    public function actionCreate(): Response|string
    {
        return $this->renderForm(new Category(), true);
    }

    public function actionUpdate(int $id): Response|string
    {
        return $this->renderForm($this->findModel($id), false);
    }

    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Категория удалена');
        return $this->redirect(['index']);
    }

    private function renderForm(Category $model, bool $isNew): Response|string
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', $isNew ? 'Категория создана' : 'Категория обновлена');
            return $this->redirect(['index']);
        }
        return $this->render($isNew ? 'create' : 'update', ['model' => $model]);
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
