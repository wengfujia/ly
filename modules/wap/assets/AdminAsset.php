<?php
namespace app\modules\wap\assets;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 * 移动端的asset
 * @package app\modules\wap\assets
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@wap/assets/resources';
    public $css = [
        'style/common.css',
    	'style/plus.css',
    ];
    public $js = [
        'js/slider.nz.js',
		'js/plus.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
