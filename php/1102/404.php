<?php 
require_once(dirname(__FILE__).'/include/config.inc.php'); 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>提示信息 - <?php echo $cfg_webname;?></title>
<meta name="keywords" content="<?php echo $cfg_keyword;?>" />
<meta name="description" content="<?php echo $cfg_description;?>" />
<meta name="wap-font-scale" content="no">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="/css/error.css" rel="stylesheet" type="text/css" />

</style>
</head>
<body>
<div id="container">
	<img class="png" src="/images/404.png" />
	<img src="/images/logo2.png" alt="">
	<img class="png msg" src="/images/404_msg.png" />
	<p>
		<a href="<?php echo $cfg_weburl;?>" class="btn">返回官网</a>
	</p>
</div>
<div id="cloud" class="png"></div>
</body>
</html>