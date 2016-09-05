<?php

namespace app\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\components\BaseController;
use app\models\Category;
use app\models\Postcategory;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseController
{
    /**
     * Lists all Post models by categoryName.
     * @return mixed
     */
    public function actionList($title)
    {
    	//查找分类
    	$category = Category::findOne(['CategoryName'=>$title]);
    	if (!isset($category))
    		throw new NotFoundHttpException('The requested page does not exist.');

    	$where = ['Status' => Post::STATUS_PUBLISHED];
    	
    	
    	//判断Post中是否有keyword字段
    	if (Yii::$app->request->isPost) {
    		$data = Yii::$app->request->post();
    		if (isset($data['keyword'])) {
    			$keyword = $data['keyword'];
    			$where= ['like', 'Title', $keyword];
    		}   		
    	}
    	
    	$subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
    	$dataProvider = new ActiveDataProvider([
    	    'query' => Post::find()
    	    	->select('PostID,Title,DateCreated')
    			->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])->andWhere($where)
    			->orderBy(['DateCreated' => SORT_DESC]),
    	    'pagination' => ['defaultPageSize' => 20]
    	]);
        
        $this->view->params['breadcrumbs'][] = $title;
        $this->view->params['breadcrumbs'][] = '文字列表';
        return $this->render('posts', ['dataProvider' => $dataProvider]);
    }
	
    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	//获取分类名称
    	$categoryid = Postcategory::findOne(['PostID'=>$id])->CategoryID;
    	$category = Category::findOne(['CategoryID'=>$categoryid]);
    	
    	$this->view->params['breadcrumbs'][] = isset($category)? $category->CategoryName:'';
    	$this->view->params['breadcrumbs'][] = '正文内容';
        return $this->render('show', [ 'post' => $this->findModel($id) ]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($slug)
    {
        $model = $this->findModelByAlias($slug);
		//获取分类名称
		$categoryid = Postcategory::findOne(['PostID'=>$model->PostID])->CategoryID;
		$category = Category::findOne(['CategoryID'=>$categoryid]);
		
		$this->view->params['breadcrumbs'][] = isset($category)? $category->CategoryName:'';
		$this->view->params['breadcrumbs'][] = '正文内容';
        return $this->render('show', [ 'post' => $model]);
    }

    /**
     * 根据社区序号获取新闻列表
     */
    public function actionCommunity($id)
    {
        $dataProvider = new ActiveDataProvider([
        	'query' => Post::find()
            	->select('PostID,Title,DateCreated')
            	->where(['Status'=>Post::STATUS_PUBLISHED, 'CommunityID'=>$id])
            	->orderBy(['DateCreated' => SORT_DESC]),
           	'pagination' => ['defaultPageSize' => 20]
        ]);
        return $this->render('posts', ['dataProvider' => $dataProvider]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['PostID'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alias
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByAlias($alias)
    {
        if (($model = Post::find()->where(['Slug' => $alias])->one()) !== null) {  //->with('category')
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
