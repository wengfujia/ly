<?php
namespace app\modules\admin\assets;

use yii\web\AssetBundle;


/**
 * Class AppAsset
 * 后台自定义的asset
 * @package app\modules\admin\assets
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@admin/assets/app';
    public $js = [
        'date.js',
        'common.js',
    	'paging.min.js',
    	'app.js',
    	'services.js',
    	'page-helpers.js', //翻页
    	'grid-helpers.js',
		
    	'site/mapController.js',
    	'site/siteController.js',
    	'site/layoutsController.js',
    	'community/communityController.js',
    	'building/buildingController.js',
    	'company/companyController.js',
    	'content/category/categoryController.js',
    	'content/house/rentController.js',
    	'content/house/sellController.js',
    	'content/post/postController.js',
    	'content/post/editpostController.js',
        'content/book/bookController.js',
    	'security/securityController.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
