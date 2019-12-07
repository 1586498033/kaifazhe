<?php
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$nid = 0;
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<?php echo GetHeader();?>
	<meta name="wap-font-scale" content="no">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" type="text/css" href="css/cui.css" />
	<link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_1551048_lnlroknval.css" />
	<link rel="stylesheet" type="text/css" href="css/iconfont.css" />
    <link rel="stylesheet" href="css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="css/slick.css">
	<link rel="stylesheet" type="text/css" href="css/animate.min.css">
	<link rel="stylesheet" type="text/css" href="css/lib.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/less.css" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_856365_tkd971kf5i9.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<meta name="baidu-site-verification" content="cmRAkry3Rm" />
</head>
<body>    
	<?php include 'header.php';?>
    <div id="banner">
    	<?php
		$dosql->Execute("SELECT title,picurl,linkurl FROM `#@__admanage` WHERE classid=1 AND checkinfo=true ORDER BY orderid ASC");
		while($row = $dosql->GetArray())
		{
			$linkurl = !empty($row['linkurl'])? $row['linkurl']:'javascript:;';
		?>
		<div class="item">
    		<a href="<?php echo $linkurl;?>"><img src="<?php echo $row['picurl'];?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>" /></a>
    	</div>
		<?php } ?>
    </div>
	<div class="g-box">
		<div class="wp ovh">
		    <h3 class="g-tit1">网站设计及开发</h3>
		    <p class="m-info">路同软件是领先的企业级网站构建者，从策划、IA信息架构设计、视觉创意设计到前后台技术开发及售后维护，拥有过百人网站开发专业团队。 路同软件一直贯彻"智慧沟通，高效执行"的管理服务理念，只为更好的提供网站建设解决方案。</p>
		    <ul class="list ul-list1">
		    	<li class="wow fadeInUp" data-wow-duration="1s">
					<h3><a href="javascript:;"><i class="iconfont icon-weixin"></i>微信公众号开发</a></h3>
					<p>微网站、微商城、微社交为客户用户提供一站式服务，抢占微信社交红利</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
					<h3><a href="javascript:;"><i class="iconfont icon-xiaochengxu"></i>小程序一站式开发</a></h3>
					<p>也许您的淘宝店铺月销售额破万，更也许您在繁华路段的店铺生意火爆。然而谁都抵挡不了互联网在线购物浪潮。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
					<h3><a href="javascript:;"><i class="iconfont icon-app"></i>APP一站式开发</a></h3>
					<p>拓展人脉、增加与陌生人的互动，对企业来说，用社交网络，可以扩大自己的消费群体，向更多的人宣传自己的产品。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s">
					<h3><a href="list-278-1.html"><i class="iconfont icon-1"></i>展示型网站</a></h3>
					<p>无论您是个人摊贩还是世界级工业巨头，您都需要一个良好视觉体验的网站来让新的客户从茫茫人海中找到您。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
					<h3><a href="list-279-1.html"><i class="iconfont icon-gouwuche"></i>购物商城网站</a></h3>
					<p>也许您的淘宝店铺月销售额破万，更也许您在繁华路段的店铺生意火爆。然而谁都抵挡不了互联网在线购物浪潮。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
					<h3><a href="list-280-1.html"><i class="iconfont icon-1"></i>社交论坛网站</a></h3>
					<p>拓展人脉、增加与陌生人的互动，对企业来说，用社交网络，可以扩大自己的消费群体，向更多的人宣传自己的产品。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.9s">
					<h3><a href="list-281-1.html"><i class="iconfont icon-ticket2"></i>旅游预订网站</a></h3>
					<p>依托互联网，以满足旅游消费者查询、预定及服务评价为核心，如今在线旅游平台的新产业正处于快速上升期。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.2s">
					<h3><a href="list-282-1.html"><i class="iconfont icon-tubiaozhizuomoban"></i>金融交易网站</a></h3>
					<p>2015年全国网贷成交额突破万亿，达到11805.65亿，同比增长258.62%，互联网金融发展迅猛。</p>
				</li>
				<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.5s">
					<h3><a href="list-283-1.html"><i class="iconfont icon-xiangyingshi"></i>HTML5自适应网站</a></h3>
					<p>无论是去年10月底的规范定稿，还是今年年初惊爆业内的微信开放JS SDK，亦或是腾讯、百度、360、搜狐等互联网巨头之间的布局争夺。</p>
				</li>
		    </ul>
	    </div>
    </div>
    <div class="g-box" style="background-image:url(images/bg4.jpg);">
    	<div class="wp">
	    	<h3 class="g-tit1 g-tit1-1">创造人性化的服务体验</h3>
	    	<ul class="list ul-list2">
	    		<li class="wow fadeInUp" data-wow-duration="1s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img6.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>需求收集</p>
		    					<p>Demand collection</p>
	    					</div>
	    				</div>
	    			</div>
	    		</li>
	    		<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img7.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>原型构思</p>
		    					<p>Prototype Conception</p>
		    				</div>
	    				</div>
	    			</div>
	    		</li>
	    		<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img8.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>网页设计</p>
		    					<p>Web Design</p>
		    				</div>
	    				</div>
	    			</div>
	    		</li>
	    		<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.9s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img9.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>前端特效</p>
		    					<p>Front-end effects</p>
		    				</div>
	    				</div>
	    			</div>
	    		</li>
	    		<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.2s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img10.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>功能开发</p>
		    					<p>Functional development</p>
		    				</div>
	    				</div>
	    			</div>
	    		</li>
	    		<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.5s">
	    			<div class="con">
	    				<img class="lazyimg" data-original="images/img11.jpg" alt="武汉网站建设" title="武汉网站建设">
	    				<div class="mask">
	    					<div class="txt">
		    					<p>测试上线</p>
		    					<p>Test on-line</p>
		    				</div>
	    				</div>
	    			</div>
	    		</li>
	    	</ul>
    	</div>
    </div>
    <div class="g-box">
    	<div class="wp">
	    	<div class="m-case ovh">
	    		<div class="pic wow fadeInLeft" data-wow-duration="1.5s">
	    			<img class="lazyimg" data-original="images/img12.png" alt="武汉网站建设" title="武汉网站建设">
	    		</div>
	    		<div class="txt">
	    			<h2 class="wow fadeInDown" data-wow-duration="1.5s">移动应用开发</h2>
	    			<ul>
	    				<li class="wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="0.5s">
	    					<div class="icon"><i class="iconfont icon-pingguo"></i></div>
	    					<div class="con">
	    						<h3><a href="">APP IOS 手机应用开发</a></h3>
	    						<p>当前正是在 Apple 平台上进行开发的绝佳时机。适用于Apple TV、Apple Watch、iPhone、iPad 和 Mac 的新一代应用提供助力的新技术。</p>
	    					</div>
	    				</li>
	    				<li class="wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1s">
	    					<div class="icon"><i class="iconfont icon-android"></i></div>
	    					<div class="con">
	    						<h3><a href="">Android 安卓手机应用开发</a></h3>
	    						<p>Android是一种基于Linux的自由及开放源代码的操作系统，主要使用于移动设备，如智能手机和平板电脑，由Google公司和开放手机联盟领导及开发。</p>
	    					</div>
	    				</li>
	    				<li class="wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1.5s">
	    					<div class="icon"><i class="iconfont icon-winxin"></i></div>
	    					<div class="con">
	    						<h3><a href="">微信公众号、小程序开发</a></h3>
	    						<p><label class="red">微信公众号</label>开发，将信息、服务、活动等内容通过网页的方式进行表现，用户通过简单的设置，就能生成微信网站。将企业品牌展示给用户，减少宣传成本，建立企业与消费者、客户的一对一互动和沟通，将消费者接入CRM系统，进行促销、推广、宣传、售后等。形成了一种主流的线上线下互动营销方式。<label class="red">小程序</label>是一种新的开放能力，开发者可以快速地开发一个小程序。小程序可以在微信内被便捷地获取和传播，同时具有出色的使用体验。</p>
	    					</div>
	    				</li>
	    			</ul>
	    			<div class="wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="2s">
		    			<a href="list-240-1.html" class="g-btn1 btn">更多服务</a>
		    			<a href="list-234-1.html" class="g-btn1">成功案例</a>
	    			</div>
	    		</div>
	    	</div>
    	</div>
    </div>
    <div class="g-box" style="background-image:url(images/bg5.jpg);">
    	<div class="wp">
    		<ul class="list ul-list3">
    			<li class="wow fadeInLeft" data-wow-duration="1.5s">
    				<div class="pic"><i class="iconfont icon-xiaolian"></i></div>
    				<h3>UE 交互设计</h3>
    			</li>
    			<li class="wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="0.5s">
    				<div class="pic"><i class="iconfont icon-daima"></i></div>
    				<h3>DEVELOP 技术研发</h3>
    			</li>
    			<li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="1s">
    				<div class="pic"><i class="iconfont icon-h5"></i></div>
    				<h3>UE 视觉创意</h3>
    			</li>
    			<li class="wow fadeInRight" data-wow-duration="1.5s" data-wow-delay="1.5s">
    				<div class="pic"><i class="iconfont icon-worm"></i></div>
    				<h3>TEST 系统测试</h3>
    			</li>
    		</ul>
    	</div>
    </div>
    <div class="g-box">
    	<div class="wp">
	    	<h3 class="g-tit1">行业成功案例</h3>
	    	<div class="m-tab1">
	    		<a href="list-232-1.html" class="on">全部</a>
	    		<a href="list-233-1.html">网站建设</a>
	    		<a href="list-234-1.html">手机端开发</a>
				<a href="list-346-1.html">小程序</a>
	    	</div>
	    	<ul class="list ul-list4">
				<?php
				$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE parentid=232 AND siteid = 1 AND find_in_set('c',flag) AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC limit 0,9");
				$i = 1;
				while($lists = $dosql->GetArray())
				{
					echo '
						<li class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="'.($i*0.15).'s">
							<div class="pic">
								<a '.gourl($lists['linkurl'],'detail',$lists['classid'],$lists['id']).' target="_blank"><img class="lazyimg" data-original="'.$lists['case_img'].'" alt="武汉网页设计" title="武汉网页设计"></a>
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
	    	<div class="m-bt wow fadeInUp" data-wow-duration="1s" data-wow-delay="2s">
	    		<a href="list-232-1.html" target="_blank" class="g-btn1">查看更多</a>
	    	</div>
    	</div>
    </div>
    <div class="g-box">
    	<div class="wp fix">
    		<h3 class="g-tit1">新闻动态</h3>
    		<div class="index-news fix">
    			<?php
				$dosql->Execute("SELECT id,classid,linkurl,title,picurl,description FROM `#@__infolist` WHERE classid=2 AND siteid = 1 AND find_in_set('c',flag) AND checkinfo=true AND delstate='' ORDER BY posttime DESC,orderid DESC limit 0,2");
				while($lists = $dosql->GetArray())
				{
					echo 
						'<div class="col">
		    				<div class="m-newsBox">
		    					<a '.gourl($lists['linkurl'],'content',$lists['classid'],$lists['id']).' target="_blank">
		    						<div class="pic">
		    							<img class="lazyimg" data-original="'.$lists['picurl'].'" title="'.$lists['title'].'" alt="'.$lists['title'].'">
		    						</div>
		    						<h3 class="tit">'.$lists['title'].'</h3>
		    						<p>'.$lists['description'].'</p>
		    					</a>
		    				</div>
		    			</div>';
				}
				?>
    			<div class="col">
	    			<ul class="ul-list15">
	    				<?php
						$dosql->Execute("SELECT id,classid,linkurl,title,picurl,posttime,description FROM `#@__infolist` WHERE classid=2 AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC limit 0,5");
						while($lists = $dosql->GetArray())
						{
							echo 
								'<li>
			    					<a '.gourl($lists['linkurl'],'content',$lists['classid'],$lists['id']).' target="_blank"><i></i>'.$lists['title'].'</a>
			    					<span class="date">'.MyDate('Y-m-d', $lists['posttime']).'</span>
			    				</li>';
						}
						?>
	    			</ul>
    			</div>
    			<div class="col">
	    			<ul class="ul-list15">
	    				<?php
						$dosql->Execute("SELECT id,classid,linkurl,title,picurl,posttime,description FROM `#@__infolist` WHERE classid=2 AND siteid = 1 AND checkinfo=true AND delstate='' ORDER BY posttime DESC limit 6,5");
						while($data = $dosql->GetArray())
						{
							echo 
								'
								<li>
									<a '.gourl($data['linkurl'],'content',$data['classid'],$data['id']).' target="_blank"><i></i>'.$data['title'].'</a>
									<span class="date">'.MyDate('Y-m-d', $data['posttime']).'</span>
								</li>';
						}
						?>
	    			</ul>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="g-box" style="background-color:#e3e3e3;">
    	<div class="wp">
    		<div class="m-link">
    			<div class="item">
    				<img src="images/img37.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img17.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img50.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img51.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img52.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img53.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img54.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img55.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img56.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img57.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img58.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img59.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img60.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    			<div class="item">
    				<img src="images/img61.png" alt="武汉网页设计" title="武汉网页设计">
    			</div>
    		</div>
    	</div>
    </div>
    <div class="g-box" style="background-color:#999;">
	<div class="wp">
		<div class="m-contact">
			<h2>您只需要告诉我们您的想法 剩下的都交由我们为您完成</h2>
			<p>YOU ONLY NEED TO TELL US YOUR IDEA，WE WILL FINISH THE REST FOR YOU</p>
			<a href="pinggu.html" target="_blank" class="g-btn1">在线咨询<i class="iconfont icon-jiantouyou"></i></a>
		</div>
	</div>
</div>
<div id="fd">
	<div class="wp">
		<div class="fd-top fix">
			<div class="m-mess">
				<h3 class="tit">在线留言</h3>
				<form action="ajax_do.php" class="form messageform" method="post">
					<input type="hidden" name="action" id="action" value="message" />
					<div class="con con1">
						<div class="inp">
							<input type="text" name="u_name" id="u_name" placeholder="姓名" datatype="s2-8" nullmsg="请输入您的姓名" errormsg="用户名不能低于2-8个字符" /><i class="iconfont icon-xingming"></i>
						</div>
						<div class="inp">
							<input type="text" name="m_obile" id="m_obile" placeholder="手机号" datatype="m" nullmsg="请输入手机号" errormsg="手机格式不正确" /><i class="iconfont icon-shouji"></i>
						</div>
					</div>
					<div class="con con2">
						<i class="iconfont icon-duihuaqipao2"></i>
						<textarea name="c_ontent" id="c_ontent" nullmsg="请输入留言内容" datatype="*2-120" errormsg="内容不能超过120个字符！" ></textarea>
					</div>
					<div id="error_tip" style="text-align:left;"></div> 
					<input type="submit" class="sub" value="CONTACT US">
				</form>
			</div>
			<div class="m-contact1 ovh">
				<div class="con con1">
					<h3 class="tit">公共媒体</h3>
					<ul>
						<li><a href="https://weibo.com/u/3046296615" target="_blank"><i class="iconfont icon-xinlang"></i>关注新浪微博</a></li>
						<li><a href="javascript:;"><i class="iconfont icon-weixin"></i>关注微信公众号</a><img src="images/linlutong.jpg" alt="朴讯软件"></li>
						<li><a href="tencent://message/?uin=2271010218&Site=www.kaifazhe.site&Menu=yes" target="_blank"><i class="iconfont icon-icon363601"></i>加为腾讯QQ好友</a></li>
						<li><a href="tel:15827236292"><i class="iconfont icon-lianxi-copy"></i>欢迎联系我们</a></li>
					</ul>
					<img src="images/logo2.png" alt="武汉网站开发公司" title="武汉网站开发公司" />
				</div>
				<div class="con con2">
					<h3 class="tit">技术支持</h3>
					<p>如果您有项目上的疑问，可以随时咨询我们。</p>
					<p>客服热线：<?php echo $cfg_hotline;?><br />技术支持：<a href="tel:15827236292"><b>林先生</b></a><br /><?php echo $cfg_copyright;?><br/><?php echo $cfg_icp;?></p>
					<div class="email">
						<input type="text" name="email" id="email" placeholder="输入您的邮件地址" />
						<input type="button" class="btn" id="emailGo" value="GO">
					</div>
					<script>
					$(function(){
						$("#emailGo").click(function(){
							var email = $("#email").val();
							var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/;
							if(email == ''){
								alert('邮箱不能为空!');
								$("#email").focus();
								return false;
							}
							else if(!reg.test(email)){
								alert('邮箱格式不正确!');
								$("#email").focus();
								return false;
							}
							$.post('ajax_do.php',{'email':email,'action':'emailGo'},function(data){
								if(data.status == 1){
									alert(data.info);
									location.reload();
								}else if(data.status == 0){
									alert(data.info);
									return false;
								}	
							},'json');
						});	
					});
					</script>
				</div>
			</div>
		</div>
        <div class="m-link1">
            <h3 class="tit">推荐公众号/小程序</h3>
			<div class="pic">
                    <span>
                        <img src="images/linlutong.jpg" alt="林路同" />
                    </span>
            </div>
            <div class="pic">
                    <span>
                        <img src="images/xihadoubizu.jpg" alt="嘻哈逗逼族" />
                    </span>
            </div>
        </div>
		<div class="m-link1">
			<h3 class="tit">友情链接</h3>
			<ul>
				<?php
				$dosql->Execute("SELECT webname,linkurl FROM `#@__weblink` WHERE classid=3 AND checkinfo=true ORDER BY posttime DESC,orderid DESC");
				while($lists = $dosql->GetArray())
				{
					echo '<li><a href="'.$lists['linkurl'].'" target="_blank">'.$lists['webname'].'</a></li>';
				}
				?>
				<li><a href="http://www.miitbeian.gov.cn" target="_blank"><?php echo $cfg_icp;?></a></li>
			</ul>
		</div>
	</div>
</div>
<!-- 返回顶部 -->
<a href="javascript:void(0);" class="toTop"></a>
<script src="js/jquery.lazyload.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/lib.js"></script>
<script src="js/swiper.min.js"></script>
<script>
	$(function(){
		var screen_w = $(window).width();
		if( screen_w<=959 ){
			$('.nav .pic img').attr('src','');
		}
		$(".lazyimg").lazyload({effect: "fadeIn"});
		$("#banner").slick({
			dots:true,
			arrows:false,
			autoplay:true,
			lazyLoad:'ondemand'
		});
		$(".m-link").slick({
			dots:false,
			arrows:true,
			slidesToShow: 6,
			lazyLoad:'ondemand',
			responsive: [
			{
			  breakpoint: 1367,
			  settings: {
				slidesToShow: 5,
			  }
			},
			{
			  breakpoint: 1200,
			  settings: {
				slidesToShow: 3,
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 2,
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
			  }
			}
		  ]
		});
		if (! (/msie [6|7|8|9]/i.test(navigator.userAgent))) {
			// 动画
			var wow = new WOW(
			  {
				boxClass:'wow', 
				animateClass:'animated',
				offset:0,
				mobile:true,
				live:true
			  }
			);
		wow.init();
		};
		//about.php
		$(".m-partner").slick({
            dots: true,
            arrows: false,
            autoplay: true,
            lazyLoad: 'ondemand'
        });
        $(".m-tab3 li").click(function(){
            var tab=$(this).parents(".m-tab3");
            var con='.'+tab.attr("id");
            var on=tab.find("li").index(this);
            $(this).addClass('on').siblings(tab.find("li")).removeClass('on');
            $(con).eq(on).show().siblings(con).hide();
        });
		
        new Swiper('#new-banner',{
            loop:true,
			slidesPerView: "auto",
			speed: 3000,
            autoplay: {
                disableOnInteraction: false,
				delay: 3000
            },
			observer: true,	//监听，当改变swiper的样式（例如隐藏/显示）或者修改swiper的子元素时，自动初始化swiper
            pagination: {
                el: '.swiper-pagination',
                clickable:true,
            },
        })
	})
</script>
<link type="text/css" rel="stylesheet"  href="Plugins/Validform/validform.css" />
<script type="text/javascript" src="Plugins/Validform/validform.js"></script>
<script>
$(function(){
	$(".messageform").Validform({
		tiptype:function(msg,o,cssctl){
			if(!o.obj.is("form")){//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
				var objtip=$("#error_tip");
				cssctl(objtip,o.type);
				objtip.text(msg);
			}else{
				var objtip=o.obj.find("#error_tip");
				cssctl(objtip,o.type);
				objtip.html(msg);
			}
		},
		postonce:true,
		ajaxPost:true,
		callback:function(data){
			if(data.status=="h"){
				alert(data.info);
				return false;	
			}
			else if(data.status=="y"){
				alert(data.info);
				setTimeout(function(){
					$(':input','.registerform')
						.not(':button, :submit, :reset, :hidden')
						.val('')
						.removeAttr('checked')
						.removeAttr('selected');
				},1000);
			}else{
				alert(data.info);
				return false;
			}
		}
	});
	//图片的高度跟电脑的一致
    var h = $(window).height()-110;
    console.log(h)
    $('.swiper-slide img').css({height:h+"px"});
});
</script>
</body>
</html>