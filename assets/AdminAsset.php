<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/admin/AdminLTE.min.css',
        //'template/lte/dist/css/AdminLTE.css',
        'css/admin/ionicons.min.css',
        'css/admin/skin-blue.min.css',
        'css/select-widget.css',
        'css/admin/admin.css',
        'css/main.css',
    ];
    public $js = [
        'template/lte/plugins/slimScroll/jquery.slimscroll.min.js',
        'template/lte/plugins/fastclick/fastclick.min.js',
        'template/lte/plugins/pace/pace.js',
        'js/main.js',
        'js/admin/app.js',
        'js/admin/admin.js',
        'js/select-widget.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
