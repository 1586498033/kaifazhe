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
            <?php include 'right.php';?>
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