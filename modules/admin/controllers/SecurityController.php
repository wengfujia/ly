<?php
namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\components\Controller;

/**
 * Security controller
 * 权限控制器
 */
class SecurityController extends Controller
{
	public $layout = false;

	/*
	 * 获取权限列表
	 * */
	public function actionList()
	{
		if (Yii::$app->user->isGuest)
			throw new NotFoundHttpException('The requested page does not exist.');
		
		$roles = [];
		
		$auth = \Yii::$app->authManager;		
		foreach ($auth->getRoles() as $role) {
			array_push($roles, $role);
		}

		return json_encode($roles);
	}
	
	/*
	 * 根据角色名称获取权限
	 * */
	public function actionPermissions($roleName) {
		if (Yii::$app->user->isGuest)
			throw new NotFoundHttpException('The requested page does not exist.');
		
		$result = [];
		
		$auth = \Yii::$app->authManager;
		$permissions = $auth->getPermissionsByRole($roleName);
		foreach ($permissions as $permission) {
			array_push($result, $permission);
		}
		
		return json_encode($result);
	}
	
	/*
	 * 保存权限
	 * */
	public function actionSave()
    {
		if (Yii::$app->user->isGuest)
            throw new NotFoundHttpException('The requested page does not exist.');
        
        //获取参数
        $data = Yii::$app->request->post();
        $name = $data['name'];
        $items = $data['items'];
        //创建角色
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($name);
        if ($auth->getRole($name) == null) { //角色不存在，进行创建角色
        	$auth->add($role); //保存角色
        }
        else {
        	//删除该角色下的所有权限
        	$auth->removeChildren($role);
        }

        //创建权限
        $item_array = explode('|', $items);
        foreach ($item_array as $item)
        {
        	if (!empty($item))
        	{
        		$permission = $auth->createPermission($item);
        		if ($auth->getPermission($item) == null) {
        			$auth->add($permission);
        		}
        		//将权限赋予角色
        		if ($auth->hasChild($role, $permission) === false) {
        			$auth->addChild($role, $permission);
        		}
        	}
        }
        
        return $name;  
    }

    /*
     * 删除角色
     * */
    public function actionDelete($roleName) 
    {
    	if (Yii::$app->user->isGuest)
    		throw new NotFoundHttpException('The requested page does not exist.');
    	
    	$auth = Yii::$app->authManager;
    	$role = $auth->getRole($roleName);    	
    	$auth->removeChildren($role);
    	$auth->remove($role);
    	
    	return $roleName;
    }
    
}