<?php

namespace app\modules\api\v1\controllers;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

abstract class ApiController extends Controller
{
    public bool $optionalAuth = false;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Authorization', 'Content-Type'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Max-Age' => 3600,
            ],
        ];

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'optional' => $this->optionalAuth ? ['*'] : $this->getOptionalActions(),
        ];

        return $behaviors;
    }

    /**
     * Action IDs где аутентификация необязательна (всё работает и без токена).
     * Если возвращается ['*'] — всё открытое.
     */
    protected function getOptionalActions(): array
    {
        return [];
    }

    protected function requirePermission(string $permission): void
    {
        if (Yii::$app->user->isGuest) {
            throw new \yii\web\UnauthorizedHttpException('Требуется авторизация');
        }
        if (!Yii::$app->user->can($permission)) {
            throw new ForbiddenHttpException('Недостаточно прав');
        }
    }
}
