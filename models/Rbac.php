<?php

namespace app\models;

use yii\rbac\DbManager;

/*
 * DbManager类封装的方法公开
 * */
class Rbac extends DbManager{

	/*
	 * 创建权限或角色
	 * */
	public function createItem($item){
		if(empty($item->name) || $this->getOneItem($item->name) !== null)
			return false;
		
		return $this->addItem($item) ? true : false;
	}

	/*
	 * 获取权限或角色
	 * */
	public function getOneItem($name){
		return $this->getItem($name);
	}

	/*
	 * 更新权限或角色
	 * */
	public function updateOneItem($name, $item){
		return $this->updateItem($name, $item);
	}

	/*
	 * 删除权限或角色
	 * */
	public function deleteOneItem($name){
		if($item = $this->getOneItem($name))
			return $this->removeItem($item);
		else
			return false;
	}

}