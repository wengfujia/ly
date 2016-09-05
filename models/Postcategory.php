<?php

namespace app\models;

use app\components\BaseModel;

/**
 * This is the model class for table "{{%postcategory}}".
 *
 * @property integer $PostCategoryID
 * @property string $PostID
 * @property string $CategoryID
 */
class Postcategory extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%postcategory}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PostID', 'CategoryID'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PostCategoryID' => 'Post Category ID',
            'PostID' => 'Post ID',
            'CategoryID' => 'Category ID',
        ];
    }
    
    /*
     * 获取文章
     * */
    public function getPost()
    {
    	return $this->hasOne(Post::className(), ['PostID' => 'PostID']);
    }
    
    /*
     * 获取查询query
     * */
    public static function getQuery($where)
    {
    	return self::find()->where($where);
    }
    
}
