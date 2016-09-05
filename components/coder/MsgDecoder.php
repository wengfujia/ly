<?php

namespace app\components\coder;

/**
 * 消息解码
 */
class MsgDecoder
{
	/*
	 * 获取整 个返回结果
	 * */
    private $result;
    /*
     * 获取返回内容
     * */
    private $content=[];
    
    /*
     * 消息解码
     * */
    function __construct($message)
    {
    	$this->result = json_decode( $message, true );
    	$lines = $this->result['data'];
    	
    	//把\t分隔的字符串，分解成数组
    	//$this->$content = [];
    	foreach ($lines as $line)
    	{
    		$this->content[] =['content'=>explode('	', $line['content'])];
    	}
    	$this->result['data'] = $this->content;
    }
    
    /*
     * 获取JSON解码结果
     * */
    public function getResult() 
    {
    	return json_encode( $this->result );
    }
    
    /*
     * 获取内容数组集
     * */
    public function getContent() 
    {
    	return $this->content;
    }
    
    /*
     * 返回数组结果
     * */
    public function getResultArray() {
        return $this->result;
    }
}
