<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'carono-ru',
    'name' => 'carono.ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'admin' => [
            'class' => app\modules\admin\Module::class,
        ],
        'api' => [
            'class' => yii\base\Module::class,
            'modules' => [
                'v1' => app\modules\api\v1\Module::class,
            ],
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'o5Jo9ZM6NtCGJxrQidqU_n1SoZCcHR2t',
            'parsers' => [
                'application/json' => yii\web\JsonParser::class,
            ],
        ],
        'response' => [
            'charset' => 'UTF-8',
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => app\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '' => 'site/index',
                'blog' => 'blog/index',
                'blog/<slug:[a-z0-9\-]+>' => 'blog/view',
                'category/<slug:[a-z0-9\-]+>' => 'blog/category',
                'tag/<slug:[a-z0-9\-]+>' => 'blog/tag',
                'feed.xml' => 'blog/feed',
                'sitemap.xml' => 'blog/sitemap',
                'widgets/github-contributions' => 'widget/github-contributions',

                ['class' => yii\rest\UrlRule::class, 'controller' => 'api/v1/article', 'pluralize' => true, 'tokens' => ['{id}' => '<id:\d+>']],
                ['class' => yii\rest\UrlRule::class, 'controller' => 'api/v1/category', 'pluralize' => true, 'tokens' => ['{id}' => '<id:\d+>']],
                ['class' => yii\rest\UrlRule::class, 'controller' => 'api/v1/tag', 'pluralize' => true, 'tokens' => ['{id}' => '<id:\d+>']],
                'POST api/v1/articles/<id:\d+>/publish' => 'api/v1/article/publish',
                'POST api/v1/articles/<id:\d+>/unpublish' => 'api/v1/article/unpublish',
                'POST api/v1/articles/<id:\d+>/cover' => 'api/v1/article/cover',
                'POST api/v1/articles/<id:\d+>/og-image' => 'api/v1/article/og-image',
                'GET api/v1/articles/by-slug/<slug:[a-z0-9\-]+>' => 'api/v1/article/view-by-slug',
                'GET api/v1/categories/by-slug/<slug:[a-z0-9\-]+>' => 'api/v1/category/view-by-slug',
                'POST api/v1/auth/login' => 'api/v1/auth/login',
                'POST api/v1/auth/logout' => 'api/v1/auth/logout',
                'GET api/v1/auth/me' => 'api/v1/auth/me',

                'api' => 'docs/api',
                'api/docs' => 'docs/api',
                'api/openapi.yaml' => 'docs/openapi',

                'about' => 'site/about',
                'contact' => 'site/contact',
                'login' => 'site/login',
                'logout' => 'site/logout',
                '<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
            'dateFormat' => 'php:d.m.Y',
            'datetimeFormat' => 'php:d.m.Y H:i',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*', '10.*', '172.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*', '10.*', '172.*'],
    ];
}

return $config;
