<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\assets\MainPageAsset;
use app\widgets\SelectWidget;
use yii\web\JsExpression;

MainPageAsset::register($this);
//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="date=no">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="email=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->head() ?>
    <title>Project Title</title>
</head>
<body>
<?php $this->beginBody() ?>

<header class="header" id="home">
    <span class="bg-half-l"></span>
    <div class="container bg-half-cont header-row">
        <div class="col-12 col-md-8 col-lg-7 col-xl-6 header-col">
            <!--
            <div class="logo">
                <span class="logo-num">417</span>
                <span class="logo-txt">СОВРЕМЕННЫЙ&nbsp;СТАНДАРТ<br>ЗАКАЗНЫХ&nbsp;ПЕРЕВОЗОК</span>
            </div>
            -->
            <div class="logo-imgw">
                <div class="row">
                    <div class="col">
                        <img class="logo-img" width="300" src="images/main_page/logo.svg">
                    </div><!-- /.col -->
                    <div class="col-auto align-self-center d-sm-none">
                        <a  class="nav-toggle js-nav-toggle mb-20px" href="#nav-1">
                            <i class="icon-bars"></i>
                        </a>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <div class="nav-mobw" id="nav-1">
                <div class="row mb-15px">
                    <div class="col-auto ml-auto">
                        <a  class="nav-toggle js-nav-toggle" href="#nav-1">
                            <i class="icon-times"></i>
                        </a>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <nav class="nav-mob">
                    <a class="nav-ln js-scroll" href="#home">НОВЫЙ ЗАКАЗ</a>
                    <a class="nav-ln js-scroll" href="#block-1">УСЛОВИЯ</a>
                    <a class="nav-ln js-scroll" href="#block-2">ПРАВОВАЯ ИНФОРМАЦИЯ</a>
                    <a class="nav-ln" href="http://417417.ru/" target="_blank">417417.RU</a>
                </nav>
            </div>
            <nav class="nav d-none d-sm-flex">
                <a class="nav-ln js-scroll" href="#home">НОВЫЙ ЗАКАЗ</a>
                <a class="nav-ln js-scroll" href="#block-1">УСЛОВИЯ</a>
                <a class="nav-ln js-scroll" href="#block-2">ПРАВОВАЯ ИНФОРМАЦИЯ</a>
                <?php if(Yii::$app->user->isGuest) { ?>
                    <a id="open-login-form" class="nav-ln" href="/site/login" target="_blank">ВХОД</a>
                <?php }else { ?>
                    <!--<a id="open-change-password-form" href="#">Изменение пароля</a>-->
                    <a class="nav-ln" href="/account/personal">ЛИЧНЫЙ КАБИНЕТ</a>
                    <a class="nav-ln" href="/site/logout">ВЫХОД</a>
                <?php } ?>
            </nav>

            <?= $content ?>

            <div class="soc mt-auto">
                <a class="soc-ln" target="_blank" href="">
                    <i class="icon-facebook"></i>
                </a>
                <a class="soc-ln" target="_blank" href="">
                    <i class="icon-twitter"></i>
                </a>
                <a class="soc-ln" target="_blank" href="">
                    <i class="icon-vk"></i>
                </a>
                <a class="soc-ln" target="_blank" href="">
                    <i class="icon-instagram"></i>
                </a>
                <a class="soc-ln" target="_blank" href="">
                    <i class="icon-youtube"></i>
                </a>
            </div><!-- /.soc -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</header>

<section class="section" id="block-1">
    <div class="container">
        <h2 class="title text-center">Условия предоставления услуг</h2>
        <p class="text">Настоящая политика регламентирует порядок сбора и обработки сервисом «Максим» (далее — Сервис) персональных и иных конфиденциальных данных физических лиц с использованием средств автоматизации посредством сети Интернет.</p>
        <p class="text bold">Общие положения</p>
        <p class="text">1. В рамках настоящего документа используются следующие термины:</p>
        <p class="text">1.1. Персональные данные — любая информация, относящаяся прямо или косвенно к определенному или определяемому физическому лицу (субъекту персональных данных).</p>
        <p class="text">1.2. Сервис — лицо, самостоятельно организующее и (или) осуществляющее обработку персональных данных, а также определяющее цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>
        <p class="text">1.3. Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: <a href="https://taximaxim.ru">taximaxim.ru</a> и <a href="https://taximaxim.com">taximaxim.com</a>, <a href="https://corp.taximaxim.com">corp.taximaxim.com</a>.</p>
    </div><!-- /.container -->
</section><!-- /.section -->

<section class="section bg-gray" id="block-2">
    <div class="container">
        <h2 class="title text-center">Правовая информация</h2>
        <p class="text">Настоящая политика регламентирует порядок сбора и обработки сервисом «Максим» (далее — Сервис) персональных и иных конфиденциальных данных физических лиц с использованием средств автоматизации посредством сети Интернет.</p>
        <p class="text bold">Общие положения</p>
        <p class="text">1. В рамках настоящего документа используются следующие термины:</p>
        <p class="text">1.1. Персональные данные — любая информация, относящаяся прямо или косвенно к определенному или определяемому физическому лицу (субъекту персональных данных).</p>
        <p class="text">1.2. Сервис — лицо, самостоятельно организующее и (или) осуществляющее обработку персональных данных, а также определяющее цели обработки персональных данных, состав персональных данных, подлежащих обработке, действия (операции), совершаемые с персональными данными.</p>
        <p class="text">1.3. Сайт — совокупность программ для электронных вычислительных машин и иной информации, содержащейся в информационной системе, доступ к которой обеспечивается посредством сети Интернет по доменным именам и (или) по сетевым адресам, позволяющим идентифицировать сайты в сети Интернет, используемая Сервисом для предоставления услуг Заказчикам. Адреса сайта: <a href="https://taximaxim.ru">taximaxim.ru</a> и <a href="https://taximaxim.com">taximaxim.com</a>, <a href="https://corp.taximaxim.com">corp.taximaxim.com</a>.</p>
    </div><!-- /.container -->
</section><!-- /.section -->

<section class="section">
    <div class="container">
        <h2 class="title text-center">Галерея</h2>
        <div class="row">
            <div class="col-12 col-sm-8 col-lg-3">
                <a class="gallery" href="/images/main_page/gal/1.jpg" data-fancybox="gallery" data-img="/images/main_page/gal/th-1.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-4 col-lg-4">
                <a class="gallery" href="images/main_page/gal/2.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-2.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-12 col-lg-5">
                <a class="gallery" href="images/main_page/gal/3.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-3.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a class="gallery" href="images/main_page/gal/4.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-4.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a class="gallery" href="images/main_page/gal/5.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-5.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-12 col-lg-4">
                <a class="gallery" href="images/main_page/gal/6.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-6.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-4 col-lg-6">
                <a class="gallery" href="images/main_page/gal/7.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-7.jpg"></a>
            </div><!-- /.col -->
            <div class="col-12 col-sm-8 col-lg-6">
                <a class="gallery" href="images/main_page/gal/8.jpg" data-fancybox="gallery" data-img="images/main_page/gal/th-8.jpg"></a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.section -->

<section class="video-16-9 js-video">
    <!-- data-video = id видео youtube -->
    <div class="video-iframe" data-video="r_2PRJxCakg"></div>
    <!-- video-post.jpg 16:9 -->
    <img class="video-post" src="images/main_page/video-post.jpg">
    <div class="video-overlay js-video-overlay">
        <div class="w-auto">
            <a class="video-btn js-video-btn" href="#"><i class="icon-play video-btn-icon"></i> Смотреть видео</a>
        </div>
    </div>
</section><!--/.video-->

<footer class="footer">
    <span class="bg-half-r"></span>
    <div class="container bg-half-cont">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6 footer-col text-center text-md-right">
                <h2 class="header-txt-b brown">КОНТАКТЫ</h2>
                <p class="header-txt-a">Representation</p>
                <p class="text white">
                    Manager<br>
                    Bruce Robertson<br>
                    Email - info@mysite.com<br>
                    Tel - 123-456-7890<br>
                </p>
                <p class="text white">
                    Commercial Agent<br>
                    Magnum - Steven Macfee<br>
                    Email - info@mysite.com<br>
                    Tel - 123-456-7890<br>
                </p>
                <p class="text white">
                    SF Agent<br>
                    Pinnacle - Nathan Kelly<br>
                    Email - info@mysite.com<br>
                    Tel - 123-456-7890<br>
                </p>
                <div class="footer-soc justify-content-center justify-content-md-end">
                    <a class="soc-ln" target="_blank" href="">
                        <i class="icon-facebook"></i>
                    </a>
                    <a class="soc-ln" target="_blank" href="">
                        <i class="icon-twitter"></i>
                    </a>
                    <a class="soc-ln" target="_blank" href="">
                        <i class="icon-vk"></i>
                    </a>
                    <a class="soc-ln" target="_blank" href="">
                        <i class="icon-instagram"></i>
                    </a>
                    <a class="soc-ln" target="_blank" href="">
                        <i class="icon-youtube"></i>
                    </a>
                </div><!-- /.soc -->
            </div>
        </div><!-- /.row -->
    </div>
</footer>

<div class="pt-15px pb-1px">
    <p class="text text-center"><span class="em-8">&copy; 2023 by Daniel Martinez</span></p>
</div>

<?php $this->endBody() ?>

<div id="default-modal" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md" style="width: 450px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <span class="modal-title">Заголовок...</span>
            </div>
            <div class="modal-body">
                <div id="modal-content">Загружаю...</div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php $this->endPage() ?>