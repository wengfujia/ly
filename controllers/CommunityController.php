<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\BaseController;
use app\models\Post;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

/*
 * 社区控制器
 * */
class CommunityController extends BaseController
{
	//布局
    public $layout = 'community';

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
                'maxLength' => 5,
                'minLength' => 4,
                'testLimit' => 2,
                'transparent' => true
            ],
        ];
    }

    /*
     * 获取社区新闻与基本信息
     * 参数：社区序号
     * */
    public function actionIndex($id)
    {
    	//获取社区介绍
    	$decoder = httpServices::post(COMMANDID::$COMMUNITYGET, 'guest', $id);
    	if (count($decoder->getContent())==0) {
    		$this->redirect('error');
    	}
    	$community = $decoder->getContent()[0]['content'];
    	
    	//获取社区楼宇资源
    	$buildings = [];
    	$decoder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', 'b.CommunityID=\'%'.$id.'%\'	');
    	if (count($decoder->getContent())>0) {
    		$buildings = $decoder->getContent()[0]['content'];
    	}

    	//查找社区新闻
    	$models = Post::find()->select('PostID,Title,DateCreated')->where(['CommunityID'=>$id, 'Status'=>Post::STATUS_PUBLISHED])->limit(15)->all();
    	$this->view->params['breadcrumbs'][] = $community[1];
    	
    	//返回视图页
		return $this->render( 'index', [ 
				'posts' => $models,
				'community' => $community,
				'buildings' => $buildings
		] );
    }
}
