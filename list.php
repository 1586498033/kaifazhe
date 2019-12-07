<?php
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$cid =intval($cid);
if (empty($cid) ){
	$error="栏目不存在！";
	exit();
}
if (!empty($cid)){	
	$row = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='$cid'");
	if($row){
		$cbid=$row['parentid'];
		$nid=$row['parentid'];
		$infotype=$row['infotype'];
	}else{
		$infotype=0;
	}
}
$nid=empty($nid) ? $cid : $nid;
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <?php echo GetHeader(1,$cid);?>
        <link rel="stylesheet" type="text/css" href="css/cui.css" />
		<link rel="stylesheet" type="text/css" href="css/iconfont.css" />
		<link rel="stylesheet" type="text/css" href="css/slick.css" />
		<link rel="stylesheet" type="text/css" href="css/animate.min.css" />
		<link rel="stylesheet" type="text/css" href="css/lib.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/less.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
		<!--<script type="text/javascript" src="js/lib.js"></script>-->
    </head>
	<body>
	<?php include 'pid.php';?>
    <?php include 'header.php';?>
    <div id="ban1" style="background-image:url(images/ban.jpg)">
    	<div class="wp">
    	<h3 class="tit"><?php echo GetCatName($cid);?></h3>
	    	<div class="cur">
	    		<?php echo GetPosStr($cid);?>
	    	</div>
    	</div>
    </div>
	<?php
    #判断栏目类型 
    switch ($infotype){
        case 0:		
			require_once "page.php";
			break;			
        case 1:
            require_once 'listnews.php';
            break;
        case 2:		
			require_once "listpro.php";
            break;
		case 3:		
			require_once "download.php";
            break;			
        default:
            require_once "page.php" ;
            break;
    }
	include 'footer.php';
	?>
</body>
</html>