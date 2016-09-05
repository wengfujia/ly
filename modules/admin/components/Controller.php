<?php

namespace app\modules\admin\components;

use Yii;
use app\components\helper\httpServices;
use app\components\BaseController;

class Controller extends BaseController
{
    public $layout = 'main';

    public function init(){
    	parent::init();
    	$this->enableCsrfValidation = false;
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /*
     * 
     * 与服务端通讯函数
     * 组合网络包并发送
     * 根据request参数，自动组合成网络包，并提交到服务端，返回接收的结果
     * */
    protected function post($commandid, $username='', $body='') {
        $result = httpServices::post($commandid, $username, $body);
        return $result->getResult();
    }
    
}
