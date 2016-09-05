<?php

namespace app\components\helper;

use linslin\yii2\curl;

/*
 * http通讯类
 * http post
 * add by wfj 2016.3.28
 */

class httpHelper {
	
	private $rootUrl = 'http://192.168.3.225:9091/';
	
	/*
	 * post array
	 * $httpContent:
	 * array(
	 * 'commandid' => int,
	 * 'sessionid' => int,
	 * 'username' => string,
	 * 'password' => string,
	 * 'version' => string,
	 * 'body' => string
	 * )
	 */
	public function postContent($httpContent) {
		$curl = new curl\Curl ();
		
		$response = $curl->setOption ( CURLOPT_POSTFIELDS, $httpContent )->post ( $this->rootUrl );
		
		return $response;
	}
	
	/*
	 * post
	 * $commandid:消息标识号
	 * $sessionid:终端号
	 * $username:用户名
	 * $password:密码
	 * $version:版本号
	 * $body:消息体
	 */
	public function post($commandid, $sessionid, $username, $password, $version, $body) {
		$httpContent = json_encode(array (
				'commandid' => $commandid,
				'sessionid' => $sessionid,
				'username' => $username,
				'password' => md5($password),
				'version' => $version,
				'body' => $body 
			));
		
		return $this->postContent ( $httpContent );
	}
	
}