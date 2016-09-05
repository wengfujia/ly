<?php
namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;

/**
 * Default controller
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
    	//判断是否用户登录
        return $this->render('index');
    }

    public function actionLocale($language)
    {
        Common::setLanguage($language);
        return $this->redirect(['index']);
    }

}