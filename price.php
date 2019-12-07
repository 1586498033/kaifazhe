<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>下载报价</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="wap-font-scale" content="no">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="css/cui.css" />
    <link rel="stylesheet" href="css/iconfont.css" />
    <link rel="stylesheet" href="css/lib.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/less.css">
</head>
<body>
	<!-- 返回上一页 -->
	<a href="javascript:history.go(-1)" class="g-btn1 g-btn1-2"><i class="iconfont icon-fanhui"></i> 返回</a>
	<form>
		<div class="m-login1">
			<h3 class="tit"><img src="images/logo3.png" alt=""></h3>
			<ul>
				<li>
					<input type="text" class="inp" placeholder="邮箱">
				</li>
				<li>
					<input type="text" class="inp" placeholder="手机号">
				</li>
				<li>
					<input type="button" class="btn sub" value="下载报价">
				</li>
			</ul>
		</div>
	</form>

	<script src="js/jquery.js"></script>
	<script>
		// 发送验证码
		(function(){
			var wait = 60;
			function mbtime(o) {
			   if (wait == 60  ) {
			      //ajax发送短信
			   }
			   if (wait == 0) {
			      o.val('重发验证码').attr('disabled',false).removeClass('disabled');
			      wait = 60;
			   } else {
			      o.attr('disabled',true).val('剩余(' + wait + ")秒").addClass('disabled');
			      wait--;
			      setTimeout(function() {mbtime(o)},1000);
			   }
			}
			$('.btn-code').click(function(event) {
			   mbtime( $(this) )
			   return false;
			});
		})()
	</script>
</body>
</html>