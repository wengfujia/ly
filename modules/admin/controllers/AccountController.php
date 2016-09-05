<?php
namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\components\Controller;
use app\models\User;
use app\modules\admin\models\JsonResult;

/**
 * Account controller
 */
class AccountController extends Controller
{
	public $layout = false;
	
	/**
	 * Lists all user models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		//获取所有有效的用户
		$models = User::find()->where(['status'=>User::STATUS_NORMAL])
			->orderBy(['username' => SORT_ASC])->asArray()->all();
		return json_encode($models);
	}
	
    /**
     * 用户注册
     */
    public function actionRegister() {
    	//if(!Yii::$app->user->isGuest)
    	//	$this->goHome();
    
    	//if(ArrayHelper::getValue(Yii::$app->params, Option::ALLOW_REGISTER) !== Option::STATUS_OPEN)
    	//	return $this->render('register-closed');

    	$result = new JsonResult();
    	
    	$model = new User();
    	$model->setScenario(User::SCENARIO_REGISTER);
    	if ($model->load(Yii::$app->request->post(), '')) {
    		if($model->save()){
    			Yii::$app->session->setFlash('RegOption','注册成功，请用刚才注册的帐号登录！');
    			//创建用户权限
    			$auth = Yii::$app->authManager;
    			$role = $auth->getRole($model->role);
    			$auth->assign($role, $model->id);
    			$result->result = 0;
    			$result->message = $model->username;
    			return json_encode($result);
    		}else
    			$model->password = $model->password_repeat = null;
    	}
    	
    	$result->result = 1;
    	$result->errors = $model->errors;
    	return json_encode($result);
    }
    
    /**
     * 更新用户
     */
    public function actionUpdate($id) {
    	$model = User::findOne($id);
    	if ($model === null) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
    	$result = new JsonResult();
    	$model->setScenario(User::SCENARIO_MANAGE);
    	if ($model->load(Yii::$app->request->post(), '')) {
    		if($model->save()){
    			//创建用户权限
    			$auth = Yii::$app->authManager;    			
    			$role = $auth->getRole($model->role);
    			//删除权限
    			$auth->revoke($role, $model->id);
    			//重新赋值权限
    			$auth->assign($role, $model->id);
    			$result->result = 0;
    			$result->message = $model->username;
    			return json_encode($result);
    		}
    	}
    	$result->result = 1;
    	$result->errors = $model->errors;
    	return json_encode($result);
    }
    
    /*
     * 删除用户
     * */
    public function actionDelete($id) {
    	$user = User::findOne($id);
    	$user->delete();
    	return $id;
    }
    
    /*
     * 修改密码
     * */
    public function actionChangepassword() {
    	$result = new JsonResult();
    	
    	$data = yii::$app->request->post();
	
    	$user = User::findOne(Yii::$app->user->id);
    	if (!$user || !$user->validatePassword($data['old_password'])) {
    		$result->result = 0;
    		$result->message = '旧密码错误!';
    		return json_encode($result);
    	}
    	
    	$user->password = $data['password'];
    	$user->scenario = User::SCENARIO_MODIFY_PWD;
    	if ($user->save()) {
    		$result->result = 0;
    		$result->message = $model->username;
    	} else {
    		$result->result = 1;
    		$result->errors = $model->errors;	
    	}
    	return json_encode($result);
    }
    
    /*
     * 更新社区序号
     * */
    public function actionChangecommunity($communityid) {
    	$user = User::findOne(Yii::$app->user->id);
    	$user->scenario = User::SCENARIO_MODIFY_PROFILE;
    	$user->community_id = $communityid;
    	if ($user->save()) {
    		return json_encode($communityid);
    	} else {
    		return json_encode($user->errors);
    	}
    }
    
}