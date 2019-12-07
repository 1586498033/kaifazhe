<?php	
require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('procloud');

//初始化参数
$tbname = '#@__procloud';
$gourl  = 'procloud.php';

if($action == 'del2' && $id == 1)
{
	ShowMsg('抱歉，不能删除第一个ProCloud产品！','-1');
	exit();
}

//引入操作类
require_once(ADMIN_INC.'/action.class.php');


if($action == 'save')
{
	$create_time = time();
	$update_time = time();
	if($nameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (name, url, sort_id, create_time) VALUES ('$nameadd', '$urladd', '$sort_idadd', '$create_time')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET sort_id='$sort_id[$i]', name='$name[$i]', url='$url[$i]', update_time='$update_time' WHERE id=$id[$i]");
		}
	}

	header("location:$gourl");
	exit();
}


//无条件返回
else
{
    header("location:$gourl");
	exit();
}
?>