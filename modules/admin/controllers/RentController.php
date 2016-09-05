<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\components\coder\COMMANDID;
use app\modules\admin\components\Controller;

/*
 * 出租管理控制器
 * */
class RentController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /*
     * 获取出租信息列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionList()
    {
   		return $this->post(COMMANDID::$RENTLIST);
    }
    
    /*
     * 获取出租信息详情
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为出租房源序号）
     * */
    public function actionGet()
    {   
    	if (isset($_GET['body'])) //body参数必须存在
    	{
	   		return $this->post(COMMANDID::$RENTGET);
    	} 
    }
    
    /*
     * 添加出租信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为出租信息字段集，字段间用\t分隔）
     * */
    public function actionSave()
    {
    	if (isset($_GET['body']))
    	{
	   		return $this->post(COMMANDID::$RENTSAVE);
    	}
    }
    
    /*
     * 删除出租信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为出租序号））
     * */
    public function actionDel()
    {
    	if (isset($_GET['body']))
    	{
	   		return $this->post(COMMANDID::$RENTDEL);
    	}
    }
    
}
