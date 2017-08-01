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
    <title>Responsive Portfolio Template for Developers</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Website Landing Page for Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,300italic,400italic' rel='stylesheet'
          type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.css">

    <!-- github calendar css -->
    <link rel="stylesheet" href="/plugins/github-calendar/dist/github-calendar.css"
    />
    <!-- github acitivity css -->
    <link rel="stylesheet" href="/plugins/github-activity/src/github-activity.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css">

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="/css/styles.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- ******HEADER****** -->
<header class="header">
    <div class="container">
        <img class="profile-image img-responsive pull-left img-circle" src="/images/profile.png" alt="James Lee"/>
        <div class="profile-content pull-left">
            <h1 class="name">Александр Касьянов</h1>
            <h2 class="desc">Senior web-developer</h2>
            <ul class="social list-inline">
                <li><a href="https://vk.com/carno"><i class="fa fa-vk"></i></a></li>
                <li><a href="https://github.com/carono"><i class="fa fa-github-alt"></i></a></li>
            </ul>
        </div>
        <a class="btn btn-cta-primary pull-right" href="mailto:info@carono.ru" target="_blank">
            <i class="fa fa-paper-plane"></i> Contact Me
        </a>
    </div>
</header>

<?= $this->render('dummy') ?>

<!-- ******FOOTER****** -->
<footer class="footer">
    <div class="container text-center">
        <!--/* This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com */-->
        Shared by <i class="fa fa-love"></i><a href="https://bootstrapthemes.co">BootstrapThemes</a>

    </div><!--//container-->
</footer><!--//footer-->

<!-- Javascript -->
<script type="text/javascript" src="/plugins/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/plugins/jquery-rss/dist/jquery.rss.min.js"></script>
<!-- github calendar plugin -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/es6-promise/3.0.2/es6-promise.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fetch/0.10.1/fetch.min.js"></script>
<script type="text/javascript" src="/plugins/github-calendar/dist/github-calendar.min.js"></script>
<!-- github activity plugin -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js"></script>
<script type="text/javascript" src="/plugins/github-activity/src/github-activity.js"></script>
<!-- custom js -->
<script type="text/javascript" src="/js/main.js"></script>

<?= $this->render('metrika') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
