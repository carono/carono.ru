<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expires_at
 * @property int|null $last_used_at
 * @property string|null $user_agent
 * @property int $created_at
 * @property-read User $user
 */
class UserToken extends ActiveRecord
{
    public const DEFAULT_TTL = 86400;

    public static function tableName(): string
    {
        return '{{%user_token}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function issue(User $user, int $ttl = self::DEFAULT_TTL, ?string $userAgent = null): self
    {
        $token = new self([
            'user_id' => $user->id,
            'token' => Yii::$app->security->generateRandomString(48),
            'expires_at' => time() + $ttl,
            'created_at' => time(),
            'user_agent' => $userAgent !== null ? mb_substr($userAgent, 0, 255) : null,
        ]);
        $token->save(false);
        return $token;
    }

    public function isExpired(): bool
    {
        return $this->expires_at <= time();
    }

    public function touch(): void
    {
        $this->updateAttributes(['last_used_at' => time()]);
    }

    public static function revokeByToken(string $token): int
    {
        return (int)self::deleteAll(['token' => $token]);
    }

    public static function purgeExpired(): int
    {
        return (int)self::deleteAll(['<=', 'expires_at', time()]);
    }
}
