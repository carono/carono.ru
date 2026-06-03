<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class DocsController extends Controller
{
    public $layout = false;

    public function actionApi(): string
    {
        $specUrl = Yii::$app->urlManager->createUrl(['docs/openapi']);

        return <<<HTML
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>carono.ru — API Reference</title>
    <link rel="icon" href="/favicon.ico">
    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        body { font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body>
    <script
        id="api-reference"
        data-url="{$specUrl}"
        data-configuration='{"theme":"default","layout":"modern","hideDownloadButton":false,"customCss":""}'></script>
    <script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference"></script>
</body>
</html>
HTML;
    }

    public function actionOpenapi(): Response
    {
        $path = Yii::getAlias('@app/data/openapi.yaml');
        if (!is_file($path)) {
            throw new \yii\web\NotFoundHttpException();
        }

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'application/yaml; charset=utf-8');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Cache-Control', 'public, max-age=300');
        $response->content = file_get_contents($path);
        return $response;
    }
}
