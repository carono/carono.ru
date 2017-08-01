<?php

use yii\helpers\Html;

/**
 * @var string $content
 * @var \yii\web\View $this
 */

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Сайт в разработке">
    <meta name="robots" content="none"/>
    <title>Сайт в разработке</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">

    <!-- siimple style -->
    <link href="/css/style.css" rel="stylesheet">
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Сайт в разработке</h1>
                <h2 class="subtitle">Тут будет моя домашняя страница</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">Но это не точно</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1><a href="mailto:info@carono.ru">info@carono.ru</a></h1>
            </div>
        </div>
    </div>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter45487056 = new Ya.Metrika({
                    id: 45487056,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/45487056" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
