<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\Post;
use app\modules\admin\components\Controller;
use app\models\Postcategory;

/**
 * 文章管理
 */
class PostController extends Controller
{
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/

	public function init(){
		$this->enableCsrfValidation = false;
	}
	
    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        //获取所有有效的posts
        $models = Post::find()->where(['Status'=>[Post::STATUS_DRAFT,Post::STATUS_PUBLISHED]])
        	->orderBy(['DateCreated' => SORT_DESC])->asArray()->all();
        return json_encode($models);
    }
    
    /*
     * 根据标题查询
     * */
    public function actionSearch($searchTxt)
    {
    	$models = Post::find()->where(['Status'=>[Post::STATUS_DRAFT,Post::STATUS_PUBLISHED]])->andWhere(['like', 'Title', $searchTxt])
    		->orderBy(['DateCreated' => SORT_DESC])->asArray()->all();
    	return json_encode($models);
    }
    
    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$post = $this->findModel($id);
        $postCategory = Postcategory::findAll(['PostID'=>$id]);
        //组合成分类序号集，用|分隔
        $categories = '';
        foreach ($postCategory as $category) {
        	$categories = $categories.'|'.$category->CategoryID;
        }
        
        $result = $post->attributes;
        //添加分类序号
        $result['Categories'] = $categories;
        return json_encode($result);
        
        //return $this->render('view', [ 'model' => $this->findModel($id) ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$data = Yii::$app->request->post();
    	if (!isset($data['Categories'])) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
    	$model = new Post();
        if ($model->load(Yii::$app->request->post(), '')) {
            $model->Author = 'test';//Yii::$app->user->id;
            $model->Raters = 0;
            $model->IsCommentEnabled = 0;
            $model->Status = 1;
            if($model->save()) {
            	//删除旧的分类表
            	Postcategory::deleteAll(['PostID'=>$model->PostID]);
            	$category_array = explode('|', $data['Categories']);
            	//保存分类
            	foreach ($category_array as $catid) {
            		if (!empty($catid)) {
            			$cat = new Postcategory();
            			$cat->CategoryID = $catid;
            			$cat->PostID = $model->PostID;
            			$cat->save();
            		}
            	}
            	return $model->PostID;
            }
        }

        return null;
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$data = Yii::$app->request->post();
    	if (!isset($data['Categories'])) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	
        $model = $this->findModel($id);
        $model->setScenario(Post::SCENARIO_EDIT);
        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
        	//更新分类
        	//删除旧的分类表
        	Postcategory::deleteAll(['PostID'=>$model->PostID]);
        	$category_array = explode('|', $data['Categories']);
        	//保存分类
        	foreach ($category_array as $catid) {
        		if (!empty($catid)) {
        			$cat = new Postcategory();
        			$cat->CategoryID = $catid;
        			$cat->PostID = $model->PostID;
        			$cat->save();
        		}
        	}
            return $model->PostID;
        }

        return null;
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Post::deleteAll(['PostID'=>$id]);
        Postcategory::deleteAll(['PostID'=>$id]);
        return $id;
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['PostID' =>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
