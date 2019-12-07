<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('message'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>表单信息管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">表单信息管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="message_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="5%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="10%">类型</td>
			<td width="10%">姓名</td>
            <td width="10%">电话</td>
			<td width="10%">邮箱</td>
			<td width="15%">内容</td>
			<td width="10%">提交时间</td>
			<td width="10%">来源ip</td>
			<td width="15%" class="endCol">操作</td>
		</tr>
		<?php
		$dopage->GetPage("SELECT * FROM `#@__message` WHERE `siteid`='$cfg_siteid'");
		while($row = $dosql->GetArray())
		{
			switch($row['checkinfo'])
			{
				case 'true':
					$checkinfo = '已审';
					break;  
				case 'false':
					$checkinfo = '未审';
					break;
				default:
					$checkinfo = '未知';
			}
		?>
		<tr align="left" class="dataTr">
			<td height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td>
			<?php 
			$arr = array('','订阅','在线留言','项目预算','企业注册');
			echo $arr[$row['type']];
			?>
			</td>
			<td><?php echo $row['username'];?></td>
			<td><?php echo $row['mobile']; ?></td>
            <td><?php echo $row['email']; ?></td> 
			<td><?php echo ReStrLen($row['content'],120);?></td>
			<td class="number"><?php echo date('Y-m-d',$row['posttime']); ?></td>
			<td><?php echo $row['ip']; ?></td>
			<td class="action endCol"><span><a href="message_save.php?id=<?php echo $row['id']; ?>&action=check&checkinfo=<?php echo $row['checkinfo']; ?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a></span> | <a href="message_update.php?id=<?php echo $row['id']; ?>">处理</a> <span class="nb"><a href="message_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);">删除</a></span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php
//判断无记录样式

if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('message_save.php');" onclick="return ConfDelAll(0);">删除</a></span> <!--<a href="message_add.php" class="dataBtn">添加用户</a>--> </div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
</body>
</html>