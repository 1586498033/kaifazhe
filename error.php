<?php 
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$error = $error ? $error : '您访问的页面不存在！';
?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <title>提示信息 - <?php echo $cfg_webname;?></title>
    <meta name="keywords" content="<?php echo $cfg_keyword;?>" />
    <meta name="description" content="<?php echo $cfg_description;?>" />
    <link href="css/error.css" rel="stylesheet" type="text/css" />
    </head>
<body>
    <div id="container">
        <img class="png" src="images/404.png" />
        <img class="png msg" src="images/404_msg.png" />
        <p><a href="http://www.kaifazhe.site/"><img class="png" src="images/404_to_index.png" /></a> </p>
    </div>
    <div id="cloud" class="png"></div>
</body>
</html>