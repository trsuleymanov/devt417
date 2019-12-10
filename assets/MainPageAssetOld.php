<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class MainPageAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap&subset=cyrillic-ext',
        'css/main_page/main.css?v=002',
        'css/select-widget.css',
        'css/main.css'
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        'js/site.js',
        //'js/main_page/jquery.fancybox.js',
        //'js/main_page/jquery.fancybox2.js',
        //'js/main_page/main.js',

//        'js/main_page/jquery.fancybox2.js',
//        'js/main_page/daterangepicker.js',
//        'js/main_page/jquery.inputmask.bundle.js',
//        'js/main_page/moment.js',

        'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
        'js/main_page/main_page.js',
        'js/select-widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset' // непосредственное подключение bootstrap.js
    ];
}
