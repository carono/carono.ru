<?php

namespace app\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css',
        'css/admin.css',
    ];

    public $js = [
        'https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js',
        'js/admin.js',
    ];

    public $jsOptions = [
        'defer' => true,
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}
