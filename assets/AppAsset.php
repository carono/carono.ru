<?php

namespace app\assets;

use yii\bootstrap5\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        ['https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,400;8..60,500;8..60,600;8..60,700&display=swap', 'rel' => 'stylesheet'],
        'css/site.css',
    ];

    public $js = [
        'js/site.js',
    ];

    public $jsOptions = [
        'defer' => true,
    ];

    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}
