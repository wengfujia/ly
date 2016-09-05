<?php
namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;

/**
 * Content controller
 */
class ContentController extends Controller
{
	public $layout = 'content';
	
    public function actionEditpost()
    {
    	//判断是否用户登录
        return $this->render('editPost');
    }

}