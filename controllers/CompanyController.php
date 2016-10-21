<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\components\BaseController;
use app\models\Post;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

/*
 * 入驻企业控制器
 * */
class CompanyController extends BaseController
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
     * 获取入驻企业
     * 参数：企业名称
     * */
    public function actionIndex()
    {
    	$data = Yii::$app->request->post();
    	$companyName = $data['keyword'];
    	
    	//获取入驻企业
    	$decoder = httpServices::post(COMMANDID::$COMPANYLIST, 'guest', 'a.CompanyName like \'%'.$companyName.'%\'			0	1');
    	//if (count($decoder->getContent())==0) {
    	//	throw new NotFoundHttpException('The requested page does not exist.');
    	//}
    	
    	$companyProvider=new ArrayDataProvider(
    		[
    			'allModels' => $decoder->getContent(),
    			'pagination' => [
    					'pageSize' => 16,
    				]
    		]
    	);
    	
    	//返回视图页
		return $this->render( 'index', ['companyProvider' => $companyProvider] );
    }
}
