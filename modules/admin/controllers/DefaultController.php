<?php

namespace app\modules\admin\controllers;

use app\models\Article;
use app\models\Category;
use app\models\Tag;

class DefaultController extends BaseController
{
    public function actionIndex(): string
    {
        return $this->render('index', [
            'articleCount' => Article::find()->count(),
            'publishedCount' => Article::find()->where(['status' => Article::STATUS_PUBLISHED])->count(),
            'draftCount' => Article::find()->where(['status' => Article::STATUS_DRAFT])->count(),
            'categoryCount' => Category::find()->count(),
            'tagCount' => Tag::find()->count(),
            'recentArticles' => Article::find()->orderBy(['updated_at' => SORT_DESC])->limit(5)->all(),
        ]);
    }
}
