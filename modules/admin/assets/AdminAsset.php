<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * 后台自定义的asset
 * @package app\modules\admin\assets
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@admin/assets/resources';
    public $css = [
        'themes/standard/css/main.css',
    	'themes/standard/css/map.css', //高德地 图加载
    ];
    public $js = [
        'themes/standard/js/common.js'//后台JS包
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
