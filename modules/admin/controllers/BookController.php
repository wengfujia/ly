<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;
use app\models\Book;

/*
 * 意见反馈控制器
 * */
class BookController extends Controller
{

	public function init(){
		$this->enableCsrfValidation = false;
	}
	
	/*
	 * 获取所有的意见反馈
	 * */
    public function actionIndex()
    {
    	//获取所有的意见
    	$books = Book::find()->select('id,title,content,datecreated')->orderBy(['datecreated' => SORT_ASC])->asArray()->all();
    	//返回结果
    	return json_encode($books);
    }

    /*
     * 查看反馈详情
     * */
    public function actionView($id)
    {
    	//获取详情
    	$book = Book::findOne(['id'=>$id]);
    	if ($book == null) 
    		throw new NotFoundHttpException('The requested page does not exist.');
    	
    	//返回结果
    	return json_encode($book->attributes);
    }
}
