<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $access_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 9;
    public const STATUS_ACTIVE = 10;

    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'password_hash', 'auth_key'], 'required'],
            [['username'], 'string', 'max' => 64],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['status'], 'integer'],
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    public static function findIdentity($id): ?self
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        if (empty($token)) {
            return null;
        }
        $row = UserToken::findOne(['token' => $token]);
        if ($row === null || $row->isExpired()) {
            return null;
        }
        $user = static::findOne(['id' => $row->user_id, 'status' => self::STATUS_ACTIVE]);
        if ($user === null) {
            return null;
        }
        $row->touch();
        return $user;
    }

    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function fields(): array
    {
        return [
            'id',
            'username',
            'email',
            'status',
            'created_at',
            'updated_at',
        ];
    }

    public function getId(): int
    {
        return (int)$this->getPrimaryKey();
    }

    public function getAuthKey(): string
    {
        return (string)$this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return hash_equals($this->getAuthKey(), (string)$authKey);
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
}
