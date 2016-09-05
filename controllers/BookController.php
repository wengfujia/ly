<?php

namespace app\controllers;

use yii;
use app\models\Book;

class BookController extends \yii\web\Controller
{
	public $layout = 'book';
	
	/*
	 * 反馈首页
	 * */
    public function actionIndex()
    {
    	$model = new Book();
        return $this->render('index', ['model' => $model]);
    }
	
    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new Book();
    	if ($model->load(Yii::$app->request->post())) {
    		$model->datecreated = time();
    		if($model->save())
    			return $this->render('show', ['model' => $model]);
    	}
    
    	return $this->render('index', ['model' => $model]);
    }
}
