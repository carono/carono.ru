<?php

namespace app\modules\admin;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $defaultRoute = 'default';

    public function init(): void
    {
        parent::init();
        $this->setViewPath('@app/modules/admin/views');
        $this->layout = '@app/modules/admin/views/layouts/main';
    }
}
