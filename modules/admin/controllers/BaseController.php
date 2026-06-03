<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => fn() => !Yii::$app->user->isGuest
                            && Yii::$app->user->can('manageContent'),
                    ],
                ],
                'denyCallback' => function () {
                    if (Yii::$app->user->isGuest) {
                        return Yii::$app->response->redirect(['/site/login']);
                    }
                    throw new \yii\web\ForbiddenHttpException('Доступ запрещён');
                },
            ],
        ];
    }
}
