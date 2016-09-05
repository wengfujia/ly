<?php

namespace app\controllers;

use app\models\UploadForm;

use Yii;
use yii\web\Response;

/*
 * 文件上传控制器
 * */
class FileController extends \yii\base\Controller
{
    /*
     * 上传文件
     * */   
    public function actionUpload()
    {
    	Yii::$app->response->format=Response::FORMAT_JSON;
        $model = New UploadForm();
        $model->fileInputName = 'file';
        if($model->save()){
            return ['code'=>0,'message'=>$model->getMessage(),'name'=>$model->getBaseName(),'path'=>$model->getUrlPath()];
        }else{
            return ['code'=>1,'message'=>$model->getMessage()];
        }
    }
}
