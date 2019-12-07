<?php	
require_once(dirname(__FILE__).'/../include/common.inc.php');require_once(dirname(__FILE__).'/inc/manageui.inc.php');

//初始化参数
$dopost = isset($dopost) ? $dopost : '';
//判断访问设备
if(IsMobile() && $dopost != 'login')
{
	header('location:default_mb.php?c=login');
	exit();
}
//判断登陆请求
if($dopost == 'login')
{
	//初始化参数
	$username = empty($username) ? '' : $username;
	$password = empty($password) ? '' : md5(md5($password));
	$question = empty($question) ? 0  : $question;
	$answer   = empty($answer)   ? '' : $answer;
	//验证输入数据
	if($username == '' or
	   $password == '')
	{
		header('location:login.php');
		exit();
	}
	//删除已过时记录
	$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE (UNIX_TIMESTAMP(NOW())-time)/60>15");
	//判断是否被暂时禁止登录
	$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE `username`='$username'");
	if(is_array($r))
	{
		$min = round((time()-$r['time']))/60;
		if($r['num']==0 and $min<=15)
		{
			ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
			exit();
		}
	}
	//获取用户信息
	$row = $dosql->GetOne("SELECT * FROM `#@__admin` WHERE `username`='$username'");
	//获取管理组信息
	if(isset($row) && is_array($row))
		$row2 = $dosql->GetOne("SELECT `groupsite`,`checkinfo` FROM `#@__admingroup` WHERE `id`=".$row['levelname']);
	//密码错误
	if(!is_array($row) or $password!=$row['password'])
	{
		$logintime = time();
		$loginip   = GetIP();
		$r = $dosql->GetOne("SELECT * FROM `#@__failedlogin` WHERE `username`='$username'");
		if(is_array($r))
		{
			$num = $r['num']-1;

			if($num == 0)
			{
				$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
				ShowMsg('您的密码已连续错误6次，请15分钟后再进行登录！','login.php');
				exit();
			}
			else if($r['num']<=5 and $r['num']>0)
			{
				$dosql->ExecNoneQuery("UPDATE `#@__failedlogin` SET time=$logintime, num=$num WHERE username='$username'");
				ShowMsg('用户名或密码不正确！您还有'.$num.'次尝试的机会！','login.php');
				exit();
			}
		}
		else
		{
			$dosql->ExecNoneQuery("INSERT INTO `#@__failedlogin` (username, ip, time, num, isadmin) VALUES ('$username', '$loginip', '$logintime', 5, 1)");
			ShowMsg('用户名或密码不正确！您还有5次尝试的机会！','login.php');
			exit();
		}
	}
	//密码正确，查看登陆问题是否正确
	else if($row['question'] != 0 && ($row['question'] != $question || $row['answer'] != $answer))
	{
		ShowMsg('登陆提问或回答不正确！','login.php');
		exit();
	}
	//密码正确，查看是否被禁止登录
	else if($row['checkadmin'] == 'false')
	{
		ShowMsg('抱歉，您的账号被禁止登陆！','login.php');
		exit();
	}
	//密码正确，查看管理组是否被禁用
	else if($row2['checkinfo'] == 'false')
	{
		ShowMsg('抱歉，您的所在的管理组被禁用！','login.php');
		exit();
	}
	//用户名密码正确
	else
	{
		$logintime = time();
		$loginip = GetIP();
		//删除禁止登录
		if(is_array($r))
		{
			$dosql->ExecNoneQuery("DELETE FROM `#@__failedlogin` WHERE `username`='$username'");
		}
		if(!isset($_SESSION)) session_start();
		//设置登录站点
		$r = $dosql->GetOne("SELECT `id`,`sitekey` FROM `#@__site` WHERE `id`=".$row2['groupsite']);
		if(isset($r['id']) &&
		   isset($r['sitekey']))
		{
			$_SESSION['siteid']  = $r['id'];
			$_SESSION['sitekey'] = $r['sitekey'];
		}
		else
		{
			$_SESSION['siteid']  = '';
			$_SESSION['sitekey'] = '';
		}
		//提取当前用户账号
		$_SESSION['admin']         = $row['username'];
		//提取当前用户权限
		$_SESSION['adminlevel']    = $row['levelname'];
		//提取上次登录时间
		$_SESSION['lastlogintime'] = $row['logintime'];
		//提取上次登录IP
		$_SESSION['lastloginip']   = $row['loginip'];
		//记录本次登录时间
		$_SESSION['logintime']     = $logintime;
		//更新登录数据
		$dosql->ExecNoneQuery("UPDATE `#@__admin` SET loginip='$loginip',logintime='$logintime' WHERE `username`='$username'");
		//更新操作日志
		SetSysEvent('login');
		//判断访问设备
		if(IsMobile())
		{
			$_SESSION['siteeq'] = 'mobile';
			header('location:default_mb.php?c=index');
			exit();
		}
		else
		{
			$_SESSION['siteeq'] = 'pc';
			header('location:default.php');
			exit();
		}
	}
}
//获取登陆背景
function GetLoginBg()
{
	global $cfg_loginbgcolor,$cfg_loginbgimg,
	       $cfg_loginbgrepeat,$cfg_loginbgpos;

	//背景重复
	if($cfg_loginbgrepeat == 0)
		$loginbgrepeat = 'no-repeat';
	else if($cfg_loginbgrepeat == 1)
		$loginbgrepeat = 'repeat-x';
	else if($cfg_loginbgrepeat == 2)
		$loginbgrepeat = 'repeat-y';
	else
		$loginbgrepeat = 'no-repeat';
	
	//背景对齐
	if($cfg_loginbgpos == 0)
		$loginbgpos = 'left 0';
	else if($cfg_loginbgpos == 1)
		$loginbgpos = 'center 0';
	else if($cfg_loginbgpos == 2)
		$loginbgpos = 'right 0';
	else
		$loginbgpos = 'center 0';
	
	return 'style="background-color:'.$cfg_loginbgcolor.';background-image:url('.$cfg_loginbgimg.');background-repeat:'.$loginbgrepeat.';background-position:'.$loginbgpos.';"';
}
//更新操作日志
function SetSysEvent($m='', $cid='', $a='')
{
	global $dosql;

	$sql = "INSERT INTO `#@__sysevent` (uname, siteid, model, classid, action, posttime, ip) VALUE ('".$_SESSION['admin']."', '".$_SESSION['siteid']."', '$m', '$cid', '$a', '".time()."', '".GetIP()."')";

	//更新操作日志
	//一分钟内连续操作只记录一次
	$r = $dosql->GetOne("SELECT `posttime` FROM `#@__sysevent` WHERE `uname`='".$_SESSION['admin']."' AND `siteid`=".$_SESSION['siteid']." AND `model`='$m' ORDER BY id DESC");
	if(!isset($r['posttime']))
		$dosql->ExecNoneQuery($sql);

	else if(isset($r['posttime']) &&
	       ($r['posttime']<time()-60))
		$dosql->ExecNoneQuery($sql);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>路同信息技术后台管理中心</title>
<!--<link href="templates/style/admin.css" rel="stylesheet" />-->
<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
<script src="templates/js/jquery.min.js"></script>
   <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<style type="text/css">
html,body {
	height: 100%;
}
.box {
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#6699FF', endColorstr='#6699FF'); /*  IE */
	background-image:linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
	background-image:-o-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
	background-image:-moz-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
	background-image:-webkit-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
	background-image:-ms-linear-gradient(bottom, #6699FF 0%, #6699FF 100%);
	
	margin: 0 auto;
	position: relative;
	width: 100%;
	height: 100%;
}
.login-box {
	width: 100%;
	max-width:500px;
	height: 400px;
	position: absolute;
	top: 50%;

	margin-top: -200px;
	/*设置负值，为要定位子盒子的一半高度*/
	
}
@media screen and (min-width:500px){
	.login-box {
		left: 50%;
		/*设置负值，为要定位子盒子的一半宽度*/
		margin-left: -250px;
	}
}	

.form {
	width: 100%;
	max-width:500px;
	height: 275px;
	margin: 25px auto 0px auto;
	padding-top: 25px;
}	
.login-content {
	height: 300px;
	width: 100%;
	max-width:500px;
	background-color: rgba(255, 250, 2550, .6);
	float: left;
}		
	
	
.input-group {
	margin: 0px 0px 30px 0px !important;
}
.form-control,
.input-group {
	height: 40px;
}

.form-group {
	margin-bottom: 0px !important;
}
.login-title {
	padding: 20px 10px;
	background-color: rgba(0, 0, 0, .6);
}
.login-title h1 {
	margin-top: 10px !important;
}
.login-title small {
	color: #fff;
}

.link p {
	line-height: 20px;
	margin-top: 30px;
}
.btn-sm {
	padding: 8px 24px !important;
	font-size: 16px !important;
}
footer{ font-family:"微软雅黑"; font-size:14px; line-height:35px; width:100%;height:35px; text-align:center; bottom:0px; position:absolute; background:#fff;}
</style>
<script>
function CheckForm()
{
	if($("#username").val() == "")
	{
		alert("请输入用户名！");
		$("#username").focus();
		return false;
	}
	if($("#password").val() == "")
	{
		alert("请输入密码！");
		$("#password").focus();
		return false;
	}
}
</script>
</head>
<div class="box">
		<div class="login-box">
			<div class="login-title text-center">
				<h1><small>后台管理系统</small></h1>
			</div>
			<div class="login-content ">
			<div class="form">
			<form name="login" method="post" action="" onSubmit="return CheckForm()">
				<div class="form-group">
					<div class="col-xs-12  ">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" id="username" name="username" class="form-control" placeholder="用户名">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12  ">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" id="password" name="password" class="form-control" placeholder="密码">
						</div>
					</div>
				</div>
				<div class="form-group form-actions">
					<div class="col-xs-4 col-xs-offset-4 ">
						<button type="submit" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-off"></span> 登录</button>
						<input type="hidden" name="dopost" value="login" />
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
	<!-- 底部 -->
	<footer> © <?php echo date('Y');?> 路同信息技术（上海）有限公司 </footer>
</div>
</body>
</html>