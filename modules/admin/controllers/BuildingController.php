<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use app\modules\admin\components\Controller;
use app\components\coder\COMMANDID;

/*
 * 楼宇管理控制器
 * */
class BuildingController extends Controller
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
     * 获取楼宇信息列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionList()
    {
   		return $this->post(COMMANDID::$HOUSINGLIST);
    }
    
    /*
     * 获取楼宇名称列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为自定义查询条件）
     * */
    public function actionSimple()
    {
    	return $this->post(COMMANDID::$HOUSINGSIMPLELIST);
    }
    
    /*
     * 获取楼层信息列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:楼宇序号
     * */
    public function actionFloorlist()
    {
    	return $this->post(COMMANDID::$HOUSINGFLOORLIST);
    }
    
    /*
     * 获取房间信息列表
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:楼宇序号+楼层号
     * */
    public function actionRoomlist()
    {
    	return $this->post(COMMANDID::$HOUSINGROOMLIST);
    }
    
    /*
     * 获取楼宇入驻情况统计
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:楼宇序号集，各序号间用，分隔
     * */
    public function actionSettledstats()
    {
    	return $this->post(COMMANDID::$HOUSINGSTATSLIST);
    }
    
    /*
     * 获取楼宇楼层入驻情况统计
     * 参数：
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:楼宇序号
     * */
    public function actionFloorsettledstats()
    {
    	return $this->post(COMMANDID::$HOUSINGFLOORSTATSLIST);
    }
    
    /*
     * 获取楼宇信息详情
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为楼宇序号）
     * */
    public function actionGet()
    {   
    	if (isset($_GET['body'])) //body参数必须存在
    	{
	   		return $this->post(COMMANDID::$HOUSINGGET);
    	} 
    }
    
    /*
     * 获取楼宇信息详情
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（roomid房间序号）
     * */
    public function actionGetroom()
    {
    	if (isset($_GET['body'])) //body参数必须存在
    	{
    		return $this->post(COMMANDID::$HOUSINGROOMGET);
    	}
    }
    
    /*
     * 添加楼宇信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为楼宇信息字段集，字段间用\t分隔）
     * */
    public function actionSave()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$HOUSINGSAVE);
    	}
    }
    
    /*
     * 修改楼层面积
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（楼序号\t楼层号\t楼层面积）
     * */
    public function actionSavefloor()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$HOUSINGFLOORSAVE);
    	}
    }
    
    /*
     * 添加房间信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为房间信息字段集，字段间用\t分隔）
     * */
    public function actionSaveroom()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$HOUSINGROOMSAVE);
    	}
    }
    
    /*
     * 删除楼宇信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（该为楼宇序号）
     * */
    public function actionDel()
    {
    	if (isset($_GET['body']))
    	{
	   		return $this->post(COMMANDID::$HOUSINGDEL);
    	}
    }
    
    /*
     * 删除房间信息
     * 	username:用户帐号(如果为空，表示使用当前登录帐号)
     * 	body:网络包内容（roomid房间序号）
     * */
    public function actionDelroom()
    {
    	if (isset($_GET['body']))
    	{
    		return $this->post(COMMANDID::$HOUSINGROOMDEL);
    	}
    }
    
}
