<?php

use yii\db\Migration;

class m260603_100100_create_category_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(160)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

        $this->createIndex('uq-category-slug', '{{%category}}', 'slug', true);
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%category}}');
    }
}
