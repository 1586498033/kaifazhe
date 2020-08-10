<div class="wp">
	<div class="m-news1">
		<div class="col-l">
			<div class="g-box2">
				<ul class="app-lists ul-list6 ul-list6-2">
                    <a <?php echo gourl('','solutionDetail',333,10000);?> target="_blank">
                        <li>
                            <h3 class="name">
                                linux服务器升级php56到php71/php72
                                <span>时间：2019年12月15号</span>
                            </h3>
                        </li>
                    </a>
				</ul>
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
