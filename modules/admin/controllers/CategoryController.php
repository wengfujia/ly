<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\Category;
use app\modules\admin\components\Controller;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
	
	public function init(){
		$this->enableCsrfValidation = false;
	}

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Category::find()->where(['ParentID'=>['',null]])->orderBy(['SortOrder' => SORT_ASC, 'CategoryID' => SORT_ASC])->asArray()->all();
        return json_encode($models);
    }

    /**
     * Save a Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSave()
    {  	   	
    	$data = Yii::$app->request->post();
		$id = $data['CategoryID'];
    	if (!empty($id)) {
    		$model = Category::findOne(['CategoryID'=>$id]);
    	}
   		else {
   			$model = new Category();
   		}
    	$model->CategoryName = $data['CategoryName'];
    	$model->Description = $data['Description'];
    	$model->ParentID = '';
    	$model->SortOrder = 0;
    	if (!$model->save()) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
    	return $model->CategoryID;   	
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $result = $this->findModel($id)->delete();
        if ($result == false) {
        	throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $id;
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['CategoryID'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
