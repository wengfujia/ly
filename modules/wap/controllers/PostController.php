<?php

namespace app\modules\wap\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Post;
use app\models\PostSearch;
use app\modules\wap\components\Controller;
use app\models\Category;

/**
 * 文章管理
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['DateCreated' => SORT_DESC];
        $dataProvider->pagination->pageSize = 15;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    /*
     * 查询文章
     * $category：分类名称
     * $page：当前页号
     * $pageSize：分页条数
     * 
     * */
    public function actionSearch($category, $page, $pageSize)
    {
    	$offset = ($page-1)*$pageSize;
    	$models = Post::getPostsByCategoryName($category, $pageSize, $offset);
    	//组合成数组返回
    	$result = [];
		foreach ($models as $model) {
			array_push($result, $model->attributes);
		}
		
    	return json_encode($result);
    }
    
    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $post= $this->findModel($id);
        return json_encode($post->attributes);
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
        if (($model = Post::findOne(['PostID'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
