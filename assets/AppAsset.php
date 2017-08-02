<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic',
        '//fonts.googleapis.com/css?family=Montserrat:400,700',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/font-awesome/css/font-awesome.css',
        'plugins/github-calendar/dist/github-calendar.css',
        'plugins/github-activity/src/github-activity.css',
        '//cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css',
        'css/styles.css',
    ];
    public $js = [
        "plugins/bootstrap/js/bootstrap.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/es6-promise/3.0.2/es6-promise.min.js",
        "plugins/jquery-rss/dist/jquery.rss.min.js",
        "plugins/github-calendar/dist/github-calendar.min.js",
        "plugins/github-activity/src/github-activity.js",
        "js/main.js",
        "//cdnjs.cloudflare.com/ajax/libs/fetch/0.10.1/fetch.min.js",
        "//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
