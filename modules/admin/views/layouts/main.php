<?php

use app\models\User;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use app\assets\FontAwesomeAsset;
use yii\bootstrap\Modal;
use app\components\Helper;

AdminAsset::register($this);
FontAwesomeAsset::register($this);

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
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue fixed sidebar-mini<?= $cookie->getValue('main-menu', 0) ? ' sidebar-collapse' : '' ?>">
<?php /* skin-black fixed sidebar-mini  pace-done */ ?>
<?php $this->beginBody() ?>


<div class="wrap">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/admin" class="logo">
            <span class="logo-lg"><b>Администратор</b></span>
        </a>

        <!-- Header Navbar -->
        <?php /*
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">Alexander Pierce</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
        */ ?>

        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="/site/logout">Выход (<?= Yii::$app->user->identity->last_name.' '.Yii::$app->user->identity->first_name ?>) </a> </li>
                    <?php
                    if(Yii::$app->session->get('role_alias') == 'warehouse_turnover') {
                        $url = '/storage';
                    }else {
                        $url = '/';
                    }
                    ?>
                    <li><a href="<?= $url ?>" style="font-size: 24px; font-weight: 700;">LMT-SYS</a></li>
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

                <li class="treeview <?= ($current_module == 'admin' && in_array($current_controller, ['client-ext',])) ? 'active' : '' ?>">
                    <a href="#">
                        <i class="fa fa-group"></i> <span>Пассажиры</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?= $current_controller == 'client-ext' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="fa fa-tasks"></i> <span>Заявки</span>', '/admin/client-ext'); ?>
                        </li>
                    </ul>
                </li>

                <li<?= ($current_module == 'admin' && in_array($current_controller, ['user', 'current-reg']) ? ' class="active"' : '') ?>>
                    <a href="#">
                        <i class="glyphicon glyphicon-user"></i> <span>Пользователи</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?= $current_controller == 'user' && $current_route == 'admin/user/index' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="fa fa-meh-o"></i> <span>Пользователи</span>', '/admin/user'); ?>
                        </li>
                        <li<?= $current_route == 'admin/current-reg/index' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="fa fa-frown-o"></i> <span>Не зарегистрировавшиеся</span>', '/admin/current-reg'); ?>
                        </li>
                    </ul>
                </li>

                <li<?= ($current_module == 'admin' && in_array($current_controller, ['account-transaction', 'yandex-payment']) ? ' class="active"' : '') ?>>
                    <a href="#">
                        <i class="glyphicon glyphicon-piggy-bank"></i> <span>Финансы</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?= $current_route == 'admin/account-transaction/index' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> <span>Транзакции пользователей</span>', '/admin/account-transaction'); ?>
                        </li>
                        <li<?= $current_route == 'admin/yandex-payment/index' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="glyphicon glyphicon glyphicon-ruble"></i> <span>Платежи / Возвраты</span>', '/admin/yandex-payment'); ?>
                        </li>
                    </ul>
                </li>


                <li<?= $current_controller == 'trip' ? ' class="active"' : ''; ?>>
                    <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> <span>Рейсы</span>', '/admin/trip'); ?>
                </li>

                <li<?= (in_array($current_route, ['admin/setting/call-settings']) ? ' class="active"' : '') ?>>
                    <a href="#">
                        <i class="glyphicon glyphicon-cog"></i> <span>Настройки</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li<?= $current_route == 'admin/setting/call-settings' ? ' class="active"' : '' ?>>
                            <?= Html::a('<i class="glyphicon glyphicon-th-list"></i> <span>Настройки CALL-авторизации</span>', '/admin/setting/call-settings'); ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <?php //if(in_array($current_controller, ['city', 'client'])) { ?>

            <?php if ($this->title) {?>
                <section class="content-header">
                    <h1 class="text-muted"><?= $this->title ?></h1>
                </section>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'homeLink' => ['label' => 'Администратор', 'url' => '/admin/'],
                    'encodeLabels' => false,
                    'options' => ['class' => 'breadcrumb breadcrumb-tobus'] // breadcrumb-lte
                ]); ?>
            <?php } ?>

        <!-- Main content -->
        <section class="content">

            <!-- Your Page Content Here -->
            <?= $content ?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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
