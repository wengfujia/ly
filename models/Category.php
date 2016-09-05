<?php

namespace app\models;

use Yii;
use app\components\BaseModel;
use yii\helpers\Url;
use yii\caching\DbDependency;
use yii\db\Query;

use Faker\Provider\Uuid;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $CategoryID 	分类ID
 * @property string $CategoryName 	分类名称
 * @property string $Description 	分类描述
 * @property string $ParentID		上级分类ID
 * @property integer $SortOrder 	排序号
 * @property integer $UpdateTime	更新时间
 * 
 * #用魔术方法获取的属性
 * @property string $url
 *
 * #relations
 * @property Category $parent
 * @property Category[] $children
 * @property Post[] $posts
 * @property Post[] $allPosts
 * @property integer $postCount
 */

class Category extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CategoryName'], 'required'],
            [['ParentID','Description'], 'string'],
            [['SortOrder'], 'integer'],
            [['CategoryName', 'Description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    		'CategoryName' => '名称',
    		'Description' => '描述',
    		'ParentID' => '上级分类',
    		'SortOrder' => '排序号'
    	];
    }
    
    /**
     * 父类
     * @return self
     */
    public function getParent()
    {
        return $this->CategoryID > 0 ? $this->hasOne(self::className(), ['CategoryID' => 'ParentID']) : null;
    }

    /*
     * 子类
     * @return self
     * */
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['ParentID' => 'CategoryID'])->orderBy(['SortOrder' => SORT_DESC]);
    }
	
    /*
     * 获取分类下的所有文章
     * */
    public function getAllPosts()
    {
		//先查找postcategory表
        $subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $this->CategoryID]);
		//获取分类在postcategory表中的文章
    	return $this->hasMany(Post::className(), ['in','PostID',$subQuery])->orderBy(['DateCreated' => SORT_DESC]);
    }
    
	/*
     * 获取分类下的已发布的文章
     * */
    public function getPosts()
    {
		//先查找postcategory表
        $subQuery = Postcategory::find()->select('PostID')->where(['CategoryID' => $this->CategoryID]);
		//获取分类在postcategory表中的文章
    	return $this->hasMany(Post::className(), ['in','PostID',$subQuery])->orderBy(['DateCreated' => SORT_DESC])
    	   ->where(['Status' => Post::STATUS_PUBLISHED])->orderBy(['DateCreated' => SORT_DESC]);
    }

    public function getPostCount()
    {
    	return Postcategory::find()
        	->where(['CategoryID' => $this->CategoryID])//->andWhere(['in', 'status', [Post::STATUS_PUBLISHED, Post::STATUS_HIDDEN]])
        	->count();
    }
    
    /**
     * 获取访问URL
     * @return string
     */
    public function getUrl()
    {
        if ($this->isNewRecord)
            return false;
        
        return Url::to(['/category/view', 'id' => $this->CategoryID], true);
    }

    /**
     * 获取所有的文章分类。
     * @param bool $refresh 强制刷新
     * @return array
     */
    public static function getAllCategories($refresh = false)
    {
        $cache_key = '__categories';
        if ($refresh)
            $items = [];
        else
            $items = Yii::$app->cache->get($cache_key);

        if (empty($items)) {
            $item_array = self::find()->select('CategoryID, CategoryName')->asArray()->all();
            if (empty($item_array))
                return [];
            foreach ($item_array as $item) {
                $items[$item['CategoryID']] = $item['CategoryName'];
            }
            $dp = new DbDependency();
            $dp->sql = (new Query())
                ->select('MAX(UpdateTime)')
                ->from(self::tableName())
                ->createCommand()->rawSql;
            Yii::$app->cache->set(
                $cache_key,
                $items,
                3600,
                $dp
            );
        }
        
        return $items;
    }

    /**
     * 获得分类概况
     * @param bool $refresh
     * @return mixed|null
     */
    public static function getCategorySummary($refresh = false)
    {
        $cache_key = '__category_summary';

        if ($refresh)
            $items = [];
        else
            $items = Yii::$app->cache->get($cache_key);

        if (empty($items)) {
            /* @var Category[] $item_array */
            $item_array = self::find()->all();
            if (empty($item_array))
                return [];

            foreach ($item_array as $item)
                $items[$item->CategoryID] = ['CategoryName' => $item->CategoryName, 'Description' => $item->Description, 'url' => $item->url, 'postCount' => $item->postCount];

            $dp = new DbDependency();
            $dp->sql = (new Query())
                ->select('MAX(UpdateTime)')
                ->from(self::tableName())
                ->createCommand()->rawSql;
            Yii::$app->cache->set(
                $cache_key,
                $items,
                3600,
                $dp
            );
        }
        
        return $items;
    }
    
    /**
     * 保存前检测父类ID是否是当前分类的子类
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
    	if (!parent::beforeSave($insert)) {
    		return false;
    	}
    
    	if ($this->ParentID != '') {
    		//插入模式即已有id。且父id不为空
    		if (!$insert) {
    			//父类ID不能是自身
    			if ($this->ParentID == $this->CategoryID) {
    				$this->ParentID = '';
    			} else {
    				//父类ID不能是自己的子类
    				if (self::find()->where(['CategoryID' => $this->parentId, 'ParentID' => $this->CategoryID])->exists()) {
    					$this->addError('parentId', '不合法的父类ID！');
    					return false;
    				}
    			}
    		}
    		//如果分类存在于上级分类中，则该分类的上级分类为空
    		if (self::find()->where(['ParentID' => $this->CategoryID])->exists()) {
    			$this->ParentID = '';
    		}
    	}
		if (!isset($this->CategoryID)) {
			$this->CategoryID = Uuid::uuid(); //uuid_create(); //创建分类序号
		}

    	//分类名称，并生成URL别名
    	$this->CategoryName = htmlspecialchars(strip_tags($this->CategoryName));
    	$this->UpdateTime = time();
    	
    	return true;
    }
    
    /**
     * 保存后检测，分类的父类是否是自己。
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
    	//防止预测ID插入脏数据
    	if ($insert && $this->ParentID == $this->CategoryID) {
    		$this->ParentID = '';
    		$this->save(false);
    	}
    	parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * 删除后将自分类提升至自己的父分类
     */
    public function afterDelete()
    {
    	parent::afterDelete();
    	self::updateAll(['ParentID' => $this->ParentID], ['ParentID' => $this->CategoryID]);
    }
    
}
