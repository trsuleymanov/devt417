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
        'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap&subset=cyrillic-ext',
        'css/libs.css',
        'css/styles.css',
        'css/main_new.css',
        'css/select-widget.css',
        'css/point-select-widget.css',
    ];
    public $js = [
        'https://www.google.com/recaptcha/api.js?render=6Lewg8wUAAAAABhM-tLlmiRNYSLdf17N87agjkmR',
        'js/select-widget.js',
        'js/point-select-widget.js',
        'js/libs.js',
        'js/imask.js',
        'js/editable-text-widget.js',
        'js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset' // непосредственное подключение bootstrap.js
    ];
}
