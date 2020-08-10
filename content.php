<?php 
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$id  = empty($id)  ? 0 : intval($id);
$cid = intval($_GET['cid']);
//根据栏目类型选择数据表
$data = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=$cid");
$infotype = $data['infotype'];
switch ($infotype){
	case 1:
		$sqlstrTable="infolist";
		break;
	case 2:
		$sqlstrTable="infoimg";
		break;
	default:
		$sqlstrTable="infolist";
		break;
}
//检测文档正确性
$row = $dosql->GetOne("SELECT * FROM `#@__$sqlstrTable` WHERE id=$id");
if(@$row)
	{
	//增加一次点击量
	$dosql->ExecNoneQuery("UPDATE `#@__$sqlstrTable` SET hits=hits+1 WHERE id=$id");
	$picurl=$row['picurl'];
	$ptitle= $row['title'];
	$ptime= MyDate('Y-m-d',$row['posttime']);
	$date = MyDate('d',$row['posttime']);
	$month= MyDate('m月',$row['posttime']);
	$year = MyDate('Y年',$row['posttime']);
	$hits = $row['hits'];
	$posttime= $row['posttime'];
	$pcontent=$row['content']? $row['content']:'内容更新中...';
	$cid=$row['classid'];
	if (!empty($cid)){	
		$row = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='$cid'");
		$cbid=$row['parentid'];
		$nid=$row['parentid'];
		$infotype=$row['infotype'];
	}
	$nid=empty($nid) ? $cid : $nid;
	if(empty($cbid)){
		$cbid=2;
	}
	$orderid=$row['orderid'];
}else{
	$error="文章不存在...";
	include "404.php" ;
	exit;
}
?>
<!doctype html>
<html>
    <head>
    	<meta charset="UTF-8">
        <?php //echo GetHeader(1,$cid,$id);?>
		<?php echo GetContentHeader(1,$cid,$id);?>
        <meta name="wap-font-scale" content="no" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" type="text/css" href="css/cui.css" />
		<link rel="stylesheet" type="text/css" href="css/iconfont.css" />
		<link rel="stylesheet" type="text/css" href="css/slick.css">
		<link rel="stylesheet" type="text/css" href="css/animate.min.css">
		<link rel="stylesheet" type="text/css" href="css/lib.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/less.css" />
		<script type="text/javascript" src="js/jquery.js"></script>
    </head>
	<body>
	<?php include 'pid.php';?>
    <?php include 'header.php';?>
    <div id="ban1" style="background-image:url(images/ban.jpg)">
    	<div class="wp">
    	<h3 class="tit"><?php echo GetCatName($cid);?></h3>
	    	<div class="cur">
	    		<?php echo GetPosStr($cid,$id);?>
	    	</div>
    	</div>
    </div>
    <div class="wp">
	    <!-- <div class="g-box2">
			<h3 class="g-tit1">新闻中心</h3>
		</div> -->
		<div class="m-news1">
			<div class="col-l">
				<div class="g-box2">
					<div class="m-article">
		    			<div class="date">
		    				<span><?php echo $date;?></span><?php echo $month;?><br><?php echo $year;?>
		    			</div>
		    			<div class="txt">
		    				<h1><?php echo $ptitle;?></h1>
		    				<div class="info">
		    					<span>来源：<?php echo $cfg_weburl;?></span>
		    					<span>作者：<a href="<?php echo $cfg_weburl;?>">林路同</a></span>
		    					<span>点击：<?php echo $hits;?></span>
		    					<span>发表时间：<?php echo $ptime;?></span>
		    				</div>
		    				<?php 
								if(!empty($picurl)){
									echo '<p style="margin:20px auto; text-align:center;"><img src="'.$picurl.'" alt="'.$ptitle.'" title="'.$ptitle.'" /></p>';
								}
								?>
							<div class="con">
								<?php echo $pcontent;?>
							</div>
							<div style="margin-bottom:25px;"></div>
							<!-- 上一篇 下一篇 -->   
							<?php
							//echo '<ul style="margin: 25px 0px;>';
							$prev = $dosql->GetOne("SELECT * FROM `#@__".$sqlstrTable."` WHERE classid=".$cid." AND id > ".$id." AND delstate='' AND checkinfo=true");
							
							if($prev){   
								echo '<p style="margin-bottom:5px;">上一篇：<a '.gourl($prev['linkurl'],'content',$prev['classid'],$prev['id']).'>'.ReStrLen($prev['title'],45).'</a></p>';
							}
							
							$next = $dosql->GetOne("SELECT * FROM `#@__".$sqlstrTable."` WHERE classid=".$cid." AND id < ".$id." AND delstate='' AND checkinfo=true order by id desc");
							if($next){   
								echo '<p>下一篇：<a '.gourl($next['linkurl'],'content',$next['classid'],$next['id']).'>'.ReStrLen($next['title'],45).'</a></p>';
							}
							//echo '</ul>';?>
		    			</div>
		    		</div>
				</div>
			</div>
            <?php include 'right.php';?>
		</div>
	</div>
    <?php include 'footer.php';?>
</body>
</html>