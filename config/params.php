<?php

$local = is_file(__DIR__ . '/params-local.php') ? require __DIR__ . '/params-local.php' : [];

return array_merge([
    'siteName' => 'carono.ru',
    'siteTagline' => 'личный сайт и блог',
    'siteDescription' => 'Блог разработчика про PHP, Yii, инфраструктуру и личные проекты.',
    'siteAuthor' => 'Каронов Андрей',
    'siteUrl' => 'https://carono.ru',
    'adminEmail' => 'admin@carono.ru',
    'noReplyEmail' => 'noreply@carono.ru',
    'articlesPerPage' => 10,
    'feedLimit' => 30,
    'social' => [
        'github' => 'https://github.com/carono',
        'telegram' => '',
    ],
], $local);
