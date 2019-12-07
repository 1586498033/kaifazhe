<?php
header("content-type:text/html;charset=utf-8");
require("class.phpmailer.php"); 
function smtp_mail( $sendto_email, $subject, $body, $extra_hdrs, $user_name){  
    $mail = new PHPMailer();  
    $mail->IsSMTP();                  	// 经SMTP发送  
    //$mail->Host = "smtp.163.com";   	// SMTP 服务器
	$mail->Host = "smtp.mxhichina.com";   	// SMTP 服务器
	$mail->Port = 25; 					// SMTP服务器的端口号  
    $mail->SMTPAuth = true;           	// 打开SMTP认证   
    //$mail->Username = "gjyxdh@163.com";     // SMTP username  注意：普通邮件认证不需要加 @域名
	$mail->Username = "websys@bluuprint.com"; // SMTP username  注意：普通邮件认证不需要加 @域名    
    $mail->Password = "Bluuprint@com"; // 我的邮箱密码（发件人）  
    $mail->From = "websys@bluuprint.com";      // 发件人邮箱  
    $mail->FromName =  "websys@bluuprint.com";  // 发件人  
  
    $mail->CharSet = "UTF-8";   // 这里指定字符集！  
    $mail->Encoding = "base64";  
    $mail->AddAddress($sendto_email,$sendto_email);  // 收件人邮箱和姓名  
    $mail->AddReplyTo("websys@bluuprint.com","websys@bluuprint.comm");  
    $mail->IsHTML(true);  // send as HTML  
    // 邮件主题  
    $mail->Subject = $subject;  
    // 邮件内容  
    $mail->Body = '<html><head>     
    <meta http-equiv="Content-Language" content="zh-cn">     
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">     
    </head>     
    <body>    
    I love php。     
    </body>     
    </html>';  
    $mail->AltBody ="text/html";  
    if(!$mail->Send())  
    {  
        echo "邮件发送有误 <p>";  
        echo "邮件错误信息: " . $mail->ErrorInfo;  
        exit;  
    }  
    else {  
        echo "$user_name 邮件发送成功!<br />";  
    }  
}  
// 参数说明(发送到, 邮件主题, 邮件内容, 附加信息, 用户名)  
$body = "Welcome to the Bluusprint community account. Please click the following link to activate your account";
smtp_mail("shujun848981@163.com", "Welcome To Register Bluusprint Community", $body, "shujun848981@163.com", "shujun848981@163.com"); 
