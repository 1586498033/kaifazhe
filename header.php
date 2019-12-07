<!-- 头部 -->
<div id="hd">
	<div class="top">
		<div class="wp">
			<a href="tel:<?php echo $cfg_hotline;?>" ><i class="iconfont icon-dianhua"></i>您身边的技术伙伴 <?php echo $cfg_hotline;?></a>
		</div>
	</div>
	<div class="header">
		<div class="wp">
			<div class="logo">
				<a href="<?php echo $cfg_weburl;?>"><img src="images/logo.png" alt="上海app|网站|公众号|小程序开发" title="上海app|网站|公众号|小程序开发" class="img1"><img src="images/logo1.png" alt="上海app|网站|公众号|小程序开发" title="上海app|网站|公众号|小程序开发" class="img2"></a>
			</div>
			<span class="menuBtn"></span>
			<span class="menuback"></span>
			<ul class="nav">
				<li class="<?php if($nid == 0){ echo 'on';}?>"><a href="<?php echo $cfg_weburl;?>" class="v1">首页</a></li>
				<?php
				$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE parentid=0 AND siteid = 1 AND checkinfo=true ORDER BY orderid ASC");
				while($row = $dosql->GetArray())
				{
					if($row['id'] == $nid){
						$class = 'on';
					}else{
						$class = '';
					}
					$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE parentid=".$row['id']." AND siteid = 1 AND checkinfo=true ORDER BY orderid ASC",$row['id']);
					$num = $dosql->GetTotalRow($row['id']);
					echo '<li class="'.$class.'"><a '.gourl($row['linkurl'],'list',$row['id']).' class="v1"><i class="iconfont icon-arrow-right"></i>'.$row['classname'].'</a>';
					if($num > 0){
						echo '<div class="con">';
							if(!empty($row['picurl'])){
								echo '<div class="pic">
										<img src="'.$row['picurl'].'" title="'.$row['classname'].'" alt="'.$row['classname'].'" />
									 </div>';
							}
							$n = 1; 
							echo '<dl>';
							while($rowb = $dosql->GetArray($row['id'])){
									echo '<dd><a '.gourl($rowb['linkurl'],'list',$rowb['id']).'><i class="iconfont icon-arrow-right"></i>'.$rowb['classname'].'</a></dd>';	
								if($n%4 == 0){
									echo '</dl><dl>';
								}
								$n++;
							}
							echo '</dl>';
						echo '</div>';
					}
					echo '</li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>