<?php	
require_once(dirname(__FILE__).'/include/config.inc.php'); 
require_once(dirname(__FILE__).'/data/api/sms/SendTemplateSMS.php'); 

//初始化参数
$action = isset($action) ? $action : '';

//获取级联
if($action == 'getarea')
{
	$datagroup = isset($datagroup) ? $datagroup : '';
	$level     = isset($level)     ? $level     : '';
	$v         = isset($areaval)   ? $areaval   : '0';
	$str = '<option value="-1">--</option>';
	$sql = "SELECT * FROM `#@__cascadedata` WHERE level=$level And ";

	if($v == 0)
		$sql .= "datagroup='$datagroup'";
	else if($v % 500 == 0)
		$sql .= "datagroup='$datagroup' AND datavalue>$v AND datavalue<".($v + 500);
	else
		$sql .= "datavalue LIKE '$v.%%%' AND datagroup='$datagroup'";
	
	$sql .= " ORDER BY orderid ASC, datavalue ASC";
	$dosql->Execute($sql);
	while($row = $dosql->GetArray())
	{
		$str .= '<option value="'.$row['datavalue'].'">'.$row['dataname'].'</option>';
	}
	
	if($str == '') $str .= '<option value="-1">--</option>'; 
	echo $str;
	exit();
}else if($action == 'emailGo'){
	$email  = htmlspecialchars($email);
	$posttime = time();
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$r = $dosql->GetOne("select id from `#@__message` where (email='$email' and ip = '$ip' ) and posttime between $beginToday and $endToday");
	if($r && ($r['type'] == 1)){
		$info=array();
		$info['info']='您已成功订阅资讯，请不要重复订阅！';
		$info['status']='0';
		echo   json_encode($info);
		exit();
	}else{
		//入库
		$sql = "INSERT INTO `#@__message` (siteid, type, email, posttime, ip) 
									VALUES(1, 1, '$email', '$posttime', '$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';	//邮件接受者
			$time = date('Y-m-d H:i:s');
			$subject = "订阅资讯 - ProCloud";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>".$email." 在".$time."在网站订阅了资讯信息，请及时联系该用户！<br />来源：ProClouds.cn官网";
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='订阅成功！';
				$info['status']='1';
				echo   json_encode($info);
			}
			exit();
		}else{
			$info=array();
			$info['info']='订阅失败，请稍后再试！';
			$info['status']='0';
			echo   json_encode($info);
			exit();	
		}	
	}
}else if($action == 'showArticle'){
	$cid = htmlspecialchars($cid);
	$id = htmlspecialchars($id);
	$items = htmlspecialchars($items);
	//根据栏目类型选择数据表
	$data = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=$cid");
	$infotype = $data['infotype'];
	switch ($infotype){
		case 1:
			$sqlstrTable="infolist";
			break;
		case 2:
			$sqlstrTable="infoimg";
			break;
		case 3:
			$sqlstrTable="soft";
			break;
		default:
			$sqlstrTable="infolist";
			break;
	}
	echo '<script type="text/javascript">jQuery(".slideTxtBox_s").slide();</script>';
	echo '<div class="box_tit ovh">
            <div class="box_tit_cn class_name">'.GetCatName($cid).'</div>
            <span class="hr"></span>
         </div>';
	echo '<div class="slideTxtBox_s">';
	echo '<div class="hd">';
		echo '<ul>';
		$dosql->Execute("SELECT * FROM `#@__$sqlstrTable` WHERE classid=$cid ORDER BY orderid DESC,posttime DESC");
		$i = 1; 
		while($rowa=$dosql->GetArray()){ 
			if($items == $i){
				$class = "on";	
			}else{
				$class = "";
			}
			echo '<li class="'.$class.'"><p>'.$rowa['title'].'</p></li>';
			$i++;
		}	
		echo '</ul>';
	echo '</div>';
	echo '<div class="bd">';
		$dopage->GetPage("SELECT * FROM `#@__$sqlstrTable` WHERE classid=$cid ORDER BY orderid DESC,posttime DESC");
		while($rowb=$dosql->GetArray()){ 
			echo '<ul><div class="servce_con">'.$rowb['content'].'</div></ul>';
		}	
	echo '</div>';
	echo '</div>';                
	exit();
}else if($action == 'evaluation'){	//项目预算
	$llt_title   = htmlspecialchars($llt_title);
	$evaluation = htmlspecialchars($llt_budget);
	$llt_mobile = htmlspecialchars($llt_mobile);
	$llt_reference= htmlspecialchars($llt_reference);
	$content    = htmlspecialchars($llt_content);
	$siteid  = 1;
	$type = 3;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$r = $dosql->GetOne("select id from `#@__message` where (username = '".$llt_title."' and ip = '".$ip."' and type=3) and posttime between $beginToday and $endToday");
	if(empty($evaluation)){
		$info=array();
		$info['info']='选择项目预算';
		$info['status']='0';
		echo   json_encode($info);
		exit();
	}
	if($r){ 
		$info=array();
		$info['info']='今天您已成功提交,请勿再次提交!';
		$info['status']='0';
		echo   json_encode($info);
	}else{
		$content = '参考项目：'.$llt_reference.'<br />'.' 详情描述：'.$content;
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,username,evaluation,content,posttime,ip) VALUES (
										  '$siteid','$type','$llt_title','$evaluation','$content','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';	//邮件接受者
			$time = date('Y-m-d H:i:s');
			$subject = "免费评估，获取项目方案及报价 - ProCloud";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>".$llt_mobile." 在".$time."提交了免费评估，获取项目方案及报价，请及时联系查看！<br />";
			$body .= "项目：".$llt_title.'<br />';
			$body .= "预算：".$evaluation.'<br />';
			$body .= "参考项目：".$llt_reference.'<br />';
			$body .= "需求：".$content.'<br />';
			$body .= "来源：免费评估，获取项目方案及报价，ProClouds.cn官网";
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='提交成功,感谢您对我们的支持！';
				$info['status']='1';
				echo   json_encode($info);
			}
			
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			echo   json_encode($info);	
		}	
	}
	exit();
}else if($action == 'register'){	//企业注册
	$mobile   = htmlspecialchars($m_obile);
	$password = htmlspecialchars($p_assword);
	$siteid  = 1;
	$type = 4;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and ip = '".$ip."') and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功注册,请勿再次注册!';
		$info['status']='h';
		echo   json_encode($info);
	}else{
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,mobile,password,posttime,ip) VALUES (
										  '$siteid','$type','$mobile','$password','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';	//邮件接受者
			$time = date('Y-m-d H:i:s');
			$subject = "企业注册 - ProCloud";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>".$mobile." 在".$time."提交了企业注册，请及时联系该用户：".$mobile."！来源：ProClouds.cn官网";
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='注册成功,感谢您对我们的支持！';
				$info['status']='y';
				echo   json_encode($info);
			}
		}else{
			$info=array();
			$info['info']='注册失败，请联系本网站的客户服务！';
			$info['status']='n';
			echo   json_encode($info);	
		}	
	}
	exit();
}else if($action == 'message'){	//在线留言
	$username   = htmlspecialchars($u_name);
	$mobile      = htmlspecialchars($m_obile);
	$content    = htmlspecialchars($c_ontent);
	$siteid  = 1;
	$type = 2;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='n';
		echo   json_encode($info);
		exit();
	}
	if(!filter($content)){
		$info=array();
		$info['info']='请不要输入非法字符!';
		$info['status']='n';
		echo   json_encode($info);
		exit();		
	}
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and ip = '".$ip."') and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功留言,请勿再次留言!';
		$info['status']='h';
		echo   json_encode($info);
		exit();		
	}else{
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,username,mobile,content,posttime,ip) VALUES (
										  '$siteid','$type','$username','$mobile','$content','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';	//邮件接受者
			$time = date('Y-m-d H:i:s');
			$subject = "在线留言 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>".$username." 在".$time."在网站上留言了，请及时联系该用户！<br />";
			$body .= "姓名：".$username.'<br />';
			$body .= "电话".$mobile.'<br />';
			$body .= "内容：".$content.'<br />';
			$body .= "来源：www.kaifazhe.site官网";
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='留言成功,感谢您对我们的支持！';
				$info['status']='y';
				echo   json_encode($info);
				exit();		
			}
		}else{
			$info=array();
			$info['info']='注册失败，请联系本网站的客户服务！';
			$info['status']='n';
			echo   json_encode($info);	
			exit();		
		}	
	}
}else if($action == 'loadingMore'){	/* 加载新闻 */
	$list_num  = htmlspecialchars($list_num) + 1;
	$amount  = htmlspecialchars($amount);
	$cid  = htmlspecialchars($cid);
	$siteid  = 1;
	$dosql->Execute("SELECT * FROM `#@__infolist` WHERE classid=$cid AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT $list_num,$amount");
	$num = $dosql->GetTotalRow();
	$data = array();
	if(!$num){
		$data['info'] = 'not_more';
		echo json_encode($data);
		exit();				
	}else{
		while($row = $dosql->GetArray()){
			$data['lists'][] = array(
				'title' => $row['title'],
				'author' => $row['author'],
				'description' => $row['description'],
				'hits' => $row['hits'],
				'd' => MyDate('d',$row['posttime']),
				'year' => MyDate('Y',$row['posttime']),
				'm' => $domonth->month_e(intval(MyDate('m',$row['posttime']))),
				'gourl' => gourl($row['linkurl'],'content',$row['classid'],$row['id'])
			);		
		}
		echo json_encode($data);
		exit();				
	}
}else if($action == 'downloadMore'){ /* 加载pdf */
	$list_num  = htmlspecialchars($list_num);
	$amount  = htmlspecialchars($amount);
	$cid  = htmlspecialchars($cid);
	$siteid  = 1;
	$dosql->Execute("SELECT * FROM `#@__soft` WHERE classid=$cid AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT $list_num,$amount");
	$num = $dosql->GetTotalRow();
	$data = array();
	if(!$num){
		$data['info'] = 'not_more';
		echo json_encode($data);
		exit();
	}else{
		while($row = $dosql->GetArray()){
			$data['lists'][] = array(
				'title' => $row['title'],
				'author' => $row['author'],
				'description' => $row['description'],
				'hits' => $row['hits'],
				'd' => MyDate('d',$row['posttime']),
				'year' => MyDate('Y',$row['posttime']),
				'm' => $domonth->month_e(intval(MyDate('m',$row['posttime']))),
				'dlurl' => $row['dlurl']
			);		
		}
		echo json_encode($data);
		exit();		
	}
}else if($action == 'appList'){ /* app列表 type=mobile */
	$callback = $_GET['callback'];  
	$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=234 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC");
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'case_title' => $row['title'],
				'case_stitle' => $row['stitle'],
				'description' => $row['description'],
				'case_id' => $row['id'],
				'case_img' => 'http://www.kaifazhe.site/'.$row['case_img']
			);
		}
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)";
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'appDetail'){ //详情页面
	$callback = $_GET['callback'];  
	$case_id = $_GET['id'];	
	$info = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE checkinfo=true AND delstate='' AND id=$case_id");
	if($info){
		$info['status'] = 1;
		$info['case_title'] = $info['title'];
		$info['case_stitle'] = $info['stitle'];
		$info['case_content'] = $info['content'];
		$info['case_bimg'] = 'http://www.kaifazhe.site/'.$info['case_bimg'];
		$info['case_date'] = date('Y年m月d日',$info['posttime']);
		$case_tag = explode(',',$info['tag']);
		$case_tags = '';
		foreach($case_tag as $kk=>$vv){
			$case_tags .= '<em>'.getTag($vv).'</em>';	
		}
		$info['case_tag'] = $case_tags;
		$data = json_encode($info);
		echo $callback."($data)"; 
		exit();
	}else{
		$info['info'] = '该案例不存在或被管理员下架！';
		$data = json_encode($info);
		echo $callback."($data)"; 
		exit();
	}
}else if($action == 'webList'){ /* web列表 classid=233 */
	$callback = $_GET['callback']; 
	$type = $_GET['type'];
	switch($type){
		case 1:
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=233 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT 0,2");
			break;
		case 2:
			$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=233 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT 2,2");
			break;
	}
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'case_title' => $row['title'],
				'case_stitle' => $row['stitle'],
				'content' => $row['content'],
				'case_id' => $row['id'],
				'case_img' => 'http://www.kaifazhe.site/'.$row['case_img']
			);
		}
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)";
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'caseList'){ /* case列表 */
	$callback = $_GET['callback']; 
	$page     = $_GET['page'] ? $_GET['page']:0;
	$limit_num = 10;
	$start_page = intval($page*$limit_num);
	$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=233 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC limit ".$start_page.",".$limit_num);
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'case_title' => $row['title'],
				'case_id' => $row['id'],
				'case_tag' => $row['tag'],
				'case_stitle' => $row['stitle'],
				'case_author' => $row['author'] ? $row['author'] : 'ProCloud',
				'case_type' => getTypes($row['type']),
				'case_date' => date("Y-m-d", $row['posttime']),
				'case_img' => 'http://www.kaifazhe.site/'.$row['case_img'],
				'case_content' => $row['content']
			);
		}
		foreach($lists as &$v){
			$case_tags = explode(',',$v['case_tag']);
			foreach($case_tags as $vv){
				$v['case_tag'] .= getTag($vv).' ';
				$v['case_tags'] .= getTag($vv).' ';
			}
		}
		//var_dump($lists);
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'caseLists'){ /* wuhan case列表 */
	$callback = $_GET['callback'];  
	$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=233 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT 0,12");
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'case_title' => $row['title'],
				'case_id' => $row['id'],
				'case_tag' => $row['tag'],
				'case_stitle' => $row['stitle'],
				'case_author' => $row['author'] ? $row['author'] : 'ProCloud',
				'case_type' => getTypes($row['type']),
				'case_date' => date("Y-m-d", $row['posttime']),
				'case_img' => 'http://www.kaifazhe.site/'.$row['case_img'],
				'case_content' => $row['content']
			);
		}
		foreach($lists as &$v){
			$case_tags = explode(',',$v['case_tag']);
			foreach($case_tags as $vv){
				$v['case_tag'] .= getTag($vv).' ';
				$v['case_tags'] .= getTag($vv).' ';
			}
		}
		//var_dump($lists);
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'caseDetail'){ //详情页面 新闻
	$callback = $_GET['callback'];  
	$case_id = $_GET['id'];	
	$info = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE checkinfo=true AND delstate='' AND id=$case_id");
	if($info){
		$info['status'] = 1;
		$info['case_title'] = $info['title'];
		$info['case_stitle'] = $info['stitle'];
		$info['case_content'] = $info['content'];
		$info['case_bimg'] = 'http://www.kaifazhe.site/'.$info['case_bimg'];
		$info['case_date'] = date('Y年m月d日',$info['posttime']);
		$case_tag = explode(',',$info['tag']);
		$case_tags = '';
		foreach($case_tag as $kk=>$vv){
			$case_tags .= '<em>'.getTag($vv).'</em>';	
		}
		$info['case_tag'] = $case_tags;
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}else{
		$info['info'] = '该案例不存在或被管理员下架！';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}
}else if($action == 'newsList'){ /* news列表 */
	$callback = $_GET['callback'];  
	$dosql->Execute("SELECT * FROM `#@__infolist` WHERE classid=342 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC LIMIT 0,21");
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'id' => $row['id'],
				'title' => $row['title'],
				'date' => date("Y-m-d", $row['posttime']),
				'img' => 'http://www.kaifazhe.site/'.$row['picurl']				
			);
		}
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'newsDetail'){ //详情页面 新闻
	$callback = $_GET['callback'];  
	$id = $_GET['id'];	
	$info = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE checkinfo=true AND delstate='' AND id=$id");
	if($info){
		/* 上下篇 */
		$prev = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE classid=342 AND id > ".$id." AND delstate='' AND checkinfo=true");
		$next = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE classid=342 AND id < ".$id." AND delstate='' AND checkinfo=true order by id desc");
		
		$info['status'] = 1;
		$info['title'] = $info['title'];
		$info['content'] = $info['content'];
		$info['img'] = 'http://www.kaifazhe.site/'.$info['picurl'];
		$info['date'] = date('Y年m月d日',$info['posttime']);
		
		$info['prev'] = '上一篇：<a href="detail.html?id='.$prev['id'].'">' .$prev['title']. '</a>';
		$info['next'] = '下一篇：<a href="detail.html?id='.$next['id'].'">' .$next['title']. '</a>';
		
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}else{
		$info['info'] = '该案例不存在或被管理员下架！';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}
}else if($action == 'seoList'){ /* seo列表 */
	$callback = $_GET['callback'];  
	$dosql->Execute("SELECT * FROM `#@__infoimg` WHERE classid=343 AND checkinfo=true AND delstate='' ORDER BY orderid DESC,posttime DESC");
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'title' => $row['title'],
				'stitle' => $row['stitle'],
				'description' => $row['description'],
				'id' => $row['id'],
				'img' => 'http://www.kaifazhe.site/'.$row['case_img'],
				'img_list' => unserialize($row['picarr'])
			);
		}
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)";
		exit();
	}else{
		$data['info'] = '服务器繁忙中,请稍后再试！';
		$result = json_encode($data);
		echo $callback."($result)"; 
		exit();
	}
}else if($action == 'seoDetail'){ /* seo详情 */
	$callback = $_GET['callback'];  
	$id = $_GET['id'];	
	$info = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE checkinfo=true AND delstate='' AND id=$id");
	if($info){
		/* 上下篇 */
		$prev = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE classid=343 AND id > ".$id." AND delstate='' AND checkinfo=true");
		$next = $dosql->GetOne("SELECT * FROM `#@__infoimg` WHERE classid=343 AND id < ".$id." AND delstate='' AND checkinfo=true order by id desc");
		
		$info['status'] = 1;
		$info['title'] = $info['title'];
		$info['content'] = $info['content'];
		$info['img'] = 'http://www.kaifazhe.site/'.$info['picurl'];
		$info['img_list'] = unserialize($info['picarr']);
		$info['date'] = date('Y年m月d日',$info['posttime']);
		
		$info['prev'] = '上一篇：<a href="detail.html?id='.$prev['id'].'">' .$prev['title']. '</a>';
		$info['next'] = '下一篇：<a href="detail.html?id='.$next['id'].'">' .$next['title']. '</a>';
		
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}else{
		$info['info'] = '该案例不存在或被管理员下架！';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}
}else if($action == 'procloudProduct'){ /* procloud产品 */
	$callback = $_GET['callback'];  
	$dosql->Execute("SELECT * FROM `#@__procloud` ORDER BY sort_id ASC");
	$num = $dosql->GetTotalRow();
	if($num){
		while($row = $dosql->GetArray()){
			$lists[] = array(
				'name' => $row['name'],
				'url' => $row['url'],
			);
		}
		$data['status'] = 1;
		$data['lists'] = $lists;
		$result = json_encode($data);
		echo $callback."($result)";
		exit();
	}
}else if($action == 'appForm'){	//app表单提交
	$callback = $_GET['callback']; 
	$username   = htmlspecialchars($username);
	$mobile      = htmlspecialchars($mobile);
	$content    = htmlspecialchars($content);
	$evaluation    = htmlspecialchars($evaluation);
	$url_from    = htmlspecialchars($url_from);
	$siteid  = 1;
	$type = 5;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}
	if(!filter($content)){
		$info=array();
		$info['info']='请不要输入非法字符!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and ip = '".$ip."' and type = 5) and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功提交项目评估,请勿再次提交!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}else{
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,username,mobile,content,evaluation,url_from,posttime,ip) VALUES (
										  '$siteid','$type','$username','$mobile','$content','$evaluation','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "项目评估 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>";
			$body .= $username.' 在'.$time.'在网站上提交了项目评估，请及时联系该用户！<br />';
			$body .= "姓名：".$username.'<br />';
			$body .= "电话".$mobile.'<br />';
			$body .= "内容：".$content.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='提交成功,感谢您对我们的支持！';
				$info['status']='1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			$data = json_encode($info);
			echo $callback."($data)";	
			exit();		
		}	
	}
}else if($action == 'downloadQuote'){	//下载报价（web）
	$callback = $_GET['callback']; 
	$mobile   = htmlspecialchars($mobile);
	$email    = htmlspecialchars($email);
	$package  = htmlspecialchars($package);
	$url_from = htmlspecialchars($url_from);
	$siteid  = 1;
	$type = 6;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and email = '".$email."' and ip = '".$ip."' and type = 6) and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功提交下载报价,请勿再次提交，我们会在24小时内跟您联系!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}else{
		switch($package){
				case 1:
					$content = '青铜站点套餐 RMB 999';
					break;
				case 2:
					$content = '白银站点套餐 RMB 3999';
					break;
				case 3:
					$content = '黄金站点套餐 RMB 5999';
					break;
				case 4:
					$content = '钻石站点套餐 RMB 9999';
					break;
				default :
				  $content = '青铜站点套餐 RMB 999';
				  break;
			}
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,mobile,email,content,url_from,posttime,ip) VALUES (
										  '$siteid','$type','$mobile','$email','$content','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "下载报价 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/> 用户";
			$body .= $mobile.' 在'.$time.'在网站上提交了响应式官网下载报价，请及时联系该用户！<br />';
			$body .= "手机：".$mobile.'<br />';
			$body .= "邮箱：".$email.'<br />';
			$body .= "报价方案：".$content.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info'] = '提交成功，稍后我们的客户经理会联系您，感谢您对我们的支持！';
				$info['status'] = '1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			$data = json_encode($info);
			echo $callback."($data)";	
			exit();		
		}	
	}
}else if($action == 'liveQuote'){	//下载报价（直播）
	$callback = $_GET['callback']; 
	$mobile   = htmlspecialchars($mobile);
	$email    = htmlspecialchars($email);
	$live     = htmlspecialchars($package);
	$url_from = htmlspecialchars($url_from);
	$siteid  = 1;
	$type = 7;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and email = '".$email."' and ip = '".$ip."' and type = 7) and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功提交下载报价,请勿再次提交，我们会在24小时内跟您联系!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}else{
		switch($live){
				case 1:
					$content = '购买源代码 RMB 2999';
					break;
				case 2:
					$content = '源代码上架及部署服务 RMB 9999';
					break;
				case 3:
					$content = '源代码二次开发及上架部署服务 RMB 29999';
					break;
				default :
				  $content = '购买源代码 RMB 999';
				  break;
			}
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,mobile,email,content,url_from,posttime,ip) VALUES (
										  '$siteid','$type','$mobile','$email','$content','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "下载报价 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/> 用户";
			$body .= $mobile.' 在'.$time.'在网站上提交了直播源码报价方案，请及时联系该用户！<br />';
			$body .= "手机：".$mobile.'<br />';
			$body .= "邮箱：".$email.'<br />';
			$body .= "源码方案：".$content.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info'] = '提交成功，稍后我们的客户经理会联系您，感谢您对我们的支持！';
				$info['status'] = '1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			$data = json_encode($info);
			echo $callback."($data)";	
			exit();		
		}	
	}
}else if($action == 'itoQuote'){	//下载报价（ito）
	$callback = $_GET['callback']; 
	$mobile   = htmlspecialchars($mobile);
	$email    = htmlspecialchars($email);
	$ito      = htmlspecialchars($ito);
	$url_from = htmlspecialchars($url_from);
	$siteid  = 1;
	$type = 8;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}
	$r = $dosql->GetOne("select id from `#@__message` where (mobile = '".$mobile."' and email = '".$email."' and ip = '".$ip."' and type = 8) and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功提交下载报价,请勿再次提交，我们会在24小时内跟您联系!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}else{
		switch($ito){
				case 1:
					$content = '单次上门服务 RMB 180 起/次';
					break;
				case 2:
					$content = '随叫随到网管 RMB 980 起/月';
					break;
				case 3:
					$content = '定点式驻员IT RMB 1980 起/月';
					break;
				case 3:
					$content = '长期驻员外包 RMB 5580 起/月';
					break;
				default :
				  $content = '单次上门服务 180 起/次';
				  break;
			}
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,mobile,email,content,url_from,posttime,ip) VALUES (
										  '$siteid','$type','$mobile','$email','$content','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "下载报价 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/> 用户";
			$body .= $mobile.' 在'.$time.'在网站上提交了直播源码报价方案，请及时联系该用户！<br />';
			$body .= "手机：".$mobile.'<br />';
			$body .= "邮箱：".$email.'<br />';
			$body .= "IT维护服务套餐：".$content.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info'] = '提交成功，稍后我们的客户经理会联系您，感谢您对我们的支持！';
				$info['status'] = '1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			$data = json_encode($info);
			echo $callback."($data)";	
			exit();		
		}	
	}
}else if($action == 'itoSubmit'){	//留言（ito）
	$callback = $_GET['callback']; 
	$fullname = htmlspecialchars($fullname);
	$mobile   = htmlspecialchars($mobile);
	$url_from = htmlspecialchars($url_from);
	$message  = htmlspecialchars($message);
	$siteid  = 1;
	$type = 9;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(empty($fullname) || empty($mobile)){
		$info=array();
		$info['info']='姓名和手机号码不能为空，请补全信息，方便更好的为您服务!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();	
	}
	$r = $dosql->GetOne("select id from `#@__message` where (username = '".$username."' and mobile = '".$mobile."' and ip = '".$ip."' and type = 9) and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功留言,请勿再次提交，我们会在24小时内跟您联系!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}else{
		//入库
		$sql = "INSERT INTO `#@__message` ( siteid,type,username,mobile,content,url_from,posttime,ip) VALUES (
										  '$siteid','$type','$fullname','$mobile','$message','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "ito留言 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/> 用户";
			$body .= $fullname.' 在'.$time.'在网站上提交了留言，请及时联系该用户！<br />';
			$body .= "姓名：".$fullname.'<br />';
			$body .= "手机：".$mobile.'<br />';
			$body .= "内容：".$message.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info'] = '提交成功，稍后我们的客户经理会联系您，感谢您对我们的支持！';
				$info['status'] = '1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info']='提交失败，请联系本网站的客户服务！';
			$info['status']='0';
			$data = json_encode($info);
			echo $callback."($data)";	
			exit();		
		}	
	}
}else if($action == 'wuhanForm'){	//武汉官网
	$callback = $_GET['callback']; 
	$username   = htmlspecialchars($username);
	$tel        = htmlspecialchars($tel);
	$mess       = htmlspecialchars($mess);
	$url_from    = htmlspecialchars($url_from);
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$tel)){  
		$info=array();
		$info['info']='请输入正确的手机号码!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();
	}
	if(!filter($mess)){
		$info=array();
		$info['info']='请不要输入非法字符!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();		
	}
	$info=array();
	/*if($beginToday < time() || time() > $endToday){
		$info['info']='您已成功提交留言信息,请勿再次提交!';
		$info['status']='0';
		$data = json_encode($info);
		echo $callback."($data)";
		exit();	
	}else{*/
		//邮件发送
		$mailreceive = '1586498033@qq.com';
		$time = date('Y-m-d H:i:s');
		$subject = "官网留言 - ProClouds-朴讯软件（湖北）有限公司";	//邮件主题
		$body = "尊敬 ".$mailreceive."：<br/>";
		$body .= $username.' 在'.$time.'在网站上提交了留言信息，请及时联系该用户！<br />';
		$body .= "姓名：".$username.'<br />';
		$body .= "电话：".$tel.'<br />';
		$body .= "内容：".$mess.'<br />';
		$body .= "来源：".$url_from;
		$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
		if($result){
			$info['info']='提交成功,感谢您对我们的支持！';
			$info['status']='1';
			$data = json_encode($info);
			echo $callback."($data)";
			exit();		
		}
	/* } */
}else if($action == 'checkCode'){
	$llt_code   = htmlspecialchars($llt_code);
	$info=array();
	if($llt_code == '' || $llt_code != strtolower(GetCkVdValue())){
		$info['info'] = '请输入正确的验证码';
		$info['status'] = 0;
		echo json_encode($info);
		exit();		
	}else{
		$info['status'] = 1;
		echo json_encode($info);
		exit();		
	}
}else if($action == 'sendSms'){	//发送短信
	$llt_mobile      = htmlspecialchars($llt_mobile);
	$info=array();
	if($llt_mobile == '' || !preg_match("/^1[34578]{1}\d{9}$/",$llt_mobile)){  
		$info['info']='手机号码不能为空且为正确的格式';
		$info['status']='0';
		echo json_encode($info);
		exit();
	}
	//发送短信
	session_start();	//开启session
	$_SESSION['verify'] = rand(1000,9999);
	$_SESSION['time'] = date("Y-m-d H:i:s");	//缓存时间，记录发送时间
	$expired = '10分钟';								//过期时间，1分钟
	/* 发送短信，并保存session中 */
	$result = sendTemplateSMS($llt_mobile,array($_SESSION['verify'],$expired),"221614");
	if($result){ 
		$info['info']='发送成功，请查收';
		$info['status']=1;
		echo json_encode($info);
		exit();		
	}else{
		$info['info']='发送失败，点击重新发送';
		$info['status']= 0;
		echo   json_encode($info);
		exit();		
	}
	//如果时间超过60s则清除session
	if((strtotime($_SESSION['time'])+60) < time()) {
		session_destroy();
	}
}else if($action == 'checkVerify'){
	$verify  = htmlspecialchars($llt_smscode);
	session_start();	//开启session
	$info = array();
	if((strtotime($_SESSION['time'])+60)<time()) {	//将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
		session_destroy();
        //unset($_SESSION);
		$info['info'] = '验证码已过期，请重新获取！';
		$info['status'] = 0;
		echo   json_encode($info);
		exit();
	}else{
		if($verify == $_SESSION['verify']){
			$info['info'] = '验证码正确！';
			$info['status'] = 1;
			echo   json_encode($info);
			exit();			
		}else{
			$info['info'] = '验证码错误！';
			$info['status'] = 0;
			echo   json_encode($info);	
			exit();
		}
	}
}else if($action == 'evaluation'){	//免费评估
	$title   = htmlspecialchars($llt_title);
	$mobile  = htmlspecialchars($llt_mobile);
	$budget  = htmlspecialchars($llt_budget);
	$reference = htmlspecialchars($llt_reference);
	$content    = htmlspecialchars($llt_content);
	$url_from    = htmlspecialchars($url_from);
	$siteid  = 1;
	$posttime = GetMkTime(time());
	$ip       = $_SERVER['REMOTE_ADDR'];
	//一个用户名只能提交一次(24小时内)
	$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info=array();
		$info['info'] = '请输入正确的手机号码!';
		$info['status'] = 0;
		echo json_encode($info);
		exit();
	}
	if(!filter($content)){
		$info=array();
		$info['info'] = '请不要输入非法字符!';
		$info['status'] = 0;
		echo json_encode($info);
		exit();		
	}
	$r = $dosql->GetOne("select id from `#@__evaluate` where (mobile = '".$mobile."' and ip = '".$ip."') and posttime between $beginToday and $endToday");
	if($r){ 
		$info=array();
		$info['info']='您已成功提交项目评估,请勿再次提交!';
		$info['status']=0;
		echo json_encode($info);
		exit();		
	}else{
		//入库
		$sql = "INSERT INTO `#@__evaluate` ( siteid,title,budget,mobile,content,reference,url_from,posttime,ip) VALUES (
										  '$siteid','$title','$budget','$mobile','$content','$reference','$url_from','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			//邮件发送
			$mailreceive = '1586498033@qq.com';
			$time = date('Y-m-d H:i:s');
			$subject = "免费评估 - ProClouds";	//邮件主题
			$body = "尊敬 ".$mailreceive."：<br/>";
			$body .= $mobile.' 在 '.$time.' 提交了免费评估，获取项目方案及报价，请及时联系该用户！<br />';
			$body .= "项目：".$budget.'<br />';
			$body .= "参考项目：".$reference.'<br />';
			$body .= "详细需求：".$content.'<br />';
			$body .= "联系方式：".$mobile.'<br />';
			$body .= "来源：".$url_from;
			$result = smtp_mail($mailreceive,$subject,$body,$mailreceive,$mailreceive);
			if($result){
				$info=array();
				$info['info']='提交成功,感谢您对我们的支持！';
				$info['status']='1';
				$data = json_encode($info);
				echo $callback."($data)";
				exit();		
			}
		}else{
			$info=array();
			$info['info'] = '提交失败，请联系本网站的客户服务！';
			$info['status'] = 0;
			echo json_encode($info);	
			exit();		
		}	
	}
}else if($action == 'dowload'){	//下载
	$dowloadId   = htmlspecialchars($dowloadId);
	
	//入库
	$sql = "UPDATE `#@__soft` SET downloads =  downloads + 1 where id = ".$dowloadId;
	$dosql->ExecNoneQuery($sql);
}else{//无条件返回
	exit('请求出错!');	
}
?>