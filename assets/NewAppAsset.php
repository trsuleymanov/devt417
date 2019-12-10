<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;


class NewAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [

//        'https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap&subset=cyrillic-ext',
//        'css/main_page/main.css?v=002',
//        'css/select-widget.css',
//        'css/main.css'

        'https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap&subset=cyrillic-ext',
//        'css/main_page/main.css?v=002',
//        'css/libs.min.css',
        'css/libs.css',
        'css/styles.css',
        'css/main_new.css',
        'css/select-widget.css',
    ];
    public $js = [
        //'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js',
        //'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        'js/site.js',
        //'js/main_page/main_page.js',
        'js/select-widget.js',
        'js/libs.js',
        'js/imask.js',
        'js/main_new.js',
        'js/editable-text-widget.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset' // непосредственное подключение bootstrap.js
    ];
}
