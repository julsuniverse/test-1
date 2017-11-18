<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'mt/css/slick.css',
        'mt/css/slick-theme.css',
    ];
    public $js = [
        'mt/js/slick.min.js',
        'mt/js/myslick.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
