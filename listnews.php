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
<?php } ?> 
