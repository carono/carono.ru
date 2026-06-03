<?php

use yii\db\Migration;

class m260603_120000_create_user_token_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(64)->notNull(),
            'expires_at' => $this->integer()->notNull(),
            'last_used_at' => $this->integer()->null(),
            'user_agent' => $this->string(255)->null(),
            'created_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('uq-user-token-token', '{{%user_token}}', 'token', true);
        $this->createIndex('idx-user-token-user-id', '{{%user_token}}', 'user_id');
        $this->createIndex('idx-user-token-expires-at', '{{%user_token}}', 'expires_at');

        $this->addForeignKey(
            'fk-user-token-user-id',
            '{{%user_token}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-user-token-user-id', '{{%user_token}}');
        $this->dropTable('{{%user_token}}');
    }
}
