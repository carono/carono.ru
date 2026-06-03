<?php

namespace app\modules\api\v1;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'app\modules\api\v1\controllers';

    public function init(): void
    {
        parent::init();
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;
        Yii::$app->request->enableCsrfValidation = false;
    }
}
