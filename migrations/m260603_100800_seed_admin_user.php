<?php

use yii\db\Migration;

class m260603_100800_seed_admin_user extends Migration
{
    public function safeUp(): void
    {
        $username = getenv('ADMIN_USERNAME') ?: 'admin';
        $email = getenv('ADMIN_EMAIL') ?: 'admin@carono.ru';
        $password = getenv('ADMIN_PASSWORD') ?: 'admin';

        $now = time();
        $security = Yii::$app->security;

        $this->insert('{{%user}}', [
            'username' => $username,
            'email' => $email,
            'password_hash' => $security->generatePasswordHash($password),
            'auth_key' => $security->generateRandomString(),
            'access_token' => null,
            'status' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $userId = (int)$this->db->getLastInsertID();

        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $auth->assign($admin, $userId);

        echo "    > seeded admin user: {$username} / {$password} (id={$userId})\n";
    }

    public function safeDown(): void
    {
        $username = getenv('ADMIN_USERNAME') ?: 'admin';
        $row = (new \yii\db\Query())->from('{{%user}}')->where(['username' => $username])->one();
        if (!$row) {
            return;
        }
        Yii::$app->authManager->revokeAll((int)$row['id']);
        $this->delete('{{%user}}', ['id' => $row['id']]);
    }
}
