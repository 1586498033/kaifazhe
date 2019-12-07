<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看用户留言</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript" src="templates/js/getarea.js"></script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__message` WHERE `id`=$id");
?>
<div class="formHeader"> <span class="title">查看用户</span> <a href="javascript:location.reload();" class="reload">刷新</a> </div>
<form name="form" id="form" method="post" action="message_save.php" onsubmit="return cfm_msg();">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
		<tr>
			<td width="25%" height="40" align="right">用户姓名：</td>
			<td width="75%"><strong><?php echo $row['username'] ?></strong></td>
		</tr>
        <tr>
			<td height="40" align="right">用户邮箱：</td>
			<td><?php echo $row['email']; ?></td>
		</tr>
        <tr>
			<td height="40" align="right">手机号码：</td>
			<td><?php echo $row['mobile']; ?></td>
		</tr>
        <tr>
			<td height="40" align="right">电子邮箱：</td>
			<td><?php echo $row['email']; ?></td>
		</tr>
		<tr>
			<td height="100" align="right">备注内容：</td>
			<td><textarea name="content" id="content" style=" width:500px; height:100px;"><?php echo $row['content'] ?></textarea></td>
		</tr>
        <tr>
			<td height="10" colspan="2"></td>
		</tr>
		<tr>
			<td height="100" align="right">回复内容：</td>
			<td><textarea name="recont" id="recont" style=" width:500px; height:100px;"><?php echo $row['recont'] ?></textarea></td>
		</tr>
		<tr>
			<td height="40" align="right">更新时间：</td>
			<td><input type="text" name="posttime" id="posttime" class="inputms" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
				<script type="text/javascript" src="plugin/calendar/calendar.js"></script> 
				<script type="text/javascript">
				Calendar.setup({
					inputField     :    "posttime",
					ifFormat       :    "%Y-%m-%d %H:%M:%S",
					showsTime      :    true,
					timeFormat     :    "24"
				});
				</script></td>
		</tr>
		<tr class="nb">
			<td height="40" align="right">审　核：</td>
			<td><input type="radio" name="checkinfo" value="true" <?php if($row['checkinfo']=='true') echo 'checked="checked"'; ?> />
				是
				&nbsp;
				<input type="radio" name="checkinfo" value="false" <?php if($row['checkinfo']=='false') echo 'checked="checked"'; ?> />
				否 <span class="cnote">选择"否"则该信息暂时不显示在前台</span></td>
		</tr>
	</table>
	<div class="formSubBtn">
		<input type="submit" class="submit" value="提交" />
		<input type="button" class="back" value="返回" onclick="history.go(-1);" />
		<input name="action" type="hidden" id="action" value="update" />
		<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
	</div>
</form>
</body>
</html>