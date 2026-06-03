<?php

namespace app\modules\api\v1\controllers;

use app\models\User;
use app\models\UserToken;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;

class AuthController extends ApiController
{
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['POST'],
                    'logout' => ['POST'],
                    'me' => ['GET'],
                ],
            ],
        ]);
    }

    protected function getOptionalActions(): array
    {
        return ['login'];
    }

    public function actionLogin(): array
    {
        $payload = Yii::$app->request->getBodyParams();
        $username = (string)($payload['username'] ?? '');
        $password = (string)($payload['password'] ?? '');

        if ($username === '' || $password === '') {
            throw new UnauthorizedHttpException('Нужны username и password');
        }

        $user = User::findByUsername($username);
        if ($user === null || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Неверный логин или пароль');
        }

        $ttl = (int)($payload['ttl'] ?? UserToken::DEFAULT_TTL);
        $ttl = max(60, min($ttl, 30 * 86400));
        $token = UserToken::issue($user, $ttl, Yii::$app->request->userAgent);

        return [
            'token' => $token->token,
            'expires_at' => $token->expires_at,
            'user' => $user->toArray(),
        ];
    }

    public function actionLogout(): array
    {
        $token = $this->extractBearerToken();
        if ($token !== null) {
            UserToken::revokeByToken($token);
        }
        return ['ok' => true];
    }

    public function actionMe(): array
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        return [
            'user' => $user->toArray(),
            'permissions' => [
                'manageContent' => Yii::$app->user->can('manageContent'),
            ],
        ];
    }

    private function extractBearerToken(): ?string
    {
        $header = Yii::$app->request->headers->get('Authorization');
        if ($header && preg_match('/^Bearer\s+(.+)$/i', $header, $m)) {
            return trim($m[1]);
        }
        return null;
    }
}
