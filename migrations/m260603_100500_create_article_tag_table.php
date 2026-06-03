<?php

use yii\db\Migration;

class m260603_100500_create_article_tag_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%article_tag}}', [
            'article_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'PRIMARY KEY(article_id, tag_id)',
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('idx-article-tag-tag-id', '{{%article_tag}}', 'tag_id');

        $this->addForeignKey(
            'fk-article-tag-article-id',
            '{{%article_tag}}', 'article_id',
            '{{%article}}', 'id',
            'CASCADE', 'CASCADE'
        );

        $this->addForeignKey(
            'fk-article-tag-tag-id',
            '{{%article_tag}}', 'tag_id',
            '{{%tag}}', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function safeDown(): void
    {
        $this->dropForeignKey('fk-article-tag-article-id', '{{%article_tag}}');
        $this->dropForeignKey('fk-article-tag-tag-id', '{{%article_tag}}');
        $this->dropTable('{{%article_tag}}');
    }
}
