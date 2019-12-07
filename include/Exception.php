<?php
class Exception {
	/* 属性 */
	protected $message ;
	protected $code ;
	protected $file ;
	protected $line ;
	/* 方法 */
	function __construct($message = null, $code = 0){}
	
	final function getMessage(){}
	final function getCode(){}
	final function getFile(){}
	final function getLine(){}
	final function getTrace(){}
	final function getTraceAsStrin(){}
	/* 可重载的方法 */
	function __toString (){}
}
?>