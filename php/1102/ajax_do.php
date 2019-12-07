<?php
require_once(dirname(__FILE__).'/include/config.inc.php'); 
if(!isset($_SESSION)) session_start();
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
}else if($action == 'uploadFile'){
	//判断是否上传文件
	if(!empty($_FILES['headimg']['name'])){
		$file_size = $_FILES['headimg']['size'];  
		if($file_size > 2*1024*1024) {  
			ShowMsg("文件过大，不能上传大于2M的文件","-1");
			exit();  
		}  
		$file_type = $_FILES['headimg']['type'];  
		
		if($file_type!="image/jpeg" && $file_type!='image/pjpeg' && $file_type!='image/png') {  
			ShowMsg("文件类型只能为jpg格式或png格式","-1");
			exit();  
		}  
		//判断是否上传成功（是否使用post方式上传）  
		if(is_uploaded_file($_FILES['headimg']['tmp_name'])) {  
			//把文件转存到你希望的目录（不要使用copy函数）  
			$uploaded_file=$_FILES['headimg']['tmp_name'];  
	  
			//我们给每个用户动态的创建一个文件夹  
			$user_path = $_SERVER['DOCUMENT_ROOT']."/uploads/image/avatar";  
			//判断该用户文件夹是否已经有这个文件夹  
			if(!file_exists($user_path)) {  
				mkdir($user_path);  
			}  
			 
			$file_true_name = $_FILES['headimg']['name'];  //文件真实名字
			$file_name = time().rand(1000,9999).substr($file_true_name,strrpos($file_true_name,".")); //文件保存名字
			$move_to_file = $user_path."/".$file_name; 	  	//移动文件 
			$headimg = "/uploads/image/avatar/".$file_name;  //文件保存路径
			
			$create_time = time();
			if(move_uploaded_file($uploaded_file,$move_to_file)) {  
				$sql = "INSERT INTO `#@__images` (  picurl, create_time ) VALUES( '$headimg', '$create_time')";
				if($dosql->ExecNoneQuery($sql))
				{
					ShowMsg("上传成功","-1");
					exit(); 
				}				
			} else {  
				ShowMsg("上传失败","-1");
				exit(); 
			}  
		} else {  
			ShowMsg("上传失败","-1");
			exit(); 
		}  
	} else{
		ShowMsg("你没有选择文件","-1");
		exit(); 
	}
}else if($action == 'editRoom'){	//宿舍
	$uid = htmlspecialchars($uid);
	$school_name = htmlspecialchars($school_name);
	$name = htmlspecialchars($name);
	$student_id = htmlspecialchars($student_id);
	$dormitory = htmlspecialchars($dormitory);
	$dormitory_number = htmlspecialchars($dormitory_number);
	$content = htmlspecialchars($content);
	$create_time = time();
	$roomInfo = $dosql->GetOne("select * from `#@__dormitory` where uid=".$uid." and name='".$name."'");
	if($roomInfo){
		//更新
		$sql = "UPDATE `#@__dormitory` set school_name='$school_name', name='$name', student_id='$student_id', 
							dormitory='$dormitory', dormitory_number='$dormitory_number', content='$content', create_time='$create_time' where uid = $uid";
		if($dosql->ExecNoneQuery($sql))
		{	
			ShowMsg("提交成功","-1");
				exit(); 	
		}else{
			ShowMsg("提交失败，请稍后再试！","-1");
				exit(); 	
		}
	}else{
		//入库
		$sql = "INSERT INTO `#@__dormitory` ( uid, school_name, name, student_id, dormitory, dormitory_number, content, create_time) VALUES (
										  '$uid', '$school_name', '$name', '$student_id', '$dormitory', '$dormitory_number', '$content', '$create_time')";
		if($dosql->ExecNoneQuery($sql))
		{	
			ShowMsg("提交成功","-1");
			exit(); 	
		}else{
			ShowMsg("提交失败，请稍后再试！","-1");
				exit(); 	
		}
	}
}else if($action == 'certification'){	//学籍认证
	$uid = htmlspecialchars($uid);
	$school_name = htmlspecialchars($school_name);
	$name = htmlspecialchars($name);
	$student_id = htmlspecialchars($student_id);
	$academic_website_account = htmlspecialchars($academic_website_account);
	$academic_website_passwd = htmlspecialchars($academic_website_passwd);
	$create_time = time();
	$Info = $dosql->GetOne("select * from `#@__school_roll` where uid=".$uid." and name='".$name."'");
	$msg = array();
	if($Info){
		//更新
		$sql = "UPDATE `#@__school_roll` set school_name='$school_name', name='$name', student_id='$student_id', 
							academic_website_account='$academic_website_account', academic_website_passwd='$academic_website_passwd', create_time='$create_time' where uid = $uid";
		if($dosql->ExecNoneQuery($sql))
		{	
			$msg['status'] = 1;
			$msg['info'] = "提交审核，请耐心等待审核！";
			echo json_encode($msg);
			exit(); 	
		}else{
			$msg['status'] = 0;
			$msg['info'] = "提交失败，请稍后再试！";;
			echo json_encode($msg);
			exit(); 	 	
		}
	}else{
		//入库
		$sql = "INSERT INTO `#@__school_roll` ( uid, school_name, name, student_id, academic_website_account, academic_website_passwd, create_time) VALUES (
										  '$uid', '$school_name', '$name', '$student_id', '$academic_website_account', '$academic_website_passwd', '$create_time')";
		if($dosql->ExecNoneQuery($sql))
		{	
			$msg['status'] = 1;
			$msg['info'] = "提交审核，请耐心等待审核！";
			echo json_encode($msg);
			exit(); 
		}else{
			$msg['status'] = 0;
			$msg['info'] = "提交失败，请稍后再试！";;
			echo json_encode($msg);
			exit(); 	
		}
	}
}else if($action == 'message'){	//在线留言
	$username   = htmlspecialchars($u_name);
	$mobile     = htmlspecialchars($m_obile);
	$email      = htmlspecialchars($e_mail);
	$content    = htmlspecialchars($c_ontent);
	$siteid  = 1;
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
		$sql = "INSERT INTO `#@__message` ( siteid,username,mobile,email,content,posttime,ip) VALUES (
										  '$siteid','$username','$mobile','$email','$content','$posttime','$ip')";
		if($dosql->ExecNoneQuery($sql))
		{	
			$info=array();
			$info['info']='留言成功,感谢您对我们的支持！';
			$info['status']='y';
			echo   json_encode($info);
			exit();		
		}else{
			$info=array();
			$info['info']='留言失败，请联系本网站的客户服务！';
			$info['status']='n';
			echo   json_encode($info);	
			exit();		
		}	
	}
}else if($action == 'usercomment'){	//用户评论
	$aid   = htmlspecialchars($aid);
	$molds = htmlspecialchars($molds);
	$body  = htmlspecialchars($body);
	$time  = time();
	$ip    = $_SERVER['REMOTE_ADDR'];
	
	//入库
	$sql = "INSERT INTO `#@__usercomment` ( aid,molds,body,time,ip) VALUES (
										  '$aid','$molds','$body','$time','$ip')";
	$info=array();
	if($dosql->ExecNoneQuery($sql))
	{	
		$info['info']='评论成功';
		$info['status']=1;
		echo   json_encode($info);
		exit();			
	}else{
		$info['info']='评论失败';
		$info['status']=0;
		echo   json_encode($info);
		exit();	
	}	
}else if($action == 'userfavorite'){	//用户收藏
	$uid   = htmlspecialchars($uid);
	$aid   = htmlspecialchars($aid);
	$type  = htmlspecialchars($type);
	$create_time  = time();
	$info=array();
	//入库
	if($type == 1){
		$sql = "INSERT INTO `#@__userfavorite` ( uid,aid,create_time) VALUES (
										  '$uid','$aid','$create_time')";
		if($dosql->ExecNoneQuery($sql))
		{	
			$info['info'] = '收藏成功！';
			$info['status'] = 1;
			echo   json_encode($info);
			exit();			
		}else{
			$info['info'] = '收藏失败，请稍后再试！';
			$info['status'] = 0;
			echo   json_encode($info);
			exit();	
		}
	}else{
		$sql = "delete from `#@__userfavorite` where aid = ".$aid." and uid =".$uid;
		if($dosql->ExecNoneQuery($sql))
		{	
			$info['status'] = 1;
			echo   json_encode($info);
			exit();			
		}else{
			$info['info'] = '服务器异常，请稍后再试！';
			$info['status'] = 0;
			echo   json_encode($info);
			exit();	
		}
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
	$mobile      = htmlspecialchars($mobile);
	$info=array();
	if($mobile == '' || !preg_match("/^1[34578]{1}\d{9}$/",$mobile)){  
		$info['info']='手机号码不能为空且为正确的格式';
		$info['status']='0';
		echo json_encode($info);
		exit();
	}
	//发送短信
	$_SESSION['verify'] = rand(1000,9999);
	$_SESSION['time'] = date("Y-m-d H:i:s");			//缓存时间，记录发送时间
	$expired = '10分钟';								//过期时间，10分钟
	/* 发送短信，并保存session中 */
	$result = send_sms($mobile,$_SESSION['verify']);
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
	if((strtotime($_SESSION['time'])+600) < time()) {
		session_destroy();
	}
}else if($action == 'checkVerify'){
	$verify  = htmlspecialchars($llt_smscode);
	session_start();	//开启session
	$info = array();
	if((strtotime($_SESSION['time'])+600)<time()) {	//将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
		session_destroy();
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
}else if($action == 'userLogin'){	//登录
	$username = htmlspecialchars($username);
	//$code     = htmlspecialchars($code);
	$password = htmlspecialchars($password);
	$password = md5(md5($password));
	$logintime= time();
	$loginip  = $_SERVER['REMOTE_ADDR'];
	$info = array();
	//比对验证码
	/*if((strtotime($_SESSION['time'])+600)<time()) {	//将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
		session_destroy();
		$info['info'] = '验证码已过期，请重新获取！';
		$info['status'] = 0;
		echo   json_encode($info);
		exit();
	}else{
		if($code != $_SESSION['verify']){
			$info['info'] = '验证码错误！';
			$info['status'] = 0;
			echo   json_encode($info);	
			exit();	
		}
	}*/
	/* 登录 */
	$user_info = $dosql->GetOne("select * from `#@__member` where mobile = '".$username."' and password='". $password ."'");
	if($user_info){	//用户存在
		$_SESSION["uid"] = $user_info['id'];
		$info['info'] = '登录成功！';
		$sql = "UPDATE `#@__member` SET logintime='$logintime',loginip='$loginip' WHERE mobile='".$username."'";
		$dosql->ExecNoneQuery($sql);
		$info['status'] = 1;
		$info['url'] = 'memberInfo.php';
		echo   json_encode($info);	
		exit();
	}else{	//用户不存在
		/*$sql = "INSERT INTO `#@__member` ( username,mobile,regtime,regip,logintime,loginip) VALUES (
									  '$username','$username','$regtime','$regip','$regtime','$regip')";
		if($dosql->ExecNoneQuery($sql)){
			$uid = $dosql->GetLastID();
			$_SESSION["uid"] = $uid;
			$info['status'] = 1;
			$info['info'] = '登录成功';
			$info['url'] = 'memberInfo.php';
			echo   json_encode($info);	
			exit();
		}else{
			$info['status'] = 0;
			$info['info'] = '登录失败，请稍后再试';
			echo   json_encode($info);	
			exit();
		}*/
		$info['info'] = '用户名或密码不正确，请重新输入！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
}else if($action == 'userRegister'){	//注册
	$mobile = htmlspecialchars($mobile);
	//$code     = htmlspecialchars($code);
	$password = htmlspecialchars($password);
	$password = md5(md5($password));
	$repassword = htmlspecialchars($repassword);
	$repassword = md5(md5($repassword));
	
	$regtime = time();
	$regip   = $_SERVER['REMOTE_ADDR'];
	$info = array();
	
	//比对验证码
	/*if((strtotime($_SESSION['time'])+600)<time()) {	//将获取的缓存时间转换成时间戳加上60秒后与当前时间比较，小于当前时间即为过期
		session_destroy();
		$info['info'] = '验证码已过期，请重新获取！';
		$info['status'] = 0;
		echo   json_encode($info);
		exit();
	}else{
		if($code != $_SESSION['verify']){
			$info['info'] = '验证码错误！';
			$info['status'] = 0;
			echo   json_encode($info);	
			exit();	
		}
	}*/
	
	if($password != $repassword){
		$info['info'] = '两次密码输入不一样';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	/* 注册 */
	$user_info = $dosql->GetOne("select * from `#@__member` where mobile = '".$mobile."'");
	if($user_info){	//用户已存在
		$info['info'] = '手机号码已存在，注册失败';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}else{	//用户不存在
		$sql = "INSERT INTO `#@__member` ( username,mobile,password,regtime,regip,logintime,loginip) VALUES (
									  '$mobile','$mobile','$password','$regtime','$regip','$regtime','$regip')";
		if($dosql->ExecNoneQuery($sql)){
			$uid = $dosql->GetLastID();
			$_SESSION["uid"] = $uid;
			$info['status'] = 1;
			$info['info'] = '注册成功';
			$info['url'] = 'memberInfo.php';
			echo   json_encode($info);	
			exit();
		}else{
			$info['status'] = 0;
			$info['info'] = '注册失败';
			echo   json_encode($info);	
			exit();
		}
	} 
}else if($action == 'updatePassword'){	//修改密码
	$mobile = htmlspecialchars($mobile);
	$oldpassword = htmlspecialchars($oldpassword);
	$oldpassword = md5(md5($oldpassword));
	$newpassword = htmlspecialchars($newpassword);
	$newpassword = md5(md5($newpassword));
	$repassword = htmlspecialchars($repassword);
	$repassword = md5(md5($repassword));
	$logintime = time();
	$loginip   = $_SERVER['REMOTE_ADDR'];
	$info = array();
	
	/* 修改密码 */
	$user_info = $dosql->GetOne("select * from `#@__member` where username = '".$username."'");
	if(!$user_info){
		$info['info'] = '用户不存在，请检查您的用户名是否输入正确';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	if($oldpassword != $user_info['password']){
		$info['info'] = '旧密码输入不正确';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	if($newpassword != $repassword){
		$info['info'] = '两次密码输入不一样';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	
	$sql = "UPDATE `#@__member` SET password='$newpassword',logintime='$logintime',loginip='$loginip' WHERE username='".$username."'";
	if($dosql->ExecNoneQuery($sql)){
		$_SESSION["uid"] = $user_info['id'];
		$info['status'] = 1;
		$info['info'] = '重置成功';
		$info['url'] = 'member.php';
		echo   json_encode($info);	
		exit();
	}else{
		$info['status'] = 0;
		$info['info'] = '重置失败';
		echo   json_encode($info);	
		exit();
	}
}else if($action == 'repeatPassword'){	//重置密码
	$mobile = htmlspecialchars($mobile);
	$password = htmlspecialchars($password);
	$password = md5(md5($password));
	
	$repassword = htmlspecialchars($repassword);
	$repassword = md5(md5($repassword));
	
	$logintime = time();
	$loginip   = $_SERVER['REMOTE_ADDR'];
	$info = array();
	
	/* 重置密码 */
	$user_info = $dosql->GetOne("select * from `#@__member` where mobile = '".$mobile."'");
	if(!$user_info){
		$info['info'] = '用户不存在，请检查您的用户名是否输入正确';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	if($password != $repassword){
		$info['info'] = '两次密码输入不正确';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	
	$sql = "UPDATE `#@__member` SET password='$password', logintime='$logintime', loginip='$loginip' WHERE mobile='".$mobile."'";
	if($dosql->ExecNoneQuery($sql)){
		$_SESSION["uid"] = $user_info['id'];
		$info['status'] = 1;
		$info['info'] = '重置成功';
		$info['url'] = 'memberInfo.php';
		echo   json_encode($info);	
		exit();
	}else{
		$info['status'] = 0;
		$info['info'] = '重置失败';
		echo   json_encode($info);	
		exit();
	}
}else if($action == 'forgetPasswd'){	//忘记密码
	$username = htmlspecialchars($username);
	$mobile   = htmlspecialchars($mobile);
	$info = array();
	
	/* 重置密码 */
	$user_info = $dosql->GetOne("select * from `#@__member` where username = '".$username."' and mobile = '". $mobile ."'");
	if(!$user_info){
		$info['info'] = '您输入的姓名和手机号码比对不正确，请检查输入！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}else{
		$info['status'] = 1;
		$info['info'] = '信息验证正通过！';
		$info['url'] = 'repeatPasswd.php';
		echo   json_encode($info);	
		exit();
	}
}else if($action == 'sendMsg'){	//发送消息
	$content    = htmlspecialchars($content);
	$sender_id  = intval($sender_id);
	$receiver_id= intval($receiver_id);
	$create_time= time();
	//入库
	$sql = "INSERT INTO `#@__msg` ( sender_id, receiver_id, relationship_id, content, create_time) VALUES (
								'$sender_id','$receiver_id','$sender_id', '$content', '$create_time')";
	$info=array();
	if(!$dosql->ExecNoneQuery($sql))
	{	
		$info['info'] = '发送失败，请检查网络是否连接正常！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();		
	}else{
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET last_activetime=". $create_time ." WHERE id=".$sender_id);
	}
}else if($action == 'activeSub'){	//发布活动
	$uid   = htmlspecialchars($uid);
	$title   = htmlspecialchars($title);
	$category_id   = htmlspecialchars($category_id);
	$attr_id     = htmlspecialchars($attr_id);
	$tag_ids      = htmlspecialchars($tag_ids);
	$address   = htmlspecialchars($address);
	$description = htmlspecialchars($description);
	$content      = htmlspecialchars($content);
	$apply_time   = strtotime(htmlspecialchars($apply_time));
	$end_time    = strtotime(htmlspecialchars($end_time));
	$begins_time    = strtotime(htmlspecialchars($begins_time));
	$ends_time    = strtotime(htmlspecialchars($ends_time));
	$expval = htmlspecialchars($expval);
	$integral = htmlspecialchars($integral);
	$create_time = time();
	
	$category_id = get_category_id($category_id);	//分类id
	$attr_id = get_attr_id($attr_id);				//所属组织id
	$tag_ids = rtrim($tag_ids, ',');						//分类id
	
	//判断是否上传文件
	if(!empty($_FILES['picurl']['name'])){
		$file_size = $_FILES['picurl']['size'];  
		if($file_size > 20*1024*1024) {  
			ShowMsg("文件过大，不能上传大于20M的文件","-1");
			exit();  
		}  
	  
		$file_type = $_FILES['picurl']['type'];  
		
		if($file_type!="image/jpeg" && $file_type!='image/pjpeg' && $file_type!='image/png') {  
			ShowMsg("文件类型只能为jpg格式或png格式","-1");
			exit();  
		}  
		//判断是否上传成功（是否使用post方式上传）  
		if(is_uploaded_file($_FILES['picurl']['tmp_name'])) {  
			//把文件转存到你希望的目录（不要使用copy函数）  
			$uploaded_file=$_FILES['picurl']['tmp_name'];  
			//我们给每个用户动态的创建一个文件夹  
			$user_path = $_SERVER['DOCUMENT_ROOT']."/uploads/image/active";  
			//判断该用户文件夹是否已经有这个文件夹  
			if(!file_exists($user_path)) {  
				mkdir($user_path);  
			}  
			$file_true_name = $_FILES['picurl']['name'];  //文件真实名字
			$file_name = time().rand(1000,9999).substr($file_true_name,strrpos($file_true_name,".")); //文件保存名字
			$move_to_file = $user_path."/".$file_name; 	  	//移动文件 
			if(move_uploaded_file($uploaded_file,$move_to_file)) {  //移动文件
				$picurl = "/uploads/image/active/".$file_name;  //文件保存路径		
			} else {  
				$picurl = "";
			}  
		} else {  
			$picurl = "";
		}  
	}else{
		$picurl = "";
	}
	//入库
	$sql = "INSERT INTO `#@__active` ( uid, category_id, attr_id, tag_ids, title, address, description, content, picurl, expval, apply_time, end_time, begins_time, ends_time, create_time) VALUES (
									  '$uid', '$category_id', '$attr_id' ,'$tag_ids', '$title', '$address', '$description', '$content', '$picurl', '$expval', '$apply_time', '$end_time', '$begins_time', '$ends_time', '$create_time')";
	if($dosql->ExecNoneQuery($sql))
	{	
		ShowMsg("提交成功,审核通过后将发布到首页！","-1");
		exit(); 	
	}else{
		ShowMsg("提交失败，请稍后再试！","-1");
			exit(); 	
	}
}else if($action == 'activeSign'){	//活动报名
	$uid   = htmlspecialchars($uid);
	$aid   = htmlspecialchars($aid);
	$create_time = time();
	$info = array();
	$data = $dosql->GetOne("SELECT * FROM `#@__active` WHERE id = $aid AND status =1");
	if(!$data){
		$info['info'] = '该活动不存在或已被下架！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	if($data['uid'] == $uid){
		$info['info'] = '不能报名自己发布的活动！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	//查看报名活动人数
	$sign = $dosql->GetOne("select count(*) as num from `#@__active_sign` where aid =".$aid." and status = 1");
	if($sign == $data['number']){
		$info['info'] = '报名人数已满！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();
	}
	//入库
	$sql = "INSERT INTO `#@__active_sign` ( uid, aid, create_time) VALUES (
									  '$uid', '$aid', '$create_time')";
	if($dosql->ExecNoneQuery($sql))
	{	
		//增加积分
		$dosql->ExecNoneQuery("UPDATE `#@__member` SET integral = integral + ". $data['integral'] ." WHERE id=".$uid);
		//更新已报名人数
		$dosql->ExecNoneQuery("UPDATE `#@__active` SET join_number = join_number + 1 WHERE id=".$aid);
		$info['info'] = '提交成功,审核通过后报名成功！';
		$info['url'] = 'active_list.php';
		$info['status'] = 1;
		echo   json_encode($info);	
		exit();
	}else{
		$info['info'] = '提交失败，请稍后再试！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();	
	}
}else if($action == 'activeCom'){	//评论
	$uid = htmlspecialchars($uid);
	$aid = htmlspecialchars($aid);
	$content = htmlspecialchars($content);
	$create_time = time();
	//入库
	$sql = "INSERT INTO `#@__usercomment` ( uid, aid, content, create_time) VALUES (
									  '$uid', '$aid', '$content', '$create_time')";
	if($dosql->ExecNoneQuery($sql))
	{	
		$info['info'] = '发布成功！';
		$info['status'] = 1;
		$info['url'] = 'active_detail.php?detail_id='.$aid;
		echo   json_encode($info);	
		exit(); 	
	}else{
		$info['info'] = '提交失败，请稍后再试！';
		$info['status'] = 0;
		echo   json_encode($info);	
		exit();		
	}
}else if($action == 'getData'){	//获取数据
	$sender_id  = intval($sender_id);
	$receiver_id= intval($receiver_id);
	$create_time= time();
	//入库
	$sql = "SELECT * FROM `#@__msg` WHERE relationship_id=$sender_id";
	$dosql->Execute($sql);
	$lists = array();
	while ($row = $dosql->GetArray()) { 
		$lists[] = $row;
	}
	foreach($lists as $k=>&$v){
		$userInfo = get_userinfo($v['sender_id']);
		$v['sender_avatar'] = $userInfo['avatar'];
		$v['receiver_avatar'] = '/images/faxiaohu.jpg';
		$v['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
	}
	echo   json_encode($lists);	
	exit();		
}else if($action == 'uploadPic'){
	$piclists    = $_POST['piclists'];
	$id          = $_POST['id'];
	//判断是否上传文件
	$base64_image_content = $piclists;
	/*
	 * 取数组中的第一张图片生成缩略图 
	 */
	$dstW = 600;//缩略图宽
	$dstH = 400;//缩略图高
	preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content[0], $thumb);
	//var_dump($thumb);
	//exit();
	$thumb_type = $thumb[2];	//图片后缀
	$thumb_dateFile = date('Ymd', time()) . "/";  //创建目录
	$thumb_file = $_SERVER['DOCUMENT_ROOT'].'/uploads/image/thumb/'. $thumb_dateFile;
	if (!file_exists($thumb_file)) {
		//检查是否有该文件夹，如果没有就创建，并给予最高权限
		mkdir($thumb_file, 0700);
	}
	
	$thumb_filename = time() . '_' . uniqid() . ".{$thumb_type}"; //文件名
	$thumb_file = $thumb_file . $thumb_filename;
	
	$base64_image_thumb = '';
	//写入操作
	/*if (file_put_contents($thumb_file, base64_decode(str_replace($thumb[1], '', $base64_image_content[0])))) {
		$base64_image_thumb = $_SERVER['DOCUMENT_ROOT'].'/uploads/image/thumb/'.$thumb_dateFile . $thumb_filename;  //返回文件名及路径
		
		$src_image = ImageCreateFromJPEG($base64_image_thumb);
		$srcW = ImageSX($src_image); 			//获得图片宽
		$srcH = ImageSY($src_image); 			//获得图片高
		$dst_image = ImageCreateTrueColor($dstW,$dstH);
		ImageCopyResized($dst_image,$src_image,0,0,0,0,$dstW,$dstH,$srcW,$srcH);
		ImageJpeg($dst_image,$base64_image_thumb);
	} else {
		return false;
	}*/
	//正则匹配出图片的格式
	$base64_image_arr = array();
	foreach($base64_image_content as $k=>$v){
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $v, $result)) {
			$type = $result[2];//图片后缀
	 
			$dateFile = date('Ymd', time()) . "/";  //创建目录
			$new_file = $_SERVER['DOCUMENT_ROOT'].'/uploads/image/'. $dateFile;
			if (!file_exists($new_file)) {
				//检查是否有该文件夹，如果没有就创建，并给予最高权限
				mkdir($new_file, 0700);
			}
	 
			$filename = time() . '_' . uniqid() . ".{$type}"; //文件名
			$new_file = $new_file . $filename;
			 
			//写入操作
			if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $v)))) {
				$base64_image_arr[] = '/uploads/image/'.$dateFile . $filename;  //返回文件名及路径
			} else {
				return false;
			}
		}
	}
	
	//如果缩略图创建失败，则取上传成功的图片中的第一张
	if(!$base64_image_thumb){
		$base64_image_thumb = serialize($base64_image_arr[0]);
	}else{
		$base64_image_thumb = serialize($base64_image_thumb);
	}
	
	//取出原有的图片
	$data = $dosql->GetOne("SELECT piclists FROM `#@__active` WHERE id=".$id);
	if(!empty($data['piclists'])){
		$picArr = unserialize($data['piclists']);
		$base64_image_arr = array_merge($picArr, $base64_image_arr);
	}
	
	$info = array();
	$sql = "UPDATE `#@__active` SET piclists = '". serialize($base64_image_arr) ."' WHERE id=".$id;
	if($dosql->ExecNoneQuery($sql)){
		$info = array(
			'status' => 1,
			'info'   => '上传成功'
		);
	}else{
		$info = array(
			'status' => 0,
			'info'   => '上传失败'
		);
	}
    echo json_encode($info);
	exit();
}else if($action == 'addLike'){	//点赞
	$num   = htmlspecialchars($num);
	$id    = htmlspecialchars($id);
	
	$ip = $_SERVER["REMOTE_ADDR"];
	$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
	$endToday   = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
	$info=array();
	$data = $dosql->GetOne("select count(*) as num from `#@__addlike` WHERE works_id=$id and ip='".$ip."' and create_time > $beginToday and create_time < $endToday");
	if($data['num'] >= 10){
		$info['status']= 0;
		$info['info']  = '您今天对此条信息的点赞次数达到10次，请明天再来！';
		echo   json_encode($info);
		exit();	
	}
	//更新点赞次数
	$sql = "UPDATE `#@__works` set likes=likes + 1 WHERE id=$id";
	
	if($dosql->ExecNoneQuery($sql))
	{	
		$sql = "INSERT INTO `#@__addlike` ( works_id, ip, create_time) VALUES (
									  '".$id."','".$_SERVER["REMOTE_ADDR"]."','".time()."')";
		$dosql->ExecNoneQuery($sql);
		$info['status']=1;
		$info['num'] = $data['num'] + 1;
		echo   json_encode($info);
		exit();			
	}else{
		$info['info']='点赞失败';
		$info['status']=0;
		echo   json_encode($info);
		exit();	
	}	
}else if($action == "indexSearch"){	//首页搜索
	//$page   = htmlspecialchars($page);
	$category   = htmlspecialchars($category);
	$attr   = htmlspecialchars($attr);
	$array   = htmlspecialchars($array);
	//$total = $dosql->GetOne("select count(*) as num from `#@__works` where status=1");
	//$pageSize = 10; //每页显示数
	//$totalPage = ceil($total['num']/$pageSize); //总页数
	//if($page <= $totalPage){
		//$startPage = $page*$pageSize; //开始记录
	//}else{
		//$startPage = $total;
	//}
	$order = "ORDER BY ";
	$where = "WHERE 1=1 ";
	if($category){
		$where .= " AND category_id = ".$category;
	}
	
	if($attr){
		$where .= " AND attr_id = ".$attr;
	}
	
	if($array){
		switch($array){
			case 1:
				$order .= " create_time DESC";
				break;
			case 2:
				$order .= " begins_time ASC";
				break;
			case 3:
				$order .= " join_number DESC";
				break;
		}
	}else{
		$order .= " id DESC";
	}
	
	$sql = "SELECT * FROM `#@__active` ".$where." AND status = 1 ".$order;
	
	$dosql->Execute($sql);
	$num = $dosql->GetTotalRow();
	$list = array();
	$info = array();
	if($num){
		while($row = $dosql->GetArray()){ 
			$tag_Arr = explode(',', $row['tag_ids']);
			$tag_ids = '';
			foreach($tag_Arr as $v){
				$tag_ids .= '<a href="javascript:;" style="background-color:#73b5e6;">'. get_tag($v) .'</a>';
			}
			$list['list'][] = array(
				'id' => $row['id'],
				'picurl' => $row['picurl'],
				'title' => $row['title'],
				'apply_time' => date('m-d',$row['apply_time']),
				'end_time' => date('m-d', $row['end_time']),
				'begins_time' => date('m-d',$row['begins_time']),
				'ends_time' => date('m-d', $row['ends_time']),
				'address' => $row['address'],
				'tag_ids' => $tag_ids
			);
		}
		$info['status'] = 1;
		$info['data'] = $list;
		echo json_encode($info);
		exit();
	}else{
		$info['status'] = 0;
		echo json_encode($info);
		exit();
	}
}else{//无条件返回
	exit('请求出错!');	
}
?>