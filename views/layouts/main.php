<?php

use yii\helpers\Html;
use app\assets\AppAsset;
/**
 * @var string $content
 * @var \yii\web\View $this
 */
AppAsset::register($this);
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
                    <li><a href="https://vk.com/carno"><i class="fab fa-vk"></i></a></li>
                    <li><a href="https://github.com/carono"><i class="fab fa-github"></i></a></li>
                    <li><a href="https://t.me/Carno59"><i class="fab fa-telegram-plane"></i></a></li>
                </ul>
            </div>
        </div>
    </header>

    <?php $this->render('dummy') ?>

    <?= $content ?>

    <footer class="footer">
        <div class="container text-center"></div>
    </footer>

    <?= $this->render('metrika') ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>