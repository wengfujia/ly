<?php
namespace app\components\helper;

use yii;

use app\components\helper\httpHelper;
use app\components\coder\MsgEncoder;
use app\components\coder\MsgDecoder;

class httpServices
{
    
    /*
     * 获取网络包
     * */
    public static function getMsgEncoder($commandid, $username='', $body='')
    {
        $param = yii::$app->request->queryParams;
        //如果用户帐号为空，则从url参数中获取
    	if (empty($username)) {
			if (isset($param['username'])) {
				$username = $param['username'];
			}
			if (empty($username)) { //获取当前登录用户名
				$current_user = Yii::$app->user->identity;
				$username = $current_user->username;
			}
		}
    
        //组合网络包
        $encoder = new MsgEncoder();
        $encoder->setCommandID($commandid);
        $encoder->setUserName($username);
        $encoder->setPassWord('');
        if (empty($body)) {
            if (isset($param['body'])) {
                $encoder->setBody($param['body']);
            }
        }
        else {
        	$encoder->setBody($body);
        }
        //返回包结构
        return $encoder;
    }

    /*
     * 组合网络包并发送
     * 根据request参数，自动组合成网络包，并提交到服务端，返回接收的结果
     * */
    public static function post($commandid, $username='', $body='')
    {
        $encoder = self::getMsgEncoder($commandid, $username, $body);
        $content = $encoder->getResult();
        
        //从服务端获取数据
        $http = new httpHelper();
        $response = $http->postContent($content);
        //数据解码并返回
        $decoder = new MsgDecoder($response);
        return $decoder;
    }
    
}

?>