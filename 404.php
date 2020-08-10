<?php 
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$error = '您访问的页面不存在！';
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
        <link href="<?php echo $cfg_weburl;?>css/error.css" rel="stylesheet" type="text/css" />
    </head>
<body>
    <div id="container">
        <img class="png" src="<?php echo $cfg_weburl;?>images/404.png" />
        <img src="<?php echo $cfg_weburl;?>images/logo2.png" alt="">
        <img class="png msg" src="<?php echo $cfg_weburl;?>images/404_msg.png" />
        <p>
            <!-- <a href="http://proclouds.cn/"><img class="png" src="images/404_to_index.png" /></a> -->
            <a href="<?php echo $cfg_weburl;?>" class="btn">返回官网</a>
            <a href="http://www.kaifazhe.site/" class="btn">网站建设</a>
            <a href="http://www.kaifazhe.site/" class="btn">APP定制开发</a>
        </p>
    </div>
    <div id="cloud" class="png"></div>
</body>
</html>