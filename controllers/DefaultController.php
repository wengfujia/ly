<?php
namespace app\controllers;

use app\components\BaseController;

/**
 * Default controller
 */
class DefaultController extends BaseController
{
	public $layout = 'main';
	
    public function actionIndex()
    {
        return $this->render('index');
    }
}
