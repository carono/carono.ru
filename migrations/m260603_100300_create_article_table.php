<?php

use yii\db\Migration;

class m260603_100300_create_article_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%article}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(160)->notNull(),
            'title' => $this->string(255)->notNull(),
            'excerpt' => $this->text()->null(),
            'content_md' => 'MEDIUMTEXT NOT NULL',
            'cover_path' => $this->string(255)->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'published_at' => $this->integer()->null(),
            'meta_title' => $this->string(255)->null(),
            'meta_description' => $this->string(500)->null(),
            'og_image_path' => $this->string(255)->null(),
            'author_id' => $this->integer()->notNull(),
            'view_count' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('uq-article-slug', '{{%article}}', 'slug', true);
        $this->createIndex('idx-article-status', '{{%article}}', 'status');
        $this->createIndex('idx-article-published-at', '{{%article}}', 'published_at');
        $this->createIndex('idx-article-author-id', '{{%article}}', 'author_id');

        $this->addForeignKey(
            'fk-article-author-id',
            '{{%article}}', 'author_id',
            '{{%user}}', 'id',
            'RESTRICT', 'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-article-author-id', '{{%article}}');
        $this->dropTable('{{%article}}');
    }
}
