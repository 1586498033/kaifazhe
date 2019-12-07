<?php	if(!defined('IN_PHPMYWIND')) exit('Request Error!');
/*
 * 分页类
 *
**************************
(C)2010-2014 shkj.net
update: 2011-4-26 15:00:19
person: Feng
**************************
*/
$dopage = new Page();
class Page
{
	var $page;      //当前页码
	var $totalpage; //总共页数
	var $pagenum;   //每页记录数
	var $total;     //总共记录数
    function __construct()
    {
		$this->Init();
    }
    function Page()
    {
		$this->__construct();
    }
	function Init()
    {
		$this->page      = '';
		$this->totalpage = '';
		$this->pagenum   = '';
		$this->total     = '';
    }
	//获取分页变量
	function GetPage($sql,$pagenum=20)
	{
		global $dosql;

		$dosql->Execute($sql);
		$this->page      = @$GLOBALS['page'];
		$this->total     = $dosql->GetTotalRow();
		$this->pagenum   = $pagenum;
		$this->totalpage = ceil($this->total / $this->pagenum);
		
		if(!isset($this->page) || !intval($this->page) || $this->page<=0 || $this->page > $this->totalpage)
		{
			$this->page = 1;
		}

		$startnum = ($this->page-1) * $this->pagenum;

		$sql .= " limit $startnum, $this->pagenum";

		return $dosql->Execute($sql);
	}
	//显示分页列表
	function GetList()
	{
		global $cfg_isreurl,$keyword;
		$pagetxt = '';
		if($this->total <= $this->pagenum)
		{
			$pagetxt = '<div class="m-pages"><a href="javascript:;" class="a1">共<b>'.$this->totalpage.'</b>页&nbsp;<b>'.$this->total.'</b>条记录</a></div>';
		}
		else
		{
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
						if($cfg_isreurl == 'Y' &&
						   !isset($keyword))
						{
							$query_strs .= '-'.$query_str_arr[1];
						}
						else
						{
							$query_strs .= $query_str_arr[0].'='.$query_str_arr[1].'&';
						}
					}
				}
				$nowurl = '?'.$query_strs;
			}
			else
			{
				$nowurl = '?';
			}
			//伪静态设置
			if($cfg_isreurl == 'Y' &&
			   !isset($keyword))
			{
				$request_arr = explode('.',$_SERVER['SCRIPT_NAME']);
				$request_rui = explode('/',$request_arr[count($request_arr)-2]);

				//获取除页码以外的参数
				$nowurl      = ltrim($request_rui[count($request_rui)-1],'/').ltrim($nowurl,'?');
			}
			$previous = $this->page - 1;
			if($this->totalpage == $this->page) $next = $this->page;
			else $next = $this->page + 1;
			$pagetxt = '<div class="m-pages"><ul>';
			//上一页 第一页
			if($this->page > 1)
			{
				//伪静态设置
				if($cfg_isreurl == 'Y' &&
				   !isset($keyword))
				{
					$pagetxt .= '<li><a href="'.$nowurl.'-'.$previous.'.html" title="上一页" class="a1">上一页</a></li>';
				}
				else
				{
					$pagetxt .= '<li><a href="'.$nowurl.'page='.$previous.'" title="上一页" class="a1">上一页</a></li>';
				}
			}
			else
			{
				$pagetxt .= '<li><a href="javascript:;" title="已是第一页">上一页</a></li>';
			}
			//当总页数小于10
			if($this->totalpage < 10)
			{
				for($i=1; $i <= $this->totalpage; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<li class="on"><a href="javascript:;">'.$i.'</a></li>';
					}
					else
					{
						//伪静态设置
						if($cfg_isreurl == 'Y' &&
						   !isset($keyword))
						{
							$pagetxt .= '<li><a href="'.$nowurl.'-'.$i.'.html" title="第 '.$i.' 页">'.$i.'</a></li>';
						}
						else
						{
							$pagetxt .= '<li><a href="'.$nowurl.'page='.$i.'" title="第 '.$i.' 页">'.$i.'</a></li>';
						}
					}
				}
			}
			else
			{
				if($this->page==1 or $this->page==2 or $this->page==3)
				{
					$m = 1;
					$b = 7;
				}
				//如果页面大于前三页并且小于后三页则显示当前页前后各三页链接
				if($this->page>3 and $this->page<$this->totalpage-2)
				{
					$m = $this->page-3;
					$b = $this->page+3;
				}
				//如果页面为最后三页则显示最后7页链接
				if($this->page==$this->totalpage or $this->page==$this->totalpage-1 or $this->page==$this->totalpage-2)
				{
					$m = $this->totalpage - 7;
					$b = $this->totalpage;
				}
				if($this->page > 4)
				{
					$pagetxt .= '<li><span>...</span></li>';
				}
				//显示数字页码
				for($i=$m; $i<=$b; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<li class="on"><a href="'.$nowurl.'page='.$i.'">'.$i.'</a></li>';
					}
					else
					{
						//伪静态设置
						if($cfg_isreurl == 'Y' &&
						   !isset($keyword))
						{
							$pagetxt .= '<li class="on"><a href="'.$nowurl.'-'.$i.'.html" title="第 '.$i.' 页">'.$i.'</a></li>';
						}
						else
						{
							$pagetxt .= '<li class="on"><a href="'.$nowurl.'page='.$i.'" title="第 '.$i.' 页">'.$i.'</a></li>';
						}
					}
				}
				if($this->page < $this->totalpage-3)
				{
					$pagetxt .= '<li><span>...</span></li>';
				}
			}
			//下一页 最后页
			if($this->page < $this->totalpage)
			{
				//伪静态设置
				if($cfg_isreurl == 'Y' &&
				   !isset($keyword))
				{
					$pagetxt .= '<li><a href="'.$nowurl.'-'.$next.'.html" title="下一页" class="a1">下一页</a></li>';
				}
				else
				{
					$pagetxt .= '<li><a href="'.$nowurl.'page='.$next.'" title="下一页" class="a1">下一页</a></li>';
				}
			}
			else
			{
				$pagetxt .= '<li><a href="javascript:;" title="已是最后一页" class="a1">下一页</a></li>';
			}
			$pagetxt .= '</ul></div>';
		}
		
		return $pagetxt;
	}
	
}
?>