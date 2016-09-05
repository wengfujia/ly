<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\components\coder\COMMANDID;
use app\modules\admin\components\Controller;

/*
 * 企业管理控制器
 * */
class CompanyController extends Controller
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
     * 获取企业信息列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionList()
    {
   		return $this->post(COMMANDID::$COMPANYLIST);
    }
    
    /*
     * 获取企业名称列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionSimple()
    {
    	return $this->post(COMMANDID::$COMPANYSIMPLELIST);
    }
    
    /*
     * 获取企业信息详情
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为企业序号）
     * */
    public function actionGet()
    {   
    	if (isset($_GET['body'])) //body参数必须存在
    	{
	   		return $this->post(COMMANDID::$COMPANYGET);
    	} 
    }
    
    /*
     * 获取企业注销信息详情
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为企业序号）
     * */
    public function actionGetlogout()
    {
    	if (isset($_GET['body'])) //body参数必须存在
    	{
    		return $this->post(COMMANDID::$COMPANYGETLOGOUT);
    	}
    }
    
    
    /*
     * 添加企业信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为企业信息字段集，字段间用\t分隔）
     * */
    public function actionSave()
    {
    	if (isset($_GET['body']))
    	{
	   		return $this->post(COMMANDID::$COMPANYSAVE);
    	}
    }
    
    /*
     * 添加企业注销信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为企业注销信息字段集，字段间用\t分隔）
     * */
    public function actionSavelogout()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$COMPANYSAVELOGOUT);
    	}
    }
    
    /*
     * 企业注销审核
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（审核信息字段，字段间用\t分隔）
     * */
    public function actionChecklogout()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$COMPANYSAVELOGOUTCHECK);
    	}
    }
    
    /*
     * 删除企业信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为企业序号））
     * */
    public function actionDel()
    {
    	if (isset($_GET['body']))
    	{
	   		return $this->post(COMMANDID::$COMPANYDEL);
    	}
    }
    
}
