<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $username
 * @property string $contact
 * @property string $qq
 * @property string $content
 * @property integer $datecreated
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['title', 'username', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['username', 'qq'], 'string', 'max' => 20],
            [['contact'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'username' => '联系人',
            'contact' => '联纱方式',
            'qq' => 'Qq',
            'content' => '反馈内容',
        ];
    }
}
