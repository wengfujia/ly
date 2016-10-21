<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use app\components\BaseController;
use app\models\Post;
use app\components\helper\httpServices;
use app\components\coder\COMMANDID;
use app\models\Category;
use app\models\Postcategory;

/*
 * 楼宇控制器
 * */
class BuildingController extends BaseController
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
     * 获取楼宇资源，地块、园区、企业新闻列表资源
     * */
    public function actionIndex()
    {
    	//获取楼宇资源
    	$decoder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', '		');
    	$buildingProvider=new ArrayDataProvider(
    		[
    			'allModels' => $decoder->getContent(),
    			'pagination' => [
    				'pageSize' => 16,
    			]
    		]
    	);
    	
    	$category = Category::findOne(['CategoryName'=>'地块资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	//获取地块新闻
    	$landProvider = new ActiveDataProvider([
    	    'query' => Post::find()
    	    	->select('PostID,Title,PostContent,DateCreated')
    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
    			->orderBy(['DateCreated' => SORT_DESC]),
    	    'pagination' => ['defaultPageSize' => 16]
    	]);
    	
    	$category = Category::findOne(['CategoryName'=>'园区资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	//获取园区新闻
    	$parkProvider = new ActiveDataProvider([
    	    'query' => Post::find()
    	    	->select('PostID,Title,PostContent,DateCreated')
    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
    			->orderBy(['DateCreated' => SORT_DESC]),
    	    'pagination' => ['defaultPageSize' => 16]
    	]);

    	$category = Category::findOne(['CategoryName'=>'企业资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	//获取企业新闻
    	$companyProvider = new ActiveDataProvider([
    	    'query' => Post::find()
    	    	->select('PostID,Title,PostContent,DateCreated')
    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
    			->orderBy(['DateCreated' => SORT_DESC]),
    	    'pagination' => ['defaultPageSize' => 16]
    	]);
    	
    	$this->view->params['breadcrumbs'][] = '楼宇资源';
    	//返回视图页
		return $this->render('index', [ 
            'buildingProvider' => $buildingProvider,
            'landProvider' =>$landProvider,
		    'parkProvider'=>$parkProvider,
		    'companyProvider'=>$companyProvider
		] );
    }
    
    /*
     * 显示楼宇入驻企业与楼宇基本信息
     * 参数：$id楼宇序号
     * */
    public function actionShow($id)
    {
    	//读取楼宇信息
    	$decoder = httpServices::post(COMMANDID::$HOUSINGGET, 'guest', $id);
    	$building = $decoder->getContent()[0]['content'];
    	//读取入驻企业
    	$decoder = httpServices::post(COMMANDID::$HOUSINGCOMPANYLIST, 'guest', 'a.BuildingID=\''.$id.'\'		');
    	$companyProvider=new ArrayDataProvider(
    		[
    			'allModels' => $decoder->getContent(),
    			'pagination' => [
    				'pageSize' => 7,
    			]
    		]
    	);
    	
    	$this->view->params['breadcrumbs'][] = '楼宇资源';
    	//返回视图页
    	return $this->render('show', [
    		'building' => $building,
    		'companyProvider' =>$companyProvider
    	] );
    }

    /*
     * 搜索招商资源
     * 参数：$keyword搜索关键字 $title资源类虽
     * */
    public function actionSearch()
    {
    	$data = Yii::$app->request->post();
    	
    	$title = $data['title'];
    	$keyword = $data['keywords'];
    	
    	//获取楼宇资源
    	if ($title == '楼宇资源') {
    		$decoder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', 'a.Title like \'%'.$keyword.'%\'	');
    	}
    	else {
    		$decoder = httpServices::post(COMMANDID::$HOUSINGPHOTOLIST, 'guest', '		');
    	}
    	$buildingProvider=new ArrayDataProvider(
    		[
    			'allModels' => $decoder->getContent(),
    			'pagination' => [
    				'pageSize' => 16,
    			]
    		]
    	);
    	
    	//获取地块新闻
    	$category = Category::findOne(['CategoryName'=>'地块资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	if ($title == '地块资源') {
	    	$landProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])->andWhere(['like','Title',$title])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);	
    	}
    	else {
    		$landProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);
    	}
    	
    	//获取园区新闻
    	$category = Category::findOne(['CategoryName'=>'园区资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	if ($title == '园区资源') {
	    	$parkProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])->andWhere(['like','Title',$title])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);	
    	}
    	else {
    		$parkProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);
    	}
    	
    	//获取企业新闻
    	$category = Category::findOne(['CategoryName'=>'企业资源']);
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	if ($title == '园区资源') {
	    	$companyProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])->andWhere(['like','Title',$title])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);	
    	}
    	else {
    		$companyProvider = new ActiveDataProvider([
	    		'query' => Post::find()
	    			->select('PostID,Title,DateCreated')
	    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
	    			->orderBy(['DateCreated' => SORT_DESC]),
	    		'pagination' => ['defaultPageSize' => 16]
	    	]);
    	}
    	
    	$this->view->params['breadcrumbs'][] = $title;
    	//返回视图页
    	return $this->render('index', [
    			'buildingProvider' => $buildingProvider,
    			'landProvider' =>$landProvider,
    			'parkProvider'=>$parkProvider,
    			'companyProvider'=>$companyProvider
    	] );
    }
    
}
