<?php

use yii\db\Migration;

class m260603_100400_create_article_category_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%article_category}}', [
            'article_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'PRIMARY KEY(article_id, category_id)',
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('idx-article-category-category-id', '{{%article_category}}', 'category_id');

        $this->addForeignKey(
            'fk-article-category-article-id',
            '{{%article_category}}', 'article_id',
            '{{%article}}', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-article-category-category-id',
            '{{%article_category}}', 'category_id',
            '{{%category}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-article-category-article-id', '{{%article_category}}');
        $this->dropForeignKey('fk-article-category-category-id', '{{%article_category}}');
        $this->dropTable('{{%article_category}}');
    }
}
