<?php

use yii\db\Migration;

class m260603_100000_create_user_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull(),
            'email' => $this->string(255)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'auth_key' => $this->string(64)->notNull(),
            'access_token' => $this->string(64)->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('uq-user-username', '{{%user}}', 'username', true);
        $this->createIndex('uq-user-email', '{{%user}}', 'email', true);
        $this->createIndex('idx-user-status', '{{%user}}', 'status');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%user}}');
    }
}
