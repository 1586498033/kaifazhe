<?php	
require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('postmode');

//初始化参数
$tbname = '#@__postmode';
$gourl  = 'postmode.php';


//引入操作类
require_once(ADMIN_INC.'/action.class.php');


//保存配送方式
if($action == 'save')
{
	if($classnameadd != '')
	{
		$dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, postprice, orderid, checkinfo) VALUES ('$classnameadd', '$postpriceadd', '$orderidadd', '$checkinfoadd')");
	}

	if(isset($id))
	{
		$ids = count($id);
		for($i=0; $i<$ids; $i++)
		{
			$dosql->ExecNoneQuery("UPDATE `$tbname` SET postprice='$postprice[$i]', orderid='$orderid[$i]', classname='$classname[$i]' WHERE id=$id[$i]");
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