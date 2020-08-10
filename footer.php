<div class="g-box" style="background-color:#999;">
	<div class="wp">
		<div class="m-contact">
			<h2>您只需要告诉我们您的想法 剩下的都交由我们为您完成</h2>
			<p>YOU ONLY NEED TO TELL US YOUR IDEA，WE WILL FINISH THE REST FOR YOU</p>
			<a href="pinggu.html" target="_blank" class="g-btn1">在线咨询<i class="iconfont icon-jiantouyou"></i></a>
		</div>
	</div>
</div>
<div id="fd" class="fd1">
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
							<input type="text" name="m_obile" id="m_obile" placeholder="手机" datatype="m" nullmsg="请输入手机号码" errormsg="手机格式不正确" /><i class="iconfont icon-shouji"></i>
						</div>
					</div>
					<div class="con con2">
						<i class="iconfont icon-duihuaqipao2"></i>
						<textarea name="c_ontent" id="c_ontent" nullmsg="请输入留言内容" placeholder="请输入您想咨询的内容" datatype="*2-120" errormsg="内容不能超过120个字符！" ></textarea>
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
						<li><a href="tencent://message/?uin=1586498033&Site=www.kaifazhe.site&Menu=yes" target="_blank"><i class="iconfont icon-icon363601"></i>加为QQ好友</a></li>
						<li><a href="tel:19156292659"><i class="iconfont icon-lianxi-copy"></i>欢迎联系我们</a></li>
					</ul>
					<img src="images/logo2.png" alt="上海app开发" title="上海app开发" />
				</div>
				<div class="con con2">
					<h3 class="tit">技术支持</h3>
					<p>如果您有项目上的疑问，可以随时咨询我们。</p>
					<p>客服热线：<?php echo $cfg_hotline;?><br />技术支持：<a href="tel:19156292659"><b>林先生</b></a><br /><?php echo $cfg_copyright;?><br/><?php echo $cfg_icp;?></p>
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
</div>
<!-- 返回顶部 -->
<a href="javascript:void(0);" class="toTop"></a>
<script src="js/jquery.lazyload.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/lib.js"></script>
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
});
</script>
