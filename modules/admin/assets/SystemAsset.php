<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;

/**
 * Class SystemAsset
 * 后台自定义的asset
 * @package app\modules\admin\assets
 */
class SystemAsset extends AssetBundle
{
    public $sourcePath = 'assets/resources';
    public $css = [
        'content/bootstrap.min.css',
        'content/toastr.css',
    ];
    public $js = [
        'scripts/jQuery/01-jquery-1.9.1.min.js',
        'scripts/angular.js',
    	'scripts/angular-route.js',
    	'scripts/toastr.min.js',
    	'scripts/bootstrap.min.js',
    	'scripts/plupload/plupload.full.min.js', //上传插件
    	'scripts/plupload/fileupload.js',//自定义上传组件封装
    	//'scripts/ueditor/ueditor.config.js',//ueditor配置文件
    	//'scripts/ueditor/ueditor.all.js',//ueditor编辑器源码文件
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
