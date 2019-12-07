<!-- 联系我们 -->
<?php if($cid == 239){?>
	<div class="wp">
		<?php
		$dopage->GetPage("SELECT * FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' ORDER BY orderid DESC",100);
		$i = 1;
		while($row=$dosql->GetArray()){ 
		?> 
		<div class="m-contact">
			<div id="map<?php echo $i;?>" class="map"></div>
			<div class="txt">
				<?php echo $row['content'];?>               
			</div>
		</div>
		<?php $i++;} ?>
	</div>
	<!-- 地图 -->
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=700b132845ef5b0b135066dfa0222a37"></script>
	<?php
	$dopage->GetPage("SELECT * FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' ORDER BY orderid DESC",100);
	$i = 1;
	while($row=$dosql->GetArray()){ 
	?> 
	<script type="text/javascript">
		var map<?php echo $i;?> = new BMap.Map("map<?php echo $i;?>");
		var point<?php echo $i;?> = new BMap.Point(<?php echo $row['longitude'];?>,<?php echo $row['latitude'];?>);
		map<?php echo $i;?>.centerAndZoom(point<?php echo $i;?>,16);
		map<?php echo $i;?>.enableScrollWheelZoom(true);

		function changePos<?php echo $i;?>(pos){
			var icon<?php echo $i;?> = new BMap.Icon("images/ding.png", new BMap.Size(32,32));
			var marker<?php echo $i;?> = new BMap.Marker(pos,{icon:icon<?php echo $i;?>});
			map<?php echo $i;?>.addOverlay(marker<?php echo $i;?>);
			map<?php echo $i;?>.panTo(pos);
			var opts<?php echo $i;?> = {
			  width : 100,     // 信息窗口宽度
			  height: 26,     // 信息窗口高度
			  title : "<?php echo $row['title'];?>"
			}
			var infoWindow<?php echo $i;?> = new BMap.InfoWindow("地址：<?php echo $row['address'];?>", opts<?php echo $i;?>);  // 创建信息窗口对象 
			marker<?php echo $i;?>.addEventListener("click", function(){          
				map<?php echo $i;?>.openInfoWindow(infoWindow<?php echo $i;?>,point<?php echo $i;?>); //开启信息窗口
			});
		}
		changePos<?php echo $i;?>(point<?php echo $i;?>);
		$(window).resize(function() {
			changePos<?php echo $i;?>(point<?php echo $i;?>);
		});
	</script>
	<?php $i++;} ?>
<?php }else if($cid == 348){?> 
<div class="wp">
	<div class="m-news1">
		<div class="col-l">
			<div class="g-box2">
				<ul class="ul-list6-3">
					<?php 
					$dopage->GetPage("SELECT id,classid,linkurl,picurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC",5); 
					$num = $dosql->GetTotalRow();
					while($row=$dosql->GetArray()){ 
					?>
					<li>
						<div class="date">
							<span><?php echo date('d',$row['posttime']);?></span><?php echo date('m月',$row['posttime']);?><br><?php echo date('Y',$row['posttime']);?>
						</div>
						<div class="txt">
							<div class="pic">
								<a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?>><img src="<?php echo $row['picurl'];?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>"></a>
							</div>
							<h3><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?>><?php echo $row['title'];?></a></h3>
							<p><?php echo $row['description'];?></p>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php if($num){ echo $dopage->GetList(); }?>
			</div>
		</div>
	</div>
</div>
<?php }else{?>
<div class="wp">
	<div class="m-news1">
		<div class="col-l">
			<div class="g-box2">
				<ul class="ul-list6 ul-list6-2">
					<?php 
					$dopage->GetPage("SELECT id,classid,linkurl,picurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC",5); 
					$num = $dosql->GetTotalRow();
					while($row=$dosql->GetArray()){ 
					?>
					<li>
						<div class="date">
							<span><?php echo date('d',$row['posttime']);?></span><?php echo date('m月',$row['posttime']);?><br><?php echo date('Y',$row['posttime']);?>
						</div>
						<div class="txt">
							<div class="pic">
								<a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?>><img src="<?php echo $row['picurl'];?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>"></a>
							</div>
							<h3><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?>><?php echo $row['title'];?></a></h3>
							<p><?php echo $row['description'];?></p>
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php if($num){ echo $dopage->GetList(); }?>
			</div>
		</div>
		<div class="col-r">
			<div class="g-box2">
				<h3 class="g-tit2 g-tit2-2">搜索</h3>
				<form action="search.html" method="post" name="form" id="form" onSubmit="return checkSearch()">
					<div class="soBox">
						<input type="text" class="inp" placeholder="search" name="keywords" id="keywords" />
						<input type="hidden" name="id" value="1" />
						<input type="submit" class="sub" />
					</div>
				<form>
				<h3 class="g-tit2 g-tit2-2">相关新闻</h3>
				<ul class="ul-news">
					<!-- 读取推荐新闻 -->
					<?php 
					$dopage->GetPage("SELECT id,classid,linkurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' AND FIND_IN_SET('c',flag) ORDER BY posttime DESC",5); 
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
						<p><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?> title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></p>
						<p><?php echo $row['description'];?></p>
						<span class="date"><?php echo date('Y年m月d日', $row['posttime']);?></span>
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
<?php } ?> 
