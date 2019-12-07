<div class="wp">
	<div class="m-news1">
		<div class="col-l">
			<div class="g-box2">
				<ul class="app-lists ul-list6 ul-list6-2">
                    <?php
					$dopage->GetPage("SELECT * FROM `#@__soft` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC",8);
					$num = $dosql->GetTotalRow();
					while($row=$dosql->GetArray()){
					?>
					<li>
                        <h3 class="name">
                            <?php echo $row['title'];?>
                            <span>
                                <i class="fa fa-eye"></i>
                                浏览：<?php echo $row['hits'];?>次
                            </span>
                            <span>
                                <i class="fa fa-arrow-circle-down"></i>
                                下载：<?php echo $row['downloads'];?>次
                            </span>
							<span>时间：<?php echo date('Y.m.d', $row['posttime']);?></span>
                        </h3>
                        <p>
                            
                            <a href="<?php echo $row['dlurl'];?>" data-id="<?php echo $row['id']?>"><button class="download-btn">下载</button></a>
                        </p>
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
	//增加一次下载
	$(function(){
		$(".app-lists a").click(function(){
			var dowloadId = $(this).attr('data-id');
			//alert(dowloadId);
			$.post('ajax_do.php', {'action':'dowload','dowloadId':dowloadId},function(data){
				return true;
			},'json');
		});
		
	})
	</script>
</div> 
