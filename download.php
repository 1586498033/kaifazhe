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
