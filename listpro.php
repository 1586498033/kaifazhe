<?php if($cid == 232){?>
<div class="g-box">
	<div class="wp">
		<h3 class="g-tit1">行业成功案例</h3>
		<div class="m-tab1">
			<a href="list-232-1.html" class="on">全部</a>
			<a href="list-233-1.html">网站建设</a>
			<a href="list-234-1.html">手机端开发</a>
			<a href="list-346-1.html">公众号/小程序</a>
		</div>
		<ul class="list ul-list4">
			<?php
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE parentid=232 AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC");
			$i = 1;
			while($lists = $dosql->GetArray())
			{
				echo '
					<li>
						<div class="pic">
							<a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank"><img class="lazyimg" data-original="'.$lists['case_img'].'" alt="'.$lists['stitle'].'"></a>
						</div>
						<div class="txt">
							<h3><a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank">'.$lists['title'].'</a></h3>
							<p>'.$lists['stitle'].'</p>
						</div>
					</li>';
				$i++;
			}
			?>
		</ul>
	</div>
</div>
<?php }else if($cid == 233){?>
<div class="g-box">
	<div class="wp">
		<h3 class="g-tit1">行业成功案例</h3>
		<div class="m-tab1">
			<a href="list-232-1.html">全部</a>
			<a href="list-233-1.html" class="on">网站建设</a>
			<a href="list-234-1.html">手机端开发</a>
			<a href="list-346-1.html">公众号/小程序</a>
		</div>
		<ul class="list ul-list4">
			<?php
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC");
			$i = 1;
			while($lists = $dosql->GetArray())
			{
				echo '
					<li>
						<div class="pic">
							<a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank"><img class="lazyimg" data-original="'.$lists['case_img'].'" alt="'.$lists['stitle'].'"></a>
						</div>
						<div class="txt">
							<h3><a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank">'.$lists['title'].'</a></h3>
							<p>'.$lists['stitle'].'</p>
						</div>
					</li>';
				$i++;
			}
			?>
		</ul>
	</div>
</div>
<?php }else if($cid == 234){?>
<div class="g-box">
	<div class="wp">
		<h3 class="g-tit1">行业成功案例</h3>
		<div class="m-tab1">
			<a href="list-232-1.html">全部</a>
			<a href="list-233-1.html">网站建设</a>
			<a href="list-234-1.html" class="on">手机端开发</a>
			<a href="list-346-1.html">公众号/小程序</a>
		</div>
		<ul class="list ul-list4">
			<?php
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC");
			$i = 1;
			while($lists = $dosql->GetArray())
			{
				echo '
					<li>
						<div class="pic">
							<a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank"><img class="lazyimg" data-original="'.$lists['case_img'].'" alt="'.$lists['stitle'].'"></a>
						</div>
						<div class="txt">
							<h3><a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank">'.$lists['title'].'</a></h3>
							<p>'.$lists['stitle'].'</p>
						</div>
					</li>';
				$i++;
			}
			?>
		</ul>
	</div>
</div>
<?php }else if($cid == 346){?>
<div class="g-box">
	<div class="wp">
		<h3 class="g-tit1">行业成功案例</h3>
		<div class="m-tab1">
			<a href="list-232-1.html">全部</a>
			<a href="list-233-1.html">网站建设</a>
			<a href="list-234-1.html">手机端开发</a>
			<a href="list-346-1.html" class="on">公众号/小程序</a>
		</div>
		<ul class="list ul-list4">
			<?php
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC");
			$i = 1;
			while($lists = $dosql->GetArray())
			{
				echo '
					<li>
						<div class="pic">
							<a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank"><img class="lazyimg" data-original="'.$lists['case_img'].'" alt="'.$lists['stitle'].'"></a>
						</div>
						<div class="txt">
							<h3><a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank">'.$lists['title'].'</a></h3>
							<p>'.$lists['stitle'].'</p>
						</div>
					</li>';
				$i++;
			}
			?>
		</ul>
	</div>
</div>
<?php }?>