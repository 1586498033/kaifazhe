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
	
	$case_img=$row['case_img'];
	$case_bimg=$row['case_bimg'];
	$case_video=$row['case_video'] ? $row['case_video'] : '';
	$ptitle= $row['title'];
	$stitle= $row['stitle'];
	$ptime= MyDate('Y年m月d日',$row['posttime']);
	$pcontent=$row['content']? $row['content']:'内容更新中...';
	$tag=$row['tag'];
	$cid=$row['classid'];
	if (!empty($cid)){	
		$row1 = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id='$cid'");
		$cbid=$row1['parentid'];
		$nid=$row1['parentid'];
		$infotype=$row1['infotype'];
	}
	$nid=empty($nid) ? $cid : $nid;
	if(empty($cbid)){
		$cbid=232;
	}
	
	$picarr = unserialize($row['picarr']);
	$picarr_list = array();
	if($picarr){
		foreach($picarr as $k)
		{
			$v = explode(',', $k);
			$picarr_list[] = $v;
		}
	}
	
}else{
	$error="文章不存在...";
	exit;
}
?>
<!doctype html>
<html>
    <head>
    	<meta charset="UTF-8">
        <?php echo GetHeader(1,$cid,$id);?>
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
    	<h3 class="tit">案例详情</h3>
	    	<div class="cur">
	    		<?php echo GetPosStr($cid,$id);?>
	    	</div>
    	</div>
    </div>
	<div class="g-box">
		<div class="wp">
		    <div class="m-detail ovh">
		    	<div class="pic">
		    		<div class="load"></div>
		    		<?php if(!empty($case_video)){?>
					<video poster="<?php echo $case_img;?>" controls="controls">
					    <source src="<?php echo $case_video;?>" type="video/mp4" />
					    您的浏览器不支持 video 标签。
					</video>
					<?php } ?>
		    		<?php 
					if($cid == 343){
						foreach($picarr_list as $v){
							echo '<img src="'.$v[0].'" alt="'.$v[1].'" title="'.$v[0].'"/>';
						}
					}else{
						echo '<img src="'.$case_bimg.'" alt="'.$ptitle.'" title="'.$ptitle.'"/>';
					}
					?>
		    	</div>
		    	<div class="txt">
		    		<div class="intro">
		    			<h3><?php echo $ptitle;?></h3>
		    			<div><?php echo $pcontent;?></div>
		    		</div>
		    		<div class="info">
		    			<h3><?php echo $stitle;?></h3>
		    			<ul>
		    				<li>
		    					<span>上架日期</span>
		    					<p><?php echo $ptime;?></p>
		    				</li>
		    				<li>
		    					<span>标签</span>
		    					<p>
		    						<?php 
									$tags = explode(',',$tag);
									foreach($tags as $v){
										echo '<em>'.getTag($v).'</em>';
									}
									?>
		    					</p>
		    				</li>
		    			</ul>
		    		</div>
		    		<a href="tencent://message/?uin=1586498033&Site=www.procloudwh.com&Menu=yes" class="g-btn1 more"><i class="iconfont icon-tubiaozhizuomoban1"></i>点击联系我们</a>
		    	</div>
		    </div>
	    </div>
    </div>
    <script>
		var case_img=$(".m-detail .pic img");
		if (case_img[0].complete) {
			$(".m-detail .pic .load").delay(300).fadeOut();
		}
		case_img.load(function() {
			$(".m-detail .pic .load").delay(300).fadeOut();
		});
	</script>
	<?php include 'footer.php';?>
</body>
</html>