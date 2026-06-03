<?php

use yii\db\Migration;

class m260603_100200_create_tag_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(160)->notNull(),
            'title' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('uq-tag-slug', '{{%tag}}', 'slug', true);
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%tag}}');
    }
}
