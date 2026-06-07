<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Встраиваемый виджет диалога с AI (пакет npm-asset/carono-ai-dialog-widget).
 *
 * Виджет монтируется в Shadow DOM, при запросе шлёт контекст страницы на шлюз
 * (data-gateway) под проектом data-project с авторизацией data-token.
 */
class AiDialogAsset extends AssetBundle
{
    public $sourcePath = '@vendor/npm-asset/carono-ai-dialog-widget';

    public $js = [
        [
            'widget.js',
            'data-project' => 'carono',
            'data-gateway' => 'wss://wss.carono.site',
            'data-token' => 'carono-test-secret',
        ],
    ];
}
