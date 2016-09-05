<?php
namespace app\modules\wap\assets;

use yii\web\AssetBundle;


/**
 * Class AppAsset
 * 移动端的asset
 * @package app\modules\wap\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@wap/assets/app';
    public $js = [
        'date.js',
        'common.js',
    	'app.js',
    	'services.js',
    	'page-helpers.js', //翻页
    	
    	'default/sliderController.js',
    	'default/indexController.js',
    	'default/siteController.js',
    	'building/buildingController.js',
    	'house/rent/rentController.js',
    	'content/post/postController.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
