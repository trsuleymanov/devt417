<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AccountAsset;
use app\assets\FontAwesomeAsset;
use yii\bootstrap\Modal;
use app\components\Helper;

AccountAsset::register($this);
// FontAwesomeAsset::register($this);

$cookie = Yii::$app->getRequest()->getCookies();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style type="text/css">
        .sidebar-menu li.active * {
            font-weight: bold;
        }
    </style>
    <?php $this->head() ?>
</head>
<body class="hold-transition_ skin-blue_ fixed_ sidebar-mini_<?= $cookie->getValue('main-menu', 0) ? ' sidebar-collapse_' : '' ?>">
<?php /* skin-black fixed sidebar-mini  pace-done */ ?>
<?php $this->beginBody() ?>


<div class="wrap">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/account/personal" class="logo">
            <span class="logo-lg"><b>Личный кабинет</b></span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">

            <?php
            /*
            $user = Yii::$app->user->identity;
            if($user != null && $user->email_is_confirmed == false) { ?>
                <span style="line-height: 50px; color: red;">Пока вы не подвердили электронную почту пройдя по ссылке на почту, вам не будет доступно бронирование заказов при создании заказа.</span>
            <?php }*/ ?>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="/site/logout">Выход</a></li>
                    <?php
                    if(Yii::$app->session->get('role_alias') == 'warehouse_turnover') {
                        $url = '/storage';
                    }else {
                        $url = '/';
                    }
                    ?>
                    <li><a href="<?= $url ?>" style="font-size: 24px; font-weight: 700;">t417.ru</a></li>
                    <li style="padding: 7px 0 7px 15px; font-size: 12px; text-align: left; width: 160px; color: #FFFFFF;">
                        Текущая дата:<br />
                        <span id="system-time"><?= Helper::getMainDate(time(), 1); ?></span>
                    </li>
                </ul>
            </div>
        </nav>


    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $current_module = Yii::$app->controller->module->id;
            $current_controller = Yii::$app->controller->id;
            $current_route = $this->context->route;

            //            echo "current_module=$current_module <br />";
            //            echo "current_controller=$current_controller <br />";
            //            echo "current_route=$current_route <br />";
            ?>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <?php
                /*
                //if(in_array(Yii::$app->session->get('role_alias'), ['root', 'admin'])) { ?>
                <li class="treeview <?= ($current_module == 'admin' && in_array($current_controller, ['city', 'direction', 'tariff'])) ? 'active' : '' ?>">
                    <a href="#">
                        <i class="fa fa-exchange"></i> <span>Маршруты и тарифы</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?= $current_controller == 'city' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="glyphicon glyphicon-map-marker"></i> <span>Города</span>', '/admin/city'); ?>
                        </li>
                        <li<?= $current_controller == 'direction' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="glyphicon glyphicon-road"></i> <span>Направления</span>', '/admin/direction'); ?>
                        </li>
                    </ul>
                </li>
                <?php } */ ?>

                <li<?= $current_controller == 'personal' ? ' class="active"' : ''; ?>>
                    <?= Html::a('<i class="glyphicon glyphicon-user"></i> <span>Персональные данные</span>', '/account/personal'); ?>
                </li>

                <li<?= $current_controller == 'order' ? ' class="active"' : ''; ?>>
                    <?= Html::a('<i class="glyphicon glyphicon-transfer"></i> <span>История поездок</span>', '/account/order'); ?>
                </li>

            </ul>
        </section>
    </aside>


    <div class="content-wrapper">
        <section class="content">

            <?php
            $user = Yii::$app->user->identity;
            if($user != null && $user->email_is_confirmed == false) { ?>
                <span style="line-height: 50px; color: red;">Пока вы не подвердили электронную почту пройдя по ссылке на почту, вам не будет доступно бронирование заказов при создании заказа.</span>
                <br /><br />
            <?php } ?>

            <?= $content ?>
        </section>
    </div>
</div>

<?php $this->endBody() ?>

<?php
// Модальное окно для загрузки содержимого с помощью ajax
Modal::begin([
    'header' => '<h4 class="modal-title">Заполните форму</h4>',
    'id' => 'default-modal',
    'size' => 'modal-md',
]);
?>
<div id='modal-content'>Загружаю...</div>
<?php Modal::end(); ?>

</body>
</html>
<?php $this->endPage() ?>
