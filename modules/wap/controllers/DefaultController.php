<?php
namespace app\modules\wap\controllers;

use app\components\Common;
use app\modules\wap\components\Controller;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

/**
 * Default controller
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLocale($language)
    {
        Common::setLanguage($language);
        return $this->redirect(['index']);
    }
    
    /*
     * 获取楼宇照片列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionBuildings($body)
    {
    	$result = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', $body);
    	return $result->getResult();
    }

}
