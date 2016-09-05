<?php
namespace app\controllers;

use Yii;
use app\modules\admin\components\Controller;
use app\modules\admin\models\LoginForm;
use app\models\User;
use app\components\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * Account controller
 */
class SiteController extends BaseController
{
	public $layout = false;
	
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
	
	public function actions() {
		return [
				'captcha' =>  [
						'class' => 'yii\captcha\CaptchaAction',
						'height' => 50,
						'width' => 80,
						'minLength' => 4,
						'maxLength' => 4
				],
		];
	}
	
	/*
	 * 登录
	 * */
	public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(Url::to(['admin/default/index'])); //return $this->goHome();

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->login()){
                //Log::record(Log::TYPE_LOGIN, 'site/login', Yii::$app->user->user_id, Log::STATUS_SUCCESS, "用户「{$model->username}」成功!");
            	$current_user = Yii::$app->user->identity;
            	$community_id = $current_user->community_id;
            	if (!isset($community_id)) {
            		return $this->redirect(Url::to(['admin/default/index','#'=>'/security/cate5.0']));
            	}
                return $this->redirect(Url::to(['admin/default/index']));
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /*
     * 退出登录
     * */
    public function actionLogout()
    {
    	Yii::$app->user->logout();
    
    	return $this->goHome();
    }
   
}