<?php require_once(dirname(__FILE__).'/include/config.inc.php');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <title>MySQL 插入数据</title>
	<link rel="stylesheet" href="css/cui.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
	<header class="g-header1">
		<h1>PMySQL 插入数据</h1>
	</header>
	<section class="g-bd g-bd3">
		<form>
			<div class="m-edit">
				<ul>
					<!--<li class="head">
						<span class="tit">选择文件</span>
						<div class="con">
							<div class="m-head">
								<?php
								$data = $dosql->GetOne("SELECT * FROM `#@__images` ORDER by id DESC");
								if($data){
									echo '<img src="'.$data['picurl']  .'" />';
								}else{
								?>
								<img src="images/img13.png" alt="" />
								<?php } ?>
								<input type="file" name="headimg" class="file js-uploadfile" />
							</div>
						</div>
					</li>-->
					<li>
						<span class="tit">用户名</span>
						<div class="con">
							<input type="text" name="username" id="username" placeholder="请输入用户名" class="inp" />
						</div>
					</li>
					<li>
						<span class="tit">密码</span>
						<div class="con">
							<input type="password" name="password" id="password" class="inp" placeholder="请输入密码" />
						</div>
					</li>
					<li>
						<span class="tit">联系方式</span>
						<div class="con">
							<input type="text" name="mobile" id="mobile" placeholder="请输入联系方式" class="inp" />
						</div>
					</li>
					
				</ul>
				<input type="button" class="sub" value="提交" />
			</div>
		</form>
	</section>
	<footer>
		<h3>喜欢就关注下公众号呗</h3>
		<img src="images/weixin.jpg" />
	</footer>
	<script src="js/jquery.js"></script>
	<script src="js/lib.js"></script>
	<script>
	$(function(){
		$(".sub").click(function(){
			var username = $("#username").val();
			var password = $("#password").val();
			var mobile = $("#mobile").val();
			if (username == ''){
				alert("请输入用户名");
				$("#username").focus();
				return false;
			}
			if (password == ''){
				alert("请输入密码");
				$("#password").focus();
				return false;
			}
			if (mobile == ''){
				alert("请输入手机号码");
				$("#mobile").focus();
				return false;
			}
			if(mobile && /^1[3|4|5|7|8]\d{9}$/.test(mobile)){

			} else{
				$("#mobile").focus();
				alert('手机号码格式不正确！');
				return false;
			} 
			
			$.post('ajax_do.php', {action:'insertData', username:username, password:password, mobile:mobile }, function(data){
				if(data.status == 1){
					alert(data.info);
					window.location.reload();
				}else{
					alert(data.info);
					return false;
				}
			}, 'json');
		});
	});
	</script>
</body>
</html>