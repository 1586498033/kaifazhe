<?php
header('X-Frame-Options: deny');
require_once(dirname(__FILE__).'/common.inc.php');
require_once(PHPMYWIND_INC.'/func.class.php');

require_once(PHPMYWIND_INC.'/page.class.php');
require_once(PHPMYWIND_INC.'/month.class.php');
require_once(PHPMYWIND_INC.'/RedisPackage.class.php');

if(!defined('IN_PHPMYWIND')) exit('Request Error!');

if($cfg_webswitch == 'N')
{
	echo $cfg_switchshow.'<br /><br /><i>'.$cfg_webname.'</i>';
	exit();
}
?>