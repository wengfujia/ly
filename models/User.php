<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use app\components\BaseModel;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property integer $id
 * @property string $community_id
 * @property string $nickname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role
 * @property integer $status
 * @property string $auth_key
 * @property integer $login_time
 * @property integer $register_time
 * @property integer active_time
 *
 * #getter
 * @property string $userStatus
 * @property string $userRole

 */

class User extends BaseModel implements IdentityInterface
{

    const STATUS_NORMAL = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_BANED = 4;
    const STATUS_DELETED = 8;

    const SCENARIO_REGISTER = 'register';
    const SCENARIO_MODIFY_PROFILE = 'modify_profile';
    const SCENARIO_MODIFY_PWD = 'modify_password';
    const SCENARIO_MANAGE = 'manage';

    const ROLE_MEMBER = 1;
    const ROLE_EDITOR = 8;
    const ROLE_ADMIN = 16;

    /**
     * 黑名单
     * @var string[]
     */
    public $nameBlackList = ['admin'];

    public $password_repeat;

    public $captcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'password', 'email', 'password_repeat', 'role', 'nickname'];
        $scenarios[self::SCENARIO_MODIFY_PROFILE] = ['community_id'];
        $scenarios[self::SCENARIO_MANAGE] = ['nickname', 'username', 'email', 'role', 'status'];
        $scenarios[self::SCENARIO_MODIFY_PWD] = ['password'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
    	return [
    			[['username', 'email'], 'unique', 'message' => '{attribute} 已经存在，请重新输入。'],
    			[['status', 'login_time', 'register_time'], 'integer'],
    			[['community_id', 'password', 'email'], 'string', 'max' => 40],
    			[['username'], 'string', 'max' => 36],
    			[['nickname'], 'string', 'max' => 50],
    			[['role'], 'string', 'max' => 20],
    			[['username', 'email', 'nickname'], 'required'],
    			[['status'], 'default', 'value' => self::STATUS_NORMAL],
    			[['password', 'password_repeat'], 'string', 'min' => 8, 'max' => 20, 'on' => self::SCENARIO_REGISTER],
    			[['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_REGISTER],
    			['password_repeat', 'compare', 'compareAttribute' => 'password', 'operator' => '===', 'message' => '两次密码输入不一致。', 'on' => self::SCENARIO_REGISTER],
    			// verifyCode needs to be entered correctly
    			['verifyCode', 'captcha','captchaAction'=>'admin/account/captcha'],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    			'id' => '用户 ID',
    			'community_id' => '社区ID',
    			'username' => '用户名',
    			'password' => '密　码',
    			'email' => '电子邮箱',
    			'role' => '用户角色',
    			'status' => '用户状态',
    			'auth_key' => '授权代码',
    			'login_time' => '登录时间',
    			'register_time' => '注册时间',
    			'active_time' => '活动时间',
    			'password_repeat' => '确认密码',
    	];
    }
    
    /**
     * 获得支持的所有角色
     * @return array
     */
    /*public static function getAvailableRole()
    {
        return [
        	self::ROLE_EDITOR => '新闻账号',
            self::ROLE_MANAGER => '社区账号',
            self::ROLE_ADMIN => '街道账号'
        ];
    }*/

    /**
     * 获得用户角色对应的名称
     * @param $role
     * @return null|string
     */
    /*public static function getRoleName($role)
    {
        $items = self::getAvailableRole();
        return isset($items[$role]) ? $items[$role] : null;
    }

    public function getUserRole()
    {
        $items = self::getAvailableRole();
        if (isset($items[$this->role]))
            return $items[$this->role];
        else
            return '异常角色';
    }*/

	public function getRole()
	{
      	return $this->role;
	}
        
    /**
     * 是否是管理员
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }

    /**
     * 是否是会员
     * @return bool
     */
    public function isMember()
    {
        return $this->role == self::ROLE_MEMBER;
    }

    /**
     * 是否是编辑
     * @return bool
     */
    public function isEditor()
    {
        return $this->role == self::ROLE_EDITOR;
    }

    /**
     * 获得支持的所有状态值
     * @return string[]
     */
    public static function getAvailableStatus()
    {
        return [
            self::STATUS_NORMAL => '正常',
            self::STATUS_INACTIVE => '未激活',
            self::STATUS_BANED => '账号被禁用',
            self::STATUS_DELETED => '已删除'
        ];
    }

    /**
     * 获得用户状态对应的名称
     * @param $status
     * @return null|string
     */
    public static function getStatusName($status)
    {
        $statuses = self::getAvailableStatus();
        return isset($statuses[$status]) ? $statuses[$status] : null;
    }

    public function getUserStatus()
    {
        $status = self::getAvailableStatus();
        if (isset($status[$this->status]))
            return $status[$this->status];
        else
            return '异常状态';
    }

    /**
     * 用户状态是否正常
     * @return bool
     */
    public function isNormal()
    {
        return $this->status == self::STATUS_NORMAL;
    }

    /**
     * 用户是否被禁止登录
     * @return bool
     */
    public function isBaned()
    {
        return $this->status == self::STATUS_BANED;
    }

    /**
     * 用户是否被删除
     * @return bool
     */
    public function isDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }

    /**
     * 用户是否是未激活状态
     * @return bool
     */
    public function isInactive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }
    
    /**
     * 保存前校验补充数据
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert))
            return false;
        
        if ($this->isNewRecord) {
            $this->register_time = time();
            $this->generateAuthKey();
            $this->status = self::STATUS_NORMAL;
        }
        //注册黑名单
        if (in_array($this->username, $this->nameBlackList))
            $this->addError('username', '该用户名不能被注册！');

        if (in_array($this->nickname, $this->nameBlackList))
            $this->addError('nickname', '该昵称不能被注册！');

        if (in_array($this->scenario, [self::SCENARIO_REGISTER, self::SCENARIO_MODIFY_PWD]))
            $this->password = $this->hashPassword($this->password);
        //管理员更改用户数据不修改活动时间
         if ($this->scenario !== self::SCENARIO_MANAGE)
          	$this->active_time = time();
            
        if($this->hasErrors())
            return false;
        else
            return true;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_NORMAL,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * 加密密码
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = base64_encode(Yii::$app->security->generateRandomKey());
    }

}
