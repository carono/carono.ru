<?php


class m170801_194358_init extends \carono\yii2installer\Migration
{
    public function newTables()
    {
        return [
            'article' => [
                'id' => self::primaryKey(),
                'title' => self::string(),
                'description' => self::text(),
                'content' => self::text(),
                'position' => self::integer()->notNull()->defaultValue(0),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime()
            ],
            'user' => [
                'id' => self::primaryKey(),
                'login' => self::string(),
                'hash' => self::string(),
                'created_at' => self::dateTime(),
                'updated_at' => self::dateTime()
            ]
        ];
    }

    public function safeUp()
    {
        $this->upNewTables();
    }

    public function safeDown()
    {
        $this->downNewTables();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170801_194358_init cannot be reverted.\n";

        return false;
    }
    */
}
