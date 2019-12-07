<?php
header("content-type:text/html;charset=utf-8");	
require_once(dirname(__FILE__).'/../data/api/mail/class.phpmailer.php');	
if(!defined('IN_PHPMYWIND')) exit('Request Error!');
/*
 * 函数说明：单页信息调用
 *
 * @access  public
 * @param   $cid      int     类别ID
 * @param   $num      int     字数显示 0或空为不限制
 * @param   $gourl    string  跳转连接
 * @return            string  返回单页内容
 */
function Info($cid=0, $num=0, $gourl='')
{
	global $dosql;
	$contstr = '';

	$row = $dosql->GetOne("SELECT * FROM `#@__info` WHERE classid=$cid");
	if(isset($row['content']))
	{
		if(!empty($num))
		{
			$contstr .= ReStrLen($row['content'], $num);
		}
		else
		{
			return GetContPage($row['content']);
		}
		if($gourl != '') $contstr .= ' <a href="'.$gourl.'">[更多>>]</a>';
	}
	else
	{
		$contstr .= '网站资料更新中...';
	}
	return $contstr;
}

/*
 * 函数说明：单页信息自定义字段调用
 *
 * @access  public
 * @param   $cid      int     类别ID
 * @param   $cid      int     类别ID
 * @return            string  单页信息自定义字段内容
 */
function DiyInfo($cid=0, $field)
{
	global $dosql;
	$contstr = '';

	$row = $dosql->GetOne("SELECT ".$field." FROM `#@__info` WHERE classid=$cid");
	if(isset($row[$field]))
	{
		$contstr .= $row[$field];
	}
	else
	{
		$contstr .= '内容正在更新中...';
	}
	return $contstr;
}

/*
 * 函数说明：获取栏目简介
 *
 * @access  public
 * @Parameters $id:栏目id $num:截取字数 $db_table:数据表
 * @param   $description  string  设置栏目简介
 * @return  $description  string  返回替换后内容
 */
function Description($cid,$num=0){
	global $dosql;
	$description = '';
	$row = $dosql->GetOne("SELECT description FROM `#@__infoclass` WHERE id=$cid");
	if(isset($row['description']))
	{
		if(!empty($num))
		{
			$description .= ReStrLen($row['description'], $num);
		}
		else
		{
			$description .= $row['description'];
		}
	}
	else
	{
		$description .= '该栏目简介暂时未添加...';
	}
	
	return $description;
}

/*
 * 函数说明：获取栏目缩略图
 *
 * @access  public
 * @Parameters $id:栏目id $db_table:数据表
 * @param   $pic  string  设置栏目简介
 */
function classPic($id){
	global $dosql;
	if($id){
		$r = $dosql->GetOne("SELECT `picurl` FROM `#@__infoclass` WHERE `id`=$id");
		if(isset($r) && is_array($r))
		{
			return $r['picurl'];
		}else{
			return '../images/noFoundClassPic.jpg';	
		}
	}else{
		return '../images/noFoundClassPic.jpg';		
	}
	
}
/*
 * 函数说明：获取栏目缩略图[手机端]
 *
 * @access  public
 * @Parameters $id:栏目id $db_table:数据表
 * @param   $pic  string  设置栏目简介
 */
function mclassPic($id){
	global $dosql;
	$r = $dosql->GetOne("SELECT `mpicurl` FROM `#@__infoclass` WHERE `id`=$id");
	if(isset($r) && is_array($r))
	{
		return $r['mpicurl'];
	}else{
		return '../images/noFoundMpic.jpg';	
	}
}
/*
 * 函数说明：获取栏目SEO
 *
 * @access  public
 * @Parameters $id:栏目id $db_table:数据表
 * @param   $pic  string  设置栏目简介
 */
function classSeo($cid){
	global $dosql;
	$r = $dosql->GetOne("SELECT `seotitle` FROM `#@__infoclass` WHERE `id`=$cid");
	if(isset($r) && is_array($r))
	{
		return $r['seotitle'];
	}
}
/*
 * 函数说明：获取内容分页
 *
 * @access  public
 * @param   $content  string  设置分页内容
 * @return            string  返回替换后内容
 */
function GetContPage($content)
{
	global $cfg_isreurl;

	//设定分页标签
	$contstr  = '';
	$nextpage = '<hr style="page-break-after:always;" class="ke-pagebreak" />';


	if(strpos($content, $nextpage))
	{
		$contarr   = explode($nextpage, $content);
		$totalpage = count($contarr);
	
		if(!isset($_GET['page']) || !intval($_GET['page']) || $_GET['page'] > $totalpage) $page = 1;
		else $page = $_GET['page'];
	
		//输出内容
		$contstr .= $contarr[$page-1];

		//获取除page参数外的其他参数
		$query_str = explode('&',$_SERVER['QUERY_STRING']);

		if($query_str[0] != '')
		{
			$query_strs = '';

			foreach($query_str as $k)
			{
				$query_str_arr = explode('=', $k);

				if(strstr($query_str_arr[0],'page') == '')
				{
					$query_str_arr[0] = isset($query_str_arr[0]) ? $query_str_arr[0] : '';
					$query_str_arr[1] = isset($query_str_arr[1]) ? $query_str_arr[1] : '';

					//伪静态设置
					if($cfg_isreurl != 'Y')
						$query_strs .= $query_str_arr[0].'='.$query_str_arr[1].'&';		
					else
						$query_strs .= '-'.$query_str_arr[1];	
				}
			}

			$nowurl = '?'.$query_strs;
		}
		else
		{
			$nowurl = '?';
		}

		//伪静态设置
		if($cfg_isreurl == 'Y')
		{
			$request_arr  = explode('.',$_SERVER['PHP_SELF']);

			//部分环境获取地址为重写后地址，与原始地址不符，临时解决方案
			//使用此方案，文件名中不能包含 - ，否则会出现问题
			if(strpos($request_arr[0], '-'))
			{
				$request_str = explode('-', $request_arr[0]);
				$request_str = $request_str[0];
			}
			else
			{
				$request_str = $request_arr[0];
			}

			//获取除页码以外的参数
			$nowurl      = $request_str.ltrim($nowurl,'?');
		}
		
		$previous = $page - 1;
		if($totalpage == $page)
			$next = $page;
		else
			$next = $page + 1;

		$page_content = '<div class="contPage">';

		//显示首页的裢接
		if($page > 1)
		{
			//伪静态设置
			if($cfg_isreurl != 'Y')
			{
				$page_content .= '<a href="'.$nowurl.'page=1">&lt;&lt;</a>';
				$page_content .= '<a href="'.$nowurl.'page='.$previous.'">&lt;</a>';
			}
			else
			{
				$page_content .= '<a href="'.$nowurl.'-1.html">&lt;&lt;</a>';
				$page_content .= '<a href="'.$nowurl.'-'.$previous.'.html">&lt;</a>';
			}
		}
		else
		{
			$page_content .= '<a href="javascript:;">&lt;&lt;</a>';
			$page_content .= '<a href="javascript:;">&lt;</a>';
		}

		//显示数字页码
		for($i=1; $i<=$totalpage; $i++)
		{
			if($page == $i)
			{
				$page_content .= '<a href="javascript:;" class="on">'.$i.'</a>';
			}
			else
			{
				//伪静态设置
				if($cfg_isreurl != 'Y')
					$page_content .= '<a href="'.$nowurl.'page='.$i.'" class="num">'.$i.'</a>';
				else
					$page_content .= '<a href="'.$nowurl.'-'.$i.'.html" class="num">'.$i.'</a>';
			}
		}

		//显示尾页的裢接
		if($page < $totalpage)
		{
			//伪静态设置
			if($cfg_isreurl != 'Y')
			{
				$page_content .= '<a href="'.$nowurl.'page='.$next.'">&gt;</a>';
				$page_content .= '<a href="'.$nowurl.'page='.$totalpage.'">&gt;&gt;</a>';
			}
			else
			{
				$page_content .= '<a href="'.$nowurl.'-'.$next.'.html">&gt;</a>';
				$page_content .= '<a href="'.$nowurl.'-'.$totalpage.'.html">&gt;&gt;</a>';
			}
		}
		else
		{
			$page_content .= '<a href="javascript:;">&gt;</a>';
			$page_content .= '<a href="javascript:;">&gt;&gt;</a>';
		}
		$page_content .= '</div>';

		$contstr .= $page_content;
	}
	else
	{
		$contstr .= $content;
	}

	return $contstr;
}


/*
 * 函数说明：单页缩略图调用
 *
 * @access  public
 * @param   $classid  int     类别ID
 * @return            string  返回单页缩略图地址
 */
function InfoPic($cid=0)
{
	global $dosql;
	
	$r = $dosql->GetOne("SELECT `picurl` FROM `#@__info` WHERE `classid`=$cid");
	if(isset($r) && is_array($r))
	{
		return $r['picurl'];
	}
}
/*
 * 函数说明：单页自定义图片调用
 *
 * @access  public
 * @param   $classid  int     类别ID
 * @return            string  返回单页缩略图地址
 */
function InfoDiyPic($cid=0)
{
	global $dosql;
	
	$r = $dosql->GetOne("SELECT `picurl2` FROM `#@__info` WHERE `classid`=$cid");
	if(isset($r) && is_array($r))
	{
		return $r['picurl2'];
	}
}

/*
 * 栏目SEO头部调用
 *
 * @access  public
 * @param   $sid  int     当前站点id
 * @param   $cid  int     当前页面栏目id
 * @param   $id   int     是否为内容页(非0即是)
 * @return        string  返回头部区域代码
 */
function GetHeader($sid=1,$cid=0,$id=0,$str='')
{
	global $dosql, $cfg_webname, $cfg_generator,
	       $cfg_author, $cfg_keyword, $cfg_description;


	//检查站点标识
	if($sid != 1)
	{
		$r = $dosql->GetOne("SELECT `sitekey` FROM `#@__site` WHERE `id`=$sid");
		if(isset($r['sitekey']))
		{
			$cfg_webname     = @$GLOBALS['cfg_webname_'.$r['sitekey']];
			$cfg_generator   = @$GLOBALS['cfg_generator_'.$r['sitekey']];
			$cfg_author      = @$GLOBALS['cfg_author_'.$r['sitekey']];
			$cfg_keyword     = @$GLOBALS['cfg_keyword_'.$r['sitekey']];
			$cfg_description = @$GLOBALS['cfg_description_'.$r['sitekey']];
		}
	}
	//设置了自定义标题
	if($str != '')
	{
		$header_str  = '<title>'.$str.' - '.$cfg_webname.'</title>'."\n";
		$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
		$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
		$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
		$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
	}
	else
	{
		//显示详细信息
		if(!empty($cid) && !empty($id))
		{
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
	
			if(isset($r['infotype']))
			{
				if($r['infotype'] == 1)
					$tbname = '#@__infolist';
	
				else if($r['infotype'] == 2)
					$tbname = '#@__infoimg';
	
				else if($r['infotype'] == 3)
					$tbname = '#@__soft';
	
				else if($r['infotype'] == 4)
					$tbname = '#@__goods';


				//获取栏目信息
				$r2 = $dosql->GetOne("SELECT * FROM `$tbname` WHERE `id`=$id");
			
				$header_str = '<title>';
			
				if(isset($r2['title']))
					$header_str .= $r2['title'].' - ';
			
				if(isset($r['classname']))
					$header_str .= $r['classname'];
			
				$header_str .= ' - '.$cfg_webname.'</title>'."\n";
				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
				$header_str .= '<meta name="keywords" content="';

				if(isset($r2['keywords']))
					$header_str .= $r2['keywords'];
				else
					$header_str .= $cfg_keyword;
			
				$header_str .= '" />'."\n";
				$header_str .= '<meta name="description" content="';

				if(isset($r2['description']))
					$header_str .= $r2['description'];
				else
					$header_str .= $cfg_description;
			
				$header_str .= '" />'."\n";
			}
			else
			{
				return '';
			}
		}
		//显示栏目信息
		else if(!empty($cid))
		{
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
	
			$header_str = '<title>';
	
			if(!empty($r['seotitle']))
				$header_str .= $r['seotitle'];
			else if(!empty($r['classname']))
				$header_str .= $r['classname'].' - '.$cfg_webname;
			else
				$header_str .= $cfg_webname;
	
			$header_str .= '</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="';
			
			if(!empty($r['keywords']))
				$header_str .= $r['keywords'];
			else
				$header_str .= $cfg_keyword;

			$header_str .= '" />'."\n";
			$header_str .= '<meta name="description" content="';
			
			if(!empty($r['description']))
				$header_str .= $r['description'];
			else
				$header_str .= $cfg_description;
		
			$header_str .= '" />'."\n";
		}
		
		//显示站点信息
		else
		{
			$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
			$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
		}
	}
	return $header_str;
}

/*
 * 新闻详情页面 栏目SEO头部调用
 * @access  public
 * @param   $sid  int     当前站点id
 * @param   $cid  int     当前页面栏目id
 * @param   $id   int     是否为内容页(非0即是)
 * @return        string  返回头部区域代码
 */
function GetContentHeader($sid=1,$cid=0,$id=0,$str='')
{
	global $dosql, $cfg_webname, $cfg_generator,
	       $cfg_author, $cfg_keyword, $cfg_description;


	//检查站点标识
	if($sid != 1)
	{
		$r = $dosql->GetOne("SELECT `sitekey` FROM `#@__site` WHERE `id`=$sid");
		if(isset($r['sitekey']))
		{
			$cfg_webname     = @$GLOBALS['cfg_webname_'.$r['sitekey']];
			$cfg_generator   = @$GLOBALS['cfg_generator_'.$r['sitekey']];
			$cfg_author      = @$GLOBALS['cfg_author_'.$r['sitekey']];
			$cfg_keyword     = @$GLOBALS['cfg_keyword_'.$r['sitekey']];
			$cfg_description = @$GLOBALS['cfg_description_'.$r['sitekey']];
		}
	}
	$cfg_webname = 'Procloud网络';
	//设置了自定义标题
	if($str != '')
	{
		$header_str  = '<title>'.$str.' - '.$cfg_webname.'</title>'."\n";
		$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
		$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
		$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
		$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
	}
	else
	{
		//显示详细信息
		if(!empty($cid) && !empty($id))
		{
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
	
			if(isset($r['infotype']))
			{
				if($r['infotype'] == 1)
					$tbname = '#@__infolist';
	
				else if($r['infotype'] == 2)
					$tbname = '#@__infoimg';
	
				else if($r['infotype'] == 3)
					$tbname = '#@__soft';
	
				else if($r['infotype'] == 4)
					$tbname = '#@__goods';


				//获取栏目信息
				$r2 = $dosql->GetOne("SELECT * FROM `$tbname` WHERE `id`=$id");
			
				$header_str = '<title>';
			
				if(isset($r2['title']))
					$header_str .= $r2['title'];
			
				/*if(isset($r['classname']))
					$header_str .= $r['classname'];*/
			
				$header_str .= ' - '.$cfg_webname.'</title>'."\n";
				$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
				$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
				$header_str .= '<meta name="keywords" content="';

				if(isset($r2['keywords']))
					$header_str .= $r2['keywords'];
				else
					$header_str .= $cfg_keyword;
			
				$header_str .= '" />'."\n";
				$header_str .= '<meta name="description" content="';

				if(isset($r2['description']))
					$header_str .= $r2['description'];
				else
					$header_str .= $cfg_description;
			
				$header_str .= '" />'."\n";
			}
			else
			{
				return '';
			}
		}
		//显示栏目信息
		else if(!empty($cid))
		{
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
	
			$header_str = '<title>';
	
			if(!empty($r['seotitle']))
				$header_str .= $r['seotitle'];
			/*else if(!empty($r['classname']))
				$header_str .= $r['classname'].' - '.$cfg_webname;*/
			else
				$header_str .= $cfg_webname;
	
			$header_str .= '</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="';
			
			if(!empty($r['keywords']))
				$header_str .= $r['keywords'];
			else
				$header_str .= $cfg_keyword;

			$header_str .= '" />'."\n";
			$header_str .= '<meta name="description" content="';
			
			if(!empty($r['description']))
				$header_str .= $r['description'];
			else
				$header_str .= $cfg_description;
		
			$header_str .= '" />'."\n";
		}
		
		//显示站点信息
		else
		{
			$header_str  = '<title>'.$cfg_webname.'</title>'."\n";
			$header_str .= '<meta name="generator" content="'.$cfg_generator.'" />'."\n";
			$header_str .= '<meta name="author" content="'.$cfg_author.'" />'."\n";
			$header_str .= '<meta name="keywords" content="'.$cfg_keyword.'" />'."\n";
			$header_str .= '<meta name="description" content="'.$cfg_description.'" />'."\n";
		}
	}
	return $header_str;
}

/*
 * 函数说明：获取当前栏目名称
 *
 * @access  public
 * @param   $cid  int  栏目id
 * @return  string     返回栏目名称
 */
function GetCatName($cid=0)
{
	global $dosql;

	$r = $dosql->GetOne("SELECT `classname` FROM `#@__infoclass` WHERE `id`=$cid");

	if(isset($r['classname']))
		return $r['classname'];
	else
		return '';
}
/*
 * 函数说明：获取当前栏目英文名称
 *
 * @access  public
 * @param   $cid  int  栏目id
 * @return  string     返回栏目英文名称
 */
function GetEcatName($cid=0)
{
	global $dosql;

	$r = $dosql->GetOne("SELECT `eclassname` FROM `#@__infoclass` WHERE `id`=$cid");

	if(isset($r['eclassname']))
		return $r['eclassname'];
	else
		return '';
}
/*
 * 函数说明：获取当前指定栏目名称
 *
 * @access  public
 * @param   $cid  int  栏目id
 * @return  string     返回栏目名称
 */
function GetCatNameZd($cid=0,$classname="classname")
{
	global $dosql;

//	$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=(SELECT `parentid` FROM `#@__infoclass` WHERE `id`=$cid) ");
	$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid ");

	//if(isset($r[$classname]))
		return $r[$classname];
//	else
	//	return '';
}

/*
 * 单条广告信息显示
 *
 * @access  public
 * @param   $cid     int     指定栏目id
 * @param   $id      int     当前页面文章id
 * @return           string
 */

function adstr($cid,$id,$start,$num){
	global $dosql;

	$dosql->Execute("SELECT * FROM `#@__admanage` WHERE `siteid`=1 AND `classid`={$cid} order by orderid asc limit $start,$num");
		$re_str="";
		while($row = $dosql->GetArray()){
		$re_str .='<a href="'.$row['linkurl'].'"><img src="'.$row['picurl'].'" /></a>
                        <div class="st_link"></div>
                        <a href="'.$row['linkurl'].'" class="button">
                            <p class="store_name">'.$row['title'].'</p>
                            <p class="store_more">了解更多</p>
                        </a>';
		
		}
	return $re_str;
}

/*
 * 单条广告
 * 1-标题  2-图片 3-链接 4-简介
 */

function getAd($cid,$id,$i){
	global $dosql;
	$row = $dosql->GetOne("SELECT * FROM `sh_admanage` WHERE classid=$cid AND id = '$id' AND checkinfo=true");
	if($row){
		switch ($i){
			case 1:
				return $row['title'];
				break;
			case 2:
				return $row['picurl'];
				break;	
			case 3:
				return $row['linkurl'];
				break;
			case 4:
				return $row['adtext2'];
				break;	
		}
	}
}
/*
 * 广告位标题
 */

function getAdTypeName($cid=0){
	global $dosql;
	$r = $dosql->GetOne("SELECT `classname` FROM `sh_adtype` WHERE id=$cid AND checkinfo=true");
	if(isset($r['classname']))
		return $r['classname'];
	else
		return '';
}
/*
 * 广告说明
 */

function getAdType($cid=0){
	global $dosql;
	$r = $dosql->GetOne("SELECT * FROM `sh_adtype` WHERE id=$cid AND checkinfo=true");
	if(isset($r['content']))
		return $r['content'];
	else
		return '';
}
/*
 * 获取当前页面位置
 *
 * @access  public
 * @param   $cid     int     当前页面栏目id
 * @param   $id      int     当前页面文章id
 * @param   $sign    string  栏目之间分隔符
 * @return           string
 */
function GetPosStr($cid=0,$id=0,$sign='&nbsp;&gt;&nbsp;')
{
	global $dosql, $cfg_webpath, $cfg_weburl;
	//设置首页链接
	$pos_str = '<a href="'.$cfg_weburl.'">首页</a>';
	//如果cid为空，获取串，否则视为首页
	if(!empty($cid))
	{
		//获取当前栏目信息
		$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where `id`=$cid");
		if(empty($r['parentstr']))
		{
			return $pos_str.$sign.'栏目不存在';
		}
		else
		{
			//构成上级栏目字符
			if($r['parentstr'] != '0,')
			{
				$pid_arr = explode(',', $r['parentstr']);
		
				foreach($pid_arr as $v)
				{
					if(!empty($v))
					{
						$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where `id`=$v");
						if(!empty($r['linkurl']))
							$pos_str .= $sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>';
						else
							//$pos_str .= $sign.$r['classname'];
							$pos_str .= $sign.'<a href="list-'.$r['id'].'-1.html">'.$r['classname'].'</a>';
							//$pos_str .= $sign.'<a href="product-'.$r['id'].'-1.html">'.$r['classname'].'</a>';
					}
				}
			}
			//构成本级栏目字符 及显示（文章或产品）标题
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
			if(isset($r) && is_array($r))
			{
				switch($r['infotype']){
					case 1:
						$tableName = '#@__infolist';
						break;
					case 2:
						$tableName = '#@__infoimg';
						break;
				}
				if(!empty($id))
				{
					$r2 = $dosql->GetOne("SELECT `title` FROM ".$tableName." WHERE `id`=$id");
					$rTitle = $r2['title'];
					if(!empty($r['linkurl']))
						return $pos_str.$sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>'.$sign.$rTitle;
					else
						return $pos_str.$sign.'<a href="list-'.$r['id'].'-1.html">'.$r['classname'].'</a>'.$sign.$rTitle;
				}
				else
				{
					if(!empty($r['linkurl']))
						//return $pos_str.$sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>';
						return $pos_str.$sign.'<a href="javascript:;">'.$r['classname'].'</a>';
					else
						return $pos_str.$sign.''.$r['classname'].'';
				}
			}
			else
			{
				return $pos_str.$sign.'栏目不存在';
			}
		}
	}
	else
	{
		return $pos_str;
	}
}
/*手机版 当前位置*/
function GetWapPosStr($m,$cid=0,$id=0,$sign='&nbsp;&gt;&nbsp;')
{
	global $dosql, $cfg_weburl_wap;
	//设置首页链接
	$pos_str = '<a href="4g.php" data-icon="&#xe705;">首页</a>';

	//如果cid为空，获取串，否则视为首页
	if(!empty($cid))
	{
		
		//获取当前栏目信息
		$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where `id`=$cid");
		if(empty($r['parentstr']))
		{
			return $pos_str.$sign.'栏目不存在';
		}
		else
		{
			//构成上级栏目字符
			if($r['parentstr'] != '0,')
			{
				$pid_arr = explode(',', $r['parentstr']);
		
				foreach($pid_arr as $v)
				{
					if(!empty($v))
					{
						$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` where `id`=$v");
						if(!empty($r['linkurl']))
							$pos_str .= $sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>';
						else
							$pos_str .= $sign.'<a href="4g.php?m='.$m.'&cid='.$r['id'].'">'.$r['classname'].'</a>';
					}
				}
			}

			//构成本级栏目字符 及显示（文章或产品）标题
			$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE `id`=$cid");
			if(isset($r) && is_array($r))
			{
				switch($r['infotype']){
					case 1:
						$tableName = '#@__infolist';
						break;
					case 2:
						$tableName = '#@__infoimg';
						break;
				}
				if(!empty($id))
				{
					$r2 = $dosql->GetOne("SELECT `title` FROM ".$tableName." WHERE `id`=$id");
					$rTitle = $r2['title'];
					if(!empty($r['linkurl']))
						return $pos_str.$sign.'<a href="'.$r['linkurl'].'">'.$r['classname'].'</a>'.$sign.$rTitle;
					else
						return $pos_str.$sign.'<a href="4g.php?m='.$m.'&cid='.$r['id'].'">'.$r['classname'].'</a>'.$sign.$rTitle;
				}
				else
				{
					if(!empty($r['linkurl']))
						return $pos_str.$sign.'<a href="javascript:;">'.$r['classname'].'</a>';
					else
						return $pos_str.$sign.$r['classname'];
				}
			}
			else
			{
				return $pos_str.$sign.'栏目不存在';
			}
		}
	}
	else
	{
		return $pos_str;
	}
}

/*
 * 参数说明：获取客服QQ
 *
 * @access  public
 * @return  string  返回HTML代码
 */
function GetQQ()
{
	global $cfg_qqcode;

	if(!empty($cfg_qqcode))
	{
		$re_str = '<div id="close" onclick="hidd();" class="kf"><div class="kf_r"><span class="kf_close"><img src="templates/default/images/close.jpg"></span>';
		$qqnum_arr = explode(',', $cfg_qqcode);

		foreach($qqnum_arr as $v)
		{
			$qq_arr = explode('|',$v);
			if(!empty($qq_arr[0]) and !empty($qq_arr[1]))
			{
				$re_str .= '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq_arr[0].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':41" alt="'.$qq_arr[1].'" title="'.$qq_arr[1].'"></a>';
			}
			else if(!empty($qq_arr[0]) and empty($qq_arr[1]))
			{
				$re_str .= '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq_arr[0].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':41" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
			}
			else
			{
				$re_str .= '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$v.'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$v.':41" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
			}
		}
		$re_str .= '</div></div>';
		
		return $re_str;
	}
}


//获取parentstr的第一位
function GetTopID($str,$i=1)
{
	if($str == '0,')
	{
		$topid = 0;
	}
	else
	{
		$ids = explode(',', $str);
		$topid = isset($ids[$i]) ? $ids[$i] : '';
	}
	
	return $topid;
}


/*
 * 函数说明：获取一级导航
 *
 * @access  public
 * @param   $id  int  父ID
 * @return  string    返回导航
 */
function GetNav($pid=1,$nid=1)
{
	global $dosql, $cfg_isreurl;

	$str = '';
	$dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=$pid AND checkinfo=true ORDER BY orderid ASC");
	while($row = $dosql->GetArray())
	{
		if($cfg_isreurl != 'Y')
			$gourl = $row['linkurl'];
		else
			$gourl = $row['relinkurl'];
		
		if($row['picurl'] != '')
			$classname = '<img src="'.$row['picurl'].'" />';
		else
			$classname = $row['classname'];
		if($nid==$row['id'])
			$str .= '<li class="cur">';
		else
			$str .= '<li>';
		$str .= '<a href="'.$gourl.'"';

		if($row['target'] != '')
			$str .= ' target="'.$row['target'].'"';

	//	$str .= '>'.$classname.'</a><ul class="nav_sub">'.GetSubNav($row['id']).'</ul></li>';
		$str .= '>'.$classname.'</a></li>';
	}

	return $str;
}


/*
 * 函数说明：获取导航菜单
 *
 * @access  public
 * @param   $id  int  父ID
 * @return  string    返回导航
 */
function GetSubNav($id)
{
	global $dosql, $cfg_isreurl;

	$str = '';
	$row = $dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=$id AND checkinfo=true ORDER BY orderid ASC", $id);
	while($row = $dosql->GetArray($id))
	{
		if($cfg_isreurl != 'Y')
			$gourl = $row['linkurl'];
		else
			$gourl = $row['relinkurl'];


		if($row['picurl'] != '')
			$classname = $row['picurl'];
		else
			$classname = $row['classname'];


		$str .= '<li><a href="'.$gourl.'"';
		
		if($row['target'] != '')
			$str .= ' target="'.$row['target'].'"';

		$str .= '>'.$classname.'</a>';

		$row2 = $dosql->Execute("SELECT * FROM `#@__nav` WHERE parentid=".$row["id"]." AND checkinfo=true ORDER BY orderid DESC", $row['id']);
		if($dosql->GetTotalRow($row['id']))
		{
			$str .= '<ul class="s">'.GetSubNav($row["id"]).'</ul>';
		}
		$str .= '</li>';
	}

	return $str;
}
/*
 * 函数说明：碎片数据调用
 *
 * @access  public
 * @param   $id   int  碎片ID
 * @param   $t    int  调用的内容 0为内容 1为标识名称 2为缩略图 3为跳转连接 
 * @return  string     返回碎片缩略图地址
 */
function GetFragment($id=0,$t=0)
{
	global $dosql;

	if($t == 0)
		$field = 'content';
	else if($t == 1)
		$field = 'title';
	else if($t == 2)
		$field = 'picurl';
	else if($t == 3)
		$field = 'linkurl';
	else if($t == 4)
		$field = 'etitle';
	else if($t == 5)
		$field = 'econtent';
	else if($t == 6)
		$field = 'ctitle';
	else
		$field = '*';

	$r = $dosql->GetOne("SELECT `$field` as `f` FROM `#@__fragment` WHERE `id`=$id");
	if(isset($r) && is_array($r))
	{
		return $r['f'];
	}
}
/*
 * 函数说明：Logo图片调用
 *
 * @access  public
 * @param   $id   int  Logo栏目ID,通常公司logo只有一张图片
 * @return  string     返回碎片缩略图地址
 */
function Logo($cid=0)
{
	global $dosql;

	$r = $dosql->GetOne("SELECT `picurl` FROM `#@__admanage` WHERE `classid`=$cid");
	if(isset($r) && is_array($r))
	{
		return $r['picurl'];
	}
	
}

/*通用栏目banner*/
function CommonBanner($cid=0)
{
	global $dosql;
	$r = $dosql->GetOne("SELECT `picurl` FROM `#@__admanage` WHERE `classid`=$cid order by orderid desc limit 0,1" );
	if(isset($r) && is_array($r))
	{
		return $r['picurl'];
	}
}

/*gourl跳转*/
function gourl($linkurl,$type,$cid,$id=0){
	global $cfg_isreurl;
	$url = '';
	if($id)
	{
		if($linkurl=='' && $cfg_isreurl!='Y')
		{
			$url .= 'href="'.$type.'.php?cid='.$cid.'&id='.$id.'"';
		}
		else if($linkurl=='' && $cfg_isreurl=='Y')
		{
			$url .= 'href="'.$type.'-'.$cid.'-'.$id.'-1.html"';
		}
		else
		{
			$url .= 'href="'.$linkurl.'" target="_blank"';
		}
	}
	else
	{
		if($linkurl=='' && $cfg_isreurl!='Y')
		{
			$url .= 'href="'.$type.'.php?cid='.$cid.'"';
		}				
		else if($linkurl=='' && $cfg_isreurl=='Y'){
			$url .= 'href="'.$type.'-'.$cid.'-1.html"';
		}			
		else
		{
			$url .= 'href="'.$linkurl.'" target="_blank"';	
		}	
	}
	return $url;		
}

function getCity($city_id){
	global $dosql;
	$row = $dosql->GetOne("SELECT dataname FROM `#@__cascadedata` WHERE datavalue='" . $city_id ."' AND level = 1");
	if($row){
		return $row['dataname'];	
	}
}

/* 获取案例标题 */
function getTitle($id){
	global $dosql;
	$row = $dosql->GetOne("SELECT title FROM `#@__infoimg` WHERE checkinfo=true AND delstate='' AND id=" . $id);
	if($row){
		return $row['title'];	
	}else{
		return '文章不存在';	
	}
}

/* 获取案例详情url */
function getDetailUrl($id){
	global $dosql;
	$row = $dosql->GetOne("SELECT id,classid,content FROM `#@__infoimg` WHERE checkinfo=true AND delstate='' AND id=" . $id);
	if(!empty($row['content'])){
		return 'content-'.$row['classid'].'-'.$row['id'].'-1.html';	
	}else{
		return 'javascript:;';	
	}
}

/* 获取标签 */
function getTag($id){
	global $dosql;
	if(!empty($id)){
		$row = $dosql->GetOne("SELECT tag FROM `#@__tag` WHERE id=" . $id);
		if(!empty($row['tag'])){
			return $row['tag'];
		}else{
			return 'ProCloud';	
		}
	}else{
		return 'ProCloud';	
	}
}

/* 获取类别 */
function getTypes($typename){
	global $dosql;
	if(!empty($typename)){
		$row = $dosql->GetOne("SELECT type FROM `#@__type` WHERE typename='" . $typename ."'");
		if(!empty($row['type'])){
			return $row['type'];
		}else{
			return 'ProCloud';	
		}
	}else{
		return 'ProCloud';	
	}
}

/* 
 * 邮件发送函数:smtp_mail()
 * @param $sendto_email, $subject, $body, $extra_hdrs, $user_name
 * @result
*/
function smtp_mail( $sendto_email, $subject, $body, $extra_hdrs, $user_name){  
    $mail = new PHPMailer();  
    $mail->IsSMTP();                  	// 经SMTP发送  
	$mail->Host = "ssl://smtp.exmail.qq.com";   	// SMTP 服务器
	$mail->Port = 465; 					// SMTP服务器的端口号  
    $mail->SMTPAuth = true;           	// 打开SMTP认证   
	$mail->Username = "wuhan@proclouds.cn"; // SMTP username  注意：普通邮件认证不需要加 @域名    
    $mail->Password = "158649Sf"; // 我的邮箱密码（发件人）  
    $mail->From = "wuhan@proclouds.cn";      // 发件人邮箱  
    $mail->FromName =  "ProCloud";  // 发件人  
  
    $mail->CharSet = "UTF-8";   // 这里指定字符集！  
    $mail->Encoding = "base64";  
    $mail->AddAddress($sendto_email,$sendto_email);  // 收件人邮箱和姓名  
    $mail->AddReplyTo("wuhan@proclouds.cn","wuhan@proclouds.cn");  
    $mail->IsHTML(true);  // send as HTML  
   
    $mail->Subject = $subject;	 // 邮件主题  
    // 邮件内容  
	$mail->Body = '<html>
					<head>     
					<meta http-equiv="Content-Language" content="zh-cn">     
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">     
					</head>     
					<body>    
					'.$body.'  
					</body>     
				</html>';  
    $mail->AltBody ="text/html";  
    return $mail->Send();
}

/* 
 * 非法字符过滤函数:filter()
 * @param $str--内容,$value--过滤值
 * @result
 */
function filter($str,$value){
	$flag = 1;
	if(empty($str)){
		$flag = 0;
	}
	if(stripos($str,'href')){
		$flag = 0;
	}else if(stripos($str,'http')){
		$flag = 0;
	}else if(stripos($str,'https')){
		$flag = 0;
	}else if(stripos($str,'ftp')){
		$flag = 0;
	}else if(stripos($str,'sftp')){
		$flag = 0;
	}else if(stripos($str,'img')){
		$flag = 0;
	}else if(stripos($str,'select')){
		$flag = 0;
	}else if(stripos($str,'insert')){
		$flag = 0;
	}else if(stripos($str,'update')){
		$flag = 0;
	}else if(stripos($str,'delete')){
		$flag = 0;
	}else if(stripos($str,'phpinfo')){
		$flag = 0;
	}else{
		$flag = 1;
	}
	return $flag;
}
//验证码获取函数
function GetCkVdValue()
{
	if(!isset($_SESSION)) session_start();
	return isset($_SESSION['ckstr']) ? $_SESSION['ckstr'] : '';
}
//验证码重置函数
function ResetVdValue()
{
	if(!isset($_SESSION)) session_start();
	$_SESSION['ckstr'] = '';
}