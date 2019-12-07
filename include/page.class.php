<?php
/*
 * 分页类
 * */
if(!defined('IN_PHPMYWIND')) exit('Request Error!');
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
			$pagetxt = '<div class="m-pages"><ul><li>'.$this->totalpage.'页&nbsp;'.$this->total.'条记录</li></ul></div>';
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
			if($nowurl == 'search'){
				$nowurl = 'list-2';
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
					//$pagetxt .= '<font class="pagefaceb"><a href="'.$nowurl.'-1.html" title="首页" class="a1">首页</a></font>';
					$pagetxt .= '<li><a href="'.$nowurl.'-'.$previous.'.html" title="上一页">&lt;</a></li>';
				}
				else
				{
					//$pagetxt .= '<font class="pagefaceb"><a href="'.$nowurl.'page=1" title="首页" class="a1">首页</a></font>';
					$pagetxt .= '<li><a href="'.$nowurl.'page='.$previous.'" title="上一页">&lt;</a></li>';
				}
			}
			else
			{
				//$pagetxt .= '<font class="pagefaceb"><a href="javascript:;" title="第一页" class="a1">首页</a></font>';
				$pagetxt .= '<li><a href="javascript:;" title="首页">&lt;</a></li>';
			}
			//当总页数小于10
			if($this->totalpage < 10)
			{
				for($i=1; $i <= $this->totalpage; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<li><a class="on">'.$i.'</a></li>';
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
							$pagetxt .= '<li><a href="'.$nowurl.'page='.$i.'" title="页 '.$i.' 页">'.$i.'</a></li>';
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
					$pagetxt .= '<li><a href="javascript:;">...</a></li>';
				}
				//显示数字页码
				for($i=$m; $i<=$b; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<li><a class="on">'.$i.'</a></li>';
					}
					else
					{
						//伪静态设置
						if($cfg_isreurl == 'Y' &&
						   !isset($keyword))
						{
							$pagetxt .= '<li><a href="'.$nowurl.'-'.$i.'.html" title="第 '.$i.' 页" class="on">'.$i.'</a></li>';
						}
						else
						{
							$pagetxt .= '<li><a href="'.$nowurl.'page='.$i.'" title="第 '.$i.' 页" class="on">'.$i.'</a></li>';
						}
					}
				}
				if($this->page < $this->totalpage-3)
				{
					$pagetxt .= '<li><a href="javascript:;">...</a></li>';
				}
			}
			//下一页 最后页
			if($this->page < $this->totalpage)
			{
				//伪静态设置
				if($cfg_isreurl == 'Y' &&
				   !isset($keyword))
				{
					$pagetxt .= '<li><a href="'.$nowurl.'-'.$next.'.html" title="下一页">&gt;</a></li>';
					//$pagetxt .= '<a href="'.$nowurl.'-'.$this->totalpage.'.html" title="尾页">尾页</a>';
				}
				else
				{
					$pagetxt .= '<li><a href="'.$nowurl.'page='.$next.'" title="下一页">&gt;</a></li>';
					//$pagetxt .= '<a href="'.$nowurl.'page='.$this->totalpage.'" title="尾页">尾页</a>';
				}
			}
			else
			{
				$pagetxt .= '<li><a href="javascript:;" title="下一页">&gt;</a></li>';
				//$pagetxt .= '<a href="javascript:;" title="尾页">尾页</a>';
			}
			$pagetxt .= '</ul></div>';
		}
		
		return $pagetxt;
	}
	//显示分页列表 wap
	function GetWapList()
	{
		global $cfg_isreurl,$keyword;
		$pagetxt = '';
		if($this->total <= $this->pagenum)
		{
			$pagetxt = '<div id="sabrosus" class="sabrosus">'.$this->total.'条记录</div>';
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
			
			$pagetxt = '';
			
			//上一页 第一页
			if($this->page >= 1)
			{
				$pagetxt .= '<a href="'.$nowurl.'-'.$previous.'.html" class="fl">上一页</a>';
				
			}
			else
			{
				$pagetxt .= '<a href="javascript:;" class="fl">上一页</a>';
			}
			if($this->totalpage){
				$pagetxt .= '<span>'.$this->page.'/'.$this->totalpage.'</span>';
			}
			/*//当总页数小于10
			if($this->totalpage <= 10)
			{
				for($i=1; $i <= $this->totalpage; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<a class="cpb">'.$i.'</a>';
					}
					else
					{
						$pagetxt .= '<a href="'.$nowurl.'page='.$i.'" title="第 '.$i.' 页">'.$i.'</a>';
					}
				}
			}
			else
			{
				if($this->page==1 or $this->page==2)
				{
					$m = 1;
					$b = 5;
				}
				//如果页面大于前2页并且小于后2页则显示当前页前后各2页链接
				if($this->page>2 and $this->page<$this->totalpage-1)
				{
					$m = $this->page-2;
					$b = $this->page+2;
				}
				//如果页面为最后三页则显示最后5页链接
				if($this->page==$this->totalpage or $this->page==$this->totalpage-1)
				{
					$m = $this->totalpage - 5;
					$b = $this->totalpage;
				}
				if($this->page > 3)
				{
					$pagetxt .= '<a href="javascript:;">...</a>';
				}
				//显示数字页码
				for($i=$m; $i<=$b; $i++)
				{
					if($this->page == $i)
					{
						$pagetxt .= '<a class="cpb">'.$i.'</a>';
					}
					else
					{
						$pagetxt .= '<a href="'.$nowurl.'page='.$i.'" title="第 '.$i.' 页">'.$i.'</a>';
					}
				}
				if($this->page < $this->totalpage-2)
				{
					$pagetxt .= '<a href="javascript:;">...</a>';
				}
			}
			*/
			//下一页 最后页
			if($this->page < $this->totalpage)
			{
				$pagetxt .= '<a href="'.$nowurl.'-'.$next.'.html" title="下一页" class="fr">下一页</a>';
			}
			else
			{
				$pagetxt .= '<a href="javascript:;" class="fr">下一页</a>';
			}
			$pagetxt .= '';
		}
		
		return $pagetxt;
	}
}
?>