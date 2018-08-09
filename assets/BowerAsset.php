<?php


namespace app\assets;


use carono\yii2bower\Asset;

class BowerAsset extends Asset
{
    public $packages = [
        'fontawesome' => [
            'sourcePath' => 'web-fonts-with-css',
            'css/fontawesome-all.min.css',
        ]
    ];
}