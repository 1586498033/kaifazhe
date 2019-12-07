<?php
class MyException extends Exception {
	function __construct($message,$code=0){
		parent::__construct($message,$code);	
	}
	
	//重写父类方法，自定义字符串输出样式
	function __toString(){
		return __CLASS__.":[".$this->code."]:".$this->message;	
	}
	
	//输出信息
	function Mess(){
		echo '信息不存在';
	}
}
?>