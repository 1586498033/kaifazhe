<?php	
require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('fragment');

//初始化参数
$tbname = '#@__fragment';
$gourl  = 'fragment.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//添加碎片数据
if($action == 'add')
{
	$posttime = time();
	$econtent = str_replace(array("\n", "\r\n"),"<br />",$econtent);
	$sql = "INSERT INTO `$tbname` (title, ctitle, etitle, picurl, linkurl, content, econtent, posttime) VALUES ('$title', '$ctitle', '$etitle', '$picurl', '$linkurl', '$content', '$econtent', '$posttime')";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}

//修改碎片数据
else if($action == 'update')
{
	$posttime = GetMkTime($posttime);
	$econtent = str_replace(array("\n", "\r\n"),"<br />",$econtent);
	$sql = "UPDATE `$tbname` SET title='$title', ctitle='$ctitle', etitle='$etitle', picurl='$picurl', linkurl='$linkurl', content='$content', econtent='$econtent', posttime='$posttime' WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}
//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>