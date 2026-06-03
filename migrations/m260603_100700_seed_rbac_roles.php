<?php

use yii\db\Migration;

class m260603_100700_seed_rbac_roles extends Migration
{
    public function safeUp(): void
    {
        $auth = Yii::$app->authManager;

        $manageContent = $auth->createPermission('manageContent');
        $manageContent->description = 'Управление статьями, категориями и тегами';
        $auth->add($manageContent);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $manageContent);
    }

    public function safeDown(): void
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole('admin');
        $manageContent = $auth->getPermission('manageContent');

        if ($admin !== null) {
            $auth->remove($admin);
        }
        if ($manageContent !== null) {
            $auth->remove($manageContent);
        }
    }
}
