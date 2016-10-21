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
 * 服务办理控制器
 * */
class GuideController extends BaseController
{
	//布局
    public $layout = 'main';

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
     * 获取办理指南,不进行代码实现，直接在view中进行url写死
     * */
    public function actionIndex()
    {
    	//返回视图页
		return $this->render( 'index');
    }
}
