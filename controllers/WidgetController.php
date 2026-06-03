<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class WidgetController extends Controller
{
    public function actionGithubContributions(string $theme = 'light'): Response
    {
        $username = $this->getGithubUsername();
        if ($username === null) {
            throw new \yii\web\NotFoundHttpException();
        }

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'image/svg+xml; charset=utf-8');
        $response->headers->set('Cache-Control', 'public, max-age=3600');

        $cacheKey = 'widget:gh:contrib:' . $username . ':' . $theme;
        $svg = Yii::$app->cache->get($cacheKey);
        if ($svg === false) {
            $color = $theme === 'dark' ? '4d9aff' : '1a73e8';
            $url = "https://ghchart.rshah.org/{$color}/{$username}";
            $ctx = stream_context_create(['http' => [
                'timeout' => 10,
                'user_agent' => 'carono.ru-widget',
                'ignore_errors' => true,
            ]]);
            $body = @file_get_contents($url, false, $ctx);
            if ($body !== false && str_contains($body, '<svg')) {
                $svg = $body;
                Yii::$app->cache->set($cacheKey, $svg, 3600);
            } else {
                $svg = $this->fallbackSvg();
                Yii::$app->cache->set($cacheKey, $svg, 60);
            }
        }

        $response->content = $svg;
        return $response;
    }

    private function fallbackSvg(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 100">
            <rect width="100%" height="100%" fill="#fafafa"/>
            <text x="50%" y="55" text-anchor="middle" fill="#8a8f95" font-family="sans-serif" font-size="14">GitHub-виджет временно недоступен</text>
        </svg>';
    }

    private function getGithubUsername(): ?string
    {
        $url = Yii::$app->params['social']['github'] ?? '';
        if (!$url) {
            return null;
        }
        if (preg_match('~github\.com/([^/]+)~', $url, $m)) {
            return $m[1];
        }
        return null;
    }
}
