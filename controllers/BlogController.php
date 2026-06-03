<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\Tag;
use Yii;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BlogController extends Controller
{
    public function actionIndex(): string
    {
        $provider = new ActiveDataProvider([
            'query' => Article::findPublished()->with(['categories', 'tags', 'author']),
            'pagination' => ['pageSize' => Yii::$app->params['articlesPerPage']],
        ]);

        return $this->render('index', [
            'dataProvider' => $provider,
            'pageTitle' => 'Все статьи',
        ]);
    }

    public function actionView(string $slug): string
    {
        $article = Article::find()
            ->where(['slug' => $slug])
            ->with(['author', 'categories', 'tags'])
            ->one();

        if ($article === null || (!$article->isPublished() && Yii::$app->user->isGuest)) {
            throw new NotFoundHttpException('Статья не найдена');
        }

        $article->incrementViewCount();

        return $this->render('view', ['article' => $article]);
    }

    public function actionCategory(string $slug): string
    {
        $category = Category::findOne(['slug' => $slug]);
        if ($category === null) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        $provider = new ActiveDataProvider([
            'query' => Article::findPublished()
                ->innerJoinWith('categories ac')
                ->andWhere(['ac.id' => $category->id])
                ->with(['categories', 'tags', 'author']),
            'pagination' => ['pageSize' => Yii::$app->params['articlesPerPage']],
        ]);

        return $this->render('index', [
            'dataProvider' => $provider,
            'pageTitle' => 'Категория: ' . $category->title,
            'pageDescription' => $category->description,
        ]);
    }

    public function actionTag(string $slug): string
    {
        $tag = Tag::findOne(['slug' => $slug]);
        if ($tag === null) {
            throw new NotFoundHttpException('Тег не найден');
        }

        $provider = new ActiveDataProvider([
            'query' => Article::findPublished()
                ->innerJoinWith('tags at')
                ->andWhere(['at.id' => $tag->id])
                ->with(['categories', 'tags', 'author']),
            'pagination' => ['pageSize' => Yii::$app->params['articlesPerPage']],
        ]);

        return $this->render('index', [
            'dataProvider' => $provider,
            'pageTitle' => 'Тег: ' . $tag->title,
        ]);
    }

    public function actionFeed(): Response
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/rss+xml; charset=utf-8');

        $xml = Yii::$app->cache->getOrSet('blog:feed', function () {
            return $this->renderPartial('feed', [
                'articles' => Article::findPublished()
                    ->with(['author'])
                    ->limit(Yii::$app->params['feedLimit'])
                    ->all(),
            ]);
        }, 3600);

        $response->content = $xml;
        return $response;
    }

    public function actionSitemap(): Response
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');

        $xml = Yii::$app->cache->getOrSet('blog:sitemap', function () {
            return $this->renderPartial('sitemap', [
                'articles' => Article::findPublished()->all(),
                'categories' => Category::find()->all(),
                'tags' => Tag::find()->all(),
            ]);
        }, 3600);

        $response->content = $xml;
        return $response;
    }
}
