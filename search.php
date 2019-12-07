<?php 
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$cid = 2;
$id  = empty($id)  ? 0 : intval($id);
$keywords = isset($keywords) ? htmlspecialchars($keywords):'';
if(!empty($keywords)){
	$map = " AND title like '%". $keywords ."%' OR keywords like '%". $keywords ."%' OR description like '%". $keywords ."%'";
}
switch($id){
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
	<div class="wp">
		<div class="m-news1">
			<div class="col-l">
				<div class="g-box2">
					<ul class="ul-list6 ul-list6-2">
						<?php 
						$dopage->GetPage("SELECT id,classid,linkurl,picurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' ".$map." ORDER BY posttime DESC",50); 
						$num = $dosql->getTotalRow();
						if($num){
							while($row=$dosql->GetArray()){ 
							?>
							<li>
								<div class="date">
									<span><?php echo date('d',$row['posttime']);?></span><?php echo date('m月',$row['posttime']);?><br><?php echo date('Y',$row['posttime']);?>
								</div>
								<div class="txt">
									<div class="pic">
										<a href=""><img src="<?php echo $row['picurl'];?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>"></a>
									</div>
									<h3><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?>><?php echo $row['title'];?></a></h3>
									<p><?php echo $row['description'];?></p>
								</div>
							</li>
							<?php } ?>
						<?php }else{
							echo '<li>没有找到您要搜索的内容，换一个关键词吧！</li>';
						}?>
					</ul>
					<?php //echo $dopage->GetList();?>
				</div>
			</div>
			<div class="col-r">
				<div class="g-box2">
					<h3 class="g-tit2 g-tit2-2">搜索</h3>
					<form action="search.html" method="post" name="form" id="form" onSubmit="return checkSearch()">
						<div class="soBox">
							<input type="text" class="inp" placeholder="search" name="keywords" id="keywords" value="<?php echo @$keywords;?>" />
							<input type="hidden" name="id" value="1" />
							<input type="submit" class="sub" />
						</div>
					<form>
					<h3 class="g-tit2 g-tit2-2">相关新闻</h3>
					<ul class="ul-news">
						<!-- 读取推荐新闻 -->
						<?php 
						$dopage->GetPage("SELECT id,classid,linkurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' AND FIND_IN_SET('c',flag) ORDER BY posttime DESC",5); 
						while($row=$dosql->GetArray()){ 
						?>
							<li><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?> title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></li>
						<?php } ?>
					</ul>
					<h3 class="g-tit2 g-tit2-2">标签</h3>
					<ul class="ul-tags">
						<li><a href="http://www.proclouds.cn/seo" target="_blank">seo</a></li>
						<li><a href="http://www.proclouds.cn/list-2-1.html" target="_blank">新闻</a></li>
						<li><a href="http://www.proclouds.cn/list-1-1.html" target="_blank">网站建设</a></li>
						<li><a href="http://www.proclouds.cn/live" target="_blank">直播</a></li>
						<li><a href="http://www.procloud.cn/" target="_blank">app</a></li>
						<li><a href="http://www.procloud.cn/p2p" target="_blank">p2p</a></li>
					</ul>
					<h3 class="g-tit2 g-tit2-2">最新动态</h3>
					<ul class="ul-dynamic">
						<?php 
						$dopage->GetPage("SELECT id,classid,linkurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' AND FIND_IN_SET('n',flag) ORDER BY posttime DESC",2); 
						while($row=$dosql->GetArray()){ 
						?>
						<li>
							<p><?php echo $row['description'];?></p>
							<a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?> title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a>
							<span class="date"><?php echo date('m月d日', $row['posttime']);?></span>
						</li>
						<?php } ?>
					</ul>
					<h3 class="g-tit2 g-tit2-2">关于我们</h3>
					<div class="m-about">
						<p>我们致力于网站建设、软件开发、手机应用开发等服务。我们坚持"智慧沟通，高效执行"的管理服务理念，已为10000+客户提供网站建设、100＋客户提供软件开发、100+客户提供手机应用开发服务。希望成为企业发展的技术伙伴。</p>
					</div>
				</div>
			</div>
		</div>
		<script language="javascript">
		function checkSearch(){
			if(document.form.keywords.value == ""){
				alert("请输入搜索关键字");
				return false;
			}
			return true;
		}
		</script>
		
	</div>
	<?php
	include 'footer.php';
	?>
</body>
</html>