<?php

require_once(dirname(__FILE__).'/common.inc.php');

require_once(PHPMYWIND_INC.'/func.class.php');
if(!defined('IN_PHPMYWIND')) exit('Request Error!');

//网站开关
if($cfg_webswitch == 'N')
{
	echo $cfg_switchshow.'<br /><br /><i>'.$cfg_webname.'</i>';
	exit();
}
?>