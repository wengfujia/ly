<?php

namespace app\components\coder;

/**
 * 消息编码
 */
class MsgEncoder
{
    private $_commandid;
    private $_sessionid;
    private $_username;
    private $_password;
    private $_version;
    private $_body;
    
    function __construct()
    {
    	$this->_commandid = 0;
    	$this->_sessionid = '4';
    	$this->_username = '';
    	$this->_password = '';
    	$this->_version = '001';
    	$this->_body = '';
    }

    /*
     * 设置业务标识头
     * */
    public function setCommandID($CommandId)
    {
    	$this->_commandid = $CommandId;
    }
    
    /*
     * 设置用户名
     * */
    public function setUserName($UserName)
    {
    	$this->_username = $UserName;
    }
    
    /*
     * 设置密码
     * */
    public function setPassWord($PassWord)
    {
    	$this->_password = $PassWord;
    }
    
    /*
     * 设置消息体
     * */
    public function setBody($Body)
    {
    	if (empty($this->_body)) {
    		$this->_body = $Body;
    	}
    	else {
    		$this->_body = $this->_body.'	'.$Body; //\t进行分隔
    	}
    	return $this;
    }
    
    /*
     * 获取返回结果
     * */
    public function getResult()
    {
    	$result = array(
    			"commandid" => $this->_commandid,
    			"sessionid" => $this->_sessionid,
    			"username" => $this->_username,
    			"password" => md5($this->_password),
    			"version" => $this->_version,
    			"body" => $this->_body
    	);
    	
    	return json_encode($result);
    }
    
}
