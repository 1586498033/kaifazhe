<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('procloud'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ProCloud产品管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">ProCloud产品管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="procloud_save.php?action=save">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="5%" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="5%">ID</td>
			<td width="30%">产品名称</td>
			<td width="20%">产品链接</td>
			<td width="20%" align="center">排序</td>
			<td width="20%" class="endCol">操作</td>
		</tr>
		<?php
		$dosql->Execute("SELECT * FROM `#@__procloud` ORDER BY `sort_id` ASC");
		if($dosql->GetTotalRow() > 0)
		{
			while($row = $dosql->GetArray())
			{
				if($row['id'] == 1)
					$delstr = '删除';
				else
					$delstr = '<a href="procloud_save.php?action=del2&id='.$row['id'].'" onclick="return ConfDel(0);">删除</a>';
		?>
		<tr align="left" class="dataTr">
			<td height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?>
				<input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" />
			</td>
			<td align="left">
				<input type="text" name="name[]" id="name[]" class="inputd" value="<?php echo $row['name']; ?>" />
			</td>
			<td align="left">
				<input type="text" name="url[]" id="url[]" class="inputd" value="<?php echo $row['url']; ?>" />
			</td>
			<td align="center"><a href="procloud_save.php?id=<?php echo $row['id']; ?>&sort_id=<?php echo $row['sort_id']; ?>&action=up" class="leftArrow" title="提升排序"></a>
				<input type="text" name="sort_id[]" id="sort_id[]" class="inputls" value="<?php echo $row['sort_id']; ?>" />
				<a href="procloud_save.php?id=<?php echo $row['id']; ?>&sort_id=<?php echo $row['sort_id']; ?>&action=down" class="rightArrow" title="下降排序"></a></td>
			<td class="action endCol"><span class="nb"><?php echo $delstr; ?></span></td>
		</tr>
		<?php
			}
		}
		else
		{
		?>
		<tr align="center">
			<td colspan="6" class="dataEmpty">暂时没有相关的记录</td>
		</tr>
		<?php
		}
		?>
		<tr align="center">
			<td height="36" colspan="6"><strong>新增一个产品</strong></td>
		</tr>
		<tr align="left" class="dataTrOn">
			<td height="36">&nbsp;</td>
			<td>自增</td>
			<td><input name="nameadd" type="text" id="nameadd" class="input" /></td>
			<td><input name="urladd" type="text" id="urladd" class="input" /></td>
			<td align="center"><input type="text" name="sort_idadd" id="sort_idadd" class="inputls" value="<?php echo GetSortID('#@__procloud'); ?>" /></td>
			<td class="endCol"><input type="radio" name="checkinfoadd" value="true" checked="checked"  />
				显示&nbsp;
				<input type="radio" name="checkinfoadd" value="false" />
				隐藏</td>
		</tr>
	</table>
</form>
<div class="bottomToolbar"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('procloud_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('procloud_save.php');">更新排序</a></span> <a href="#" onclick="form.submit();" class="dataBtn">更新全部</a> </div>
<div class="page">
	<div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__procloud'); ?></span>条记录</div>
</div>
<?php
//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('procloud_save.php');" onclick="return ConfDelAll(0);">删除</a>　<span>操作：</span><a href="javascript:UpOrderID('procloud_save.php');">更新排序</a></span> <a href="#" onclick="form.submit();" class="dataBtn">更新全部</a><span class="pageSmall">
			<div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__procloud'); ?></span>条记录</div>
			</span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
/*
 * 获取排列序号
 *
 * @access  public
 * @param   $tbname   string  获取该表的最大ID
 * @return  $sortid  int     返回当前ID
*/
function GetSortID($tbname)
{
	global $dosql;

	$r = $dosql->GetOne("SELECT MAX(sort_id) AS `sort_id` FROM `$tbname`");
	$sort_id = (empty($r['sort_id']) ? 1 : ($r['sort_id'] + 1));

	return $sort_id;
}
?>
</body>
</html>