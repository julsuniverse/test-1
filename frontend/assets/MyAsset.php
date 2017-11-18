<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'mt/css/index.css',
        'mt/css/reviews.css',
        //'mt/css/font-awesome.min.css',
        'mt/css/raiting.css',
        'mt/css/company.css',
    ];
    public $js = [
        'mt/js/scripts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
