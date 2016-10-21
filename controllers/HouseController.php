<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\components\BaseController;
use app\models\Post;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;

/*
 * 房源出租出售控制器
 * */
class HouseController extends BaseController
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
     * 获取出租房源信息
     * */
    public function actionRent()
    {
        $coder = httpServices::post(COMMANDID::$RENTLIST, 'guest', '		0	1	0');
        $rentProvider=new ArrayDataProvider(
            [
                'allModels' => $coder->getContent(),
                'pagination' => [
                    'pageSize' => 16,
                ]
            ]
        );
        
        //返回视图页
		return $this->render('rent', [ 
			'rentProvider' => $rentProvider
		] );
    }
    
    /*
     * 获取出售房源信息
     * */
    public function actionSale()
    {
        $coder = httpServices::post(COMMANDID::$SELLLIST, 'guest', '		0	1	0');
        $saleProvider=new ArrayDataProvider(
            [
                'allModels' => $coder->getContent(),
                'pagination' => [
                    'pageSize' => 16,
                ]
            ]
        );
    
        //返回视图页
        return $this->render('sale', [
            'saleProvider' => $saleProvider
        ] );
    }
    
    /*
     * 查找出租/出售房源信息
     * */
    public function actionSearch()
    {
    	$condition = '';
    	//获取查询条件
    	$data = Yii::$app->request->post();
    	//楼宇名称
    	if (!empty($data['buildingname'])) {
    		$condition='Title=\''.$data['buildingname'].'\'';
    	}
    	//面积
    	if (!empty($data['area']) && $data['area']>'0') {
    		$area=$data['area'];
    		switch ($area)
    		{
    			case 1:
    				$condition=$condition.' and Area<100';
    			break;
    			case 2:
    				$condition=$condition.' and Area>=100 and Area<200';
    			break;
    			case 3:
    				$condition=$condition.' and Area>=200 and Area<300';
    			break;
    			case 4:
    				$condition=$condition.' and Area>=300';
    			break;
    		}    		
    	}
    	//物业费
    	if (!empty($data['services']) && $data['services']>'0') {
    		$services=$data['services'];
    		switch ($services)
    		{
    			case 1:
    				$condition=$condition.' and ServiceFee<1';
    			break;
    			case 2:
    				$condition=$condition.' and ServiceFee>=1 and ServiceFee<2';
    			break;
    			case 3:
    				$condition=$condition.' and ServiceFee>=2 and ServiceFee<3';
    			break;
    			case 4:
    				$condition=$condition.' and ServiceFee>=3';
    			break;
    		}   	
    	}
    	//租金
    	if (!empty($data['rent']) && $data['rent']>'0') {
    		$rent=$data['rent'];
    		switch ($rent)
    		{
    			case 1:
    				$condition=$condition.' and Rent<2000';
    			break;
    			case 2:
    				$condition=$condition.' and Rent>=2000 and Rent<4000';
    			break;
    			case 3:
    				$condition=$condition.' and Rent>=4000 and Rent<6000';
    			break;
    			case 4:
    				$condition=$condition.' and Rent>=6000';
    			break;
    		}   		 
    	}
		if (substr($condition, 0, 4) == ' and') {
			$condition=substr($condition, 5, strlen($condition)-4);
		}
		
		//获取业务标识号
		$commandid=$data['type'];
		//获取查询
    	$coder = httpServices::post($commandid, 'guest', $condition.'		0	1	0');
    	$provider=new ArrayDataProvider(
    		[
    			'allModels' => $coder->getContent(),
    			'pagination' => [
    				'pageSize' => 16,
    			]
    		]
    	);
    	
    	//
    	if ($commandid == 4000) { //出租
    		//返回视图页
    		return $this->render('rent', [
    			'rentProvider' => $provider
    		] );
    	}
    	else { //出售
    		//返回视图页
    		return $this->render('sale', [
    			'saleProvider' => $provider
    		] );
    	}    	
    }
    
}
