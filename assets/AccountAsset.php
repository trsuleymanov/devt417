<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AccountAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
        'css/admin/AdminLTE.min.css',
        'css/admin/ionicons.min.css',
        'css/admin/skin-blue.min.css',
        'css/select-widget.css',
        'css/admin/admin.css',
        'css/main.css',
        'css/editable-text-widget.css',
    ];
    public $js = [
        'template/lte/plugins/slimScroll/jquery.slimscroll.min.js',
        'template/lte/plugins/fastclick/fastclick.min.js',
        'template/lte/plugins/pace/pace.js',
        'js/main.js',
        'js/admin/app.js',
        'js/admin/admin.js',
        'js/select-widget.js',
        'js/editable-text-widget.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset' // непосредственное подключение bootstrap.js
    ];


}
