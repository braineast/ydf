<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/17/2014
 * Time: 7:17 PM
 */

namespace frontend\assets;
use yii\web\AssetBundle;

class YdfAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ydf/common.css',
        'css/ydf/layout.css',
    ];
    public $js = [
        'javascript/open.js',
        'javascript/account/deposit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
}