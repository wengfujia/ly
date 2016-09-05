<?php

namespace app\modules\wap;

use Yii;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use app\models\User;
use app\modules\admin\models\Log;

/**
 * Class Module
 * @package app\modules\admin
 * @property string $version
 */
class Module extends Yii\base\Module
{
    public $name = 'WAP站点';
    public $_version = 'v0.0.1';
    public $controllerNamespace = 'app\modules\wap\controllers';
    public $allowedIPs;
    /**
     * 允许访问的角色
     * @var array
     */
    public $allowRoles = [User::ROLE_ADMIN];
    /**
     * 允许直接访问的路由
     * @var array
     */
    public $excludedRoute = [];

    public function init()
    {
        parent::init();
        Yii::setAlias('@wap', __DIR__);
        if (!is_array($this->excludedRoute)) {
            Yii::trace('AdminModule.excludedRoute配置错误', 'Config');
            $this->excludedRoute = [];
        }
    }

    /**
     * @inheritdoc
     */
    /*public function beforeAction($action)
    {
        $route = Yii::$app->controller->id . '/' . $action->id;

        if (!$this->checkAccess($route))
            throw new ForbiddenHttpException('需要登录');

        if (!$this->checkRole())
            throw new ForbiddenHttpException('当前角色没有访问该模块的权限。');

        return parent::beforeAction($action);
    }*/

    /**
     * @todo IP校验
     * @param $route
     * @return bool
     */
    /*protected function checkAccess($route)
    {
        if (in_array($route, $this->excludedRoute))
            return true;

        if (Yii::$app->user->isGuest)
            return false;
        else
            return true;
    }*/

    /**
     * 访问角色
     * @return bool
     */
    /*protected function checkRole()
    {

        // @var User $current_user 
        $current_user = Yii::$app->user->identity;
        if (!is_array($this->allowRoles))
            return false;

        if (in_array('*', $this->allowRoles))
            return true;

        if (in_array($current_user->role, $this->allowRoles))
            return true;

        1 or Log::record([
                'uid' => Yii::$app->user->id,
                'type' => Log::TYPE_PERMISSION_DENY,
                'action' => Url::current(),
                'detail' => "用户[ {$current_user->username} ]以[ {$current_user->role} ]权限访问「{$this->name}」模块被拒绝。访问URL:" . Yii::$app->request->absoluteUrl
            ]
        );

        return false;
    }*/

    /**
     * 获得版本号
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }
}
