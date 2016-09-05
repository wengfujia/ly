<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\caching\DbDependency;
use yii\db\Query;
use app\components\BaseModel;
use app\components\XUtils;
use Faker\Provider\Uuid;


/**
 * This is the model class for table "{{%posts}}".
 *
 * @property string $PostID 文章ID
 * @property string $CommunityID 所属社区
 * @property string $Title 标题
 * @property string $Description 简介
 * @property string $PostContent 内容
 * @property integer $DateCreated 创建时间
 * @property integer $DateModified 更新时间
 * @property integer $Raters 点击数量
 * @property string $Author 发布人（文章发布人）
 * @property string $Writer 作者
 * @property string $Editor 编辑
 * @property string $CopyFrom 来源
 * @property string $OutUrl 外部链接
 * @property string $Slug 别名
 * @property integer $IsCommentEnabled 是否允许评论
 * @property integer $Status 状态
 * 
 * #利用魔术方法获取的属性
 * @property array $availableStatus 支持的文章状态
 * @property string $postStatus 文章状态
 * @property string $url 访问地址
 * @property string $postCategory 文章分类
 *
 * #relations
 * @property User $profile 作者资料
 * @property Category $category 分类
 * @property Comment[] $comments 评论s
 * @property Comment[] $allComments 全部评论s
 * @property Tag[] $postTags 标签s
 */

class Post extends BaseModel
{
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_MANAGE = 'manage';
    /**
     * 文章状态
     * 共三类
     * 已发布、未发布、删除
     */
    const STATUS_PUBLISHED = '1';
    const STATUS_DRAFT = '0'; //未发布，存草稿
    const STATUS_DELETED = '2';  

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_EDIT] = ['Author', 'Title', 'PostContent', 'Description'];
        $scenarios[self::SCENARIO_MANAGE] = $scenarios[self::SCENARIO_EDIT] + ['DateCreated'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['Author', 'Title', 'PostContent'], 'required'],
        	[['Description', 'PostContent'], 'string'],
        	[['DateCreated', 'DateModified', 'Raters', 'IsCommentEnabled', 'Status'], 'integer'],
        	[['PostID', 'CommunityID'], 'string', 'max' => 40],
        	[['Title', 'Slug'], 'string', 'max' => 255],
        	[['Author'], 'string', 'max' => 50],
        	[['Writer', 'Editor', 'CopyFrom'], 'string', 'max' => 20],
        	[['OutUrl'], 'string', 'max' => 200],
        	//[['Status'], 'default', 'value' => self::STATUS_PUBLISHED],
        	//[['Status'], 'in', 'range' => array_keys(self::getAvailableStatus()), 'message' => '文章的「状态」错误！'],
        	[['IsCommentEnabled'], 'default', 'value' => 1]
        ];
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PostID' => '文章ID',
            'Title' => '标题',
            'Slug' => '访问别名',
            'Description' => '摘要',
            'PostContent' => '正文',
        	'Writer' => '作者',
        	'Editor' => '编辑',
        	'CopyFrom' => '来源',
        	'OutUrl' => '外部链接',
            'Status' => '状态',
            'DateCreated' => '创建时间'
        ];
    }

    /**
     * 获得支持的文章状态
     * @return array
     */
    public static function getAvailableStatus()
    {
        return [
            self::STATUS_PUBLISHED => '1',
            self::STATUS_DRAFT => '0',
        	self::STATUS_DELETED => '2'
        ];
    }

    /**
     * 获得文章状态对应的名称
     * @param $status string
     * @return string|null
     */
    public static function getStatusName($status)
    {
    	$result = '';
    	if ($status == self::STATUS_PUBLISHED) {
    		$result = '已发布';
    	}
    	else if ($status == self::STATUS_DRAFT) {
    		$result = '草稿';
    	}
    	else if ($status == self::STATUS_DELETED) {
    		$result = '已删除';
    	}
        return $result;
    }

    /*
     * 获取文章状态名称
     * */
    public function getPostStatus()
    {
        return self::getStatusName($this->Status);
    }

    /**
     * 获得文章所属分类
     * @return string|null
     */
    public function getPostCategory()
    {
        $categories = Category::getAllCategories();
        
        $items = array();
        $item_array = Postcategory::findAll(['PostID'=>$this->PostID]);
    	foreach ($item_array as $item) {   		
    		$category = $categories[$item->CategoryID];   		
			array_push($items, $category); 
        }
        
        return $items;
    }
    
    /*
     * 根据分类名称获取文章列表
     * $_categoryName:分类名称
     * $_limit：获取记录数
     * $_offset：开始位置
     * */
    public static function getPostsByCategoryName($_categoryName, $_limit=null, $_offset=null)
    {
        //查找分类
        $category = Category::findOne(['CategoryName'=>$_categoryName]);
        if (!isset($category))
        	return [];
        
        //先查找postcategory表
        $subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $category->CategoryID]);
        
        return self::find()
        	->where(['in', 'PostID', $subQuery])->andWhere(['Status' => Post::STATUS_PUBLISHED])
        	->orderBy(['DateCreated' => SORT_DESC])
        	->offset($_offset)
        	->limit($_limit)->all();
    }

    /**
     * 获取文章访问的URL
     * @param bool $schema
     * @return null|string
     */
    public function getUrl($schema = false)
    {
        if ($this->isNewRecord)
            return null;
        
        if ($this->Slug)
            return Url::to(['/post/show', 'slug' => $this->Slug], $schema);
        else
            return Url::to(['/post/view', 'id' => $this->PostID], $schema);
    }

    /**
     * 获取文章中第一张图片为封面图片。
     * @return string
     */
    public function getCoverImage()
    {
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $this->PostContent, $matches);
        if (isset($matches[1][0]))
            return $matches[1][0];
        else
            return null;
    }

    /**
     * 获取关联的Post
     * 前一篇或者后一篇
     * @param $relation
     * @param bool $category 是否按同一分类获取上下文
     * @param bool $simple 是否采用简单模式获取上下文
     * @param bool $refresh 是否强制刷新缓存
     * @return Post
     */
    public function getRelatedOne($relation, $category = false, $simple = true, $refresh = false)
    {
        $relations = ['before' => '<', 'after' => '>'];
        $orders = ['before' => SORT_DESC, 'after' => SORT_ASC];
        if ($simple)
            $cache_key = "simple_post_{$relation}_{$this->id}";
        else
            $cache_key = "all_post_{$relation}_{$this->id}";
        
        $op = null;
        if (isset($relations[$relation]))
            $op = $relations[$relation];
        else
            return null;
        
        $one = Yii::$app->cache->get($cache_key);
        if ($refresh)
            $one = null;
        if ($one) {
            Yii::trace('从缓存中获取:' . $relation, 'Post');
            return $one;
        } else
            Yii::trace('从数据库中查询' . $relation, 'Post');
        
        $post = self::find()->where([$op, 'DateCreated', $this->createTime])
            ->andWhere(['Status' => self::STATUS_PUBLISHED])
            ->orderBy(['DateCreated' => $orders[$relation]]);
        if ($simple)
            $post->select('PostID,Title,Slug,Status');
        //if ($category) 暂时删除
        //    $post->innerJoin('ly_postcategory', 'ly_postcategory.PostID = PostID', ['CategoryID' => $this->]);
        $one = $post->one();

        $dp = new DbDependency();
        $dp->sql = (new Query())->select('MAX(DateModified)')->from(self::tableName())->createCommand()->rawSql;
        Yii::$app->cache->set( $cache_key, $one, 3600, $dp );
        
        return $one;
    }

    # Relationships
	/////
    public function getCategory()
    {
    	return $this->hasOne(Category::className(), ['CategoryID' => 'cid']);
    }
    
    /*public function getProfile()
    {
        return $this->hasOne(User::className(), ['UserName' => 'Author']);
    }
	
	
	 * public function getAllComments()
	 * {
	 * return $this->hasMany(Comment::className(), ['pid' => 'id'])->orderBy(['create_time' => SORT_ASC]);
	 * }
	 *
	 * public function getComments()
	 * {
	 * return $this->hasMany(Comment::className(), ['pid' => 'id'])
	 * ->onCondition(['status' => Comment::STATUS_APPROVED])
	 * ->orderBy(['create_time' => SORT_ASC]);
	 * }
	 *
	 * public function getPostTags()
	 * {
	 * return $this->hasMany(Tag::className(), ['pid' => 'id']);
	 * }
	 */

	#events
	
	/**
	 * 自动填写DateCreated、DateModified
	 * 新 Post 自动填写Author
	 * 
	 * @see CActiveRecord::beforeSave()
	 * @param bool $insert        	
	 * @return bool
	 */
	public function beforeSave($insert) {
		if (! parent::beforeSave($insert))
			return false;
			
		// 创建新Post
		if ($insert) {
		    $this->PostID = Uuid::uuid(); //创建文章序号
			$this->DateCreated = $this->DateModified = time();
		}
		
		// 编辑状态记录信息
		if (in_array( $this->scenario, [self::SCENARIO_EDIT,self::SCENARIO_MANAGE] ))
			$this->DateModified = time();
		
		if ($this->scenario === self::SCENARIO_MANAGE) {
			if ($this->isAttributeChanged('Author')) {
				if (! User::find()->where(['UserName' => 'Author'])->exists()) {
					$this->addError('author_id', '指定的用户(UID=' . $this->Author . ')不存在!' );
					$this->Author = $this->getOldAttribute('Author');
					return false;
				}
			}
		}
		
		// title安全修正，并生成文章URL别名
		$this->Title = htmlspecialchars( $this->Title );
		// 生成别名
		if (! $this->Slug)
			$this->Slug = $this->Title;
		$this->Slug = str_replace ( [ 
				' ',
				'%',
				'/',
				'\\' 
		], [ '-' ], trim ( $this->Slug ) );
		$this->Slug = strip_tags( $this->Slug );
		$this->Slug = htmlspecialchars( $this->Slug );
		
		// slug唯一性校验
		if (self::find()->where(['Slug' => $this->Slug])->andWhere(['not',['PostID' => $this->PostID]])->exists()) {
			$this->addError( 'Slug', '访问别名不能重复!' );
			return false;
		}
		
		// 生成并处理简介
		if (! $this->Description) {
			if ($this->Status == self::STATUS_PUBLISHED) {
				$this->Description = strip_tags ( $this->Description, '<p><ul><li><strong>' );
				$this->Description = XUtils::strimwidthWithTag ( $this->PostContent, 0, 350, '...' );
			}
		}
		$this->Description = str_replace ( ['<p></p>', '<p><br /></p>'], '', $this->Description );

		return true;
    }
}