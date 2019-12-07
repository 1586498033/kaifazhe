<?php
//Session保存路径
$sess_savepath = dirname(__FILE__).'/../sessions/';
if(is_writable($sess_savepath) &&
   is_readable($sess_savepath))
{
	session_save_path($sess_savepath);
}
//开启SESSION
if(!isset($_SESSION)) session_start();
//获取随机字符
$rndstring = '';
for($i=0; $i<4; $i++) $rndstring .= chr(mt_rand(65,90));


//如果支持GD，则绘图
if(function_exists('imagecreate'))
{
	$_SESSION['ckstr'] = strtolower($rndstring);
	$rndstring  = $_SESSION['ckstr'];
	$rndcodelen = strlen($rndstring);

	//创建图片，并设置背景色
	$width = 50;
	$height = 20;
	$im = imagecreate(50,20);
	ImageColorAllocate($im, 255,255,255);

	//背景线
	//$lineColor1 = ImageColorAllocate($im,240,220,180);
	//$lineColor2 = ImageColorAllocate($im,250,250,170);
	$lineColor1 = ImageColorAllocate($im,250,0,0);
	$lineColor2 = ImageColorAllocate($im,250,0,0);
	for($j=3;$j<=16;$j=$j+3)
	{
		imageline($im, 2, $j, 48, $j, $lineColor1);
	}
	for($j=2;$j<52;$j=$j+(mt_rand(3,6)))
	{
		imageline($im, $j, 2, $j-6, 18, $lineColor2);
	}
	
	//画边框
	$bordercolor = ImageColorAllocate($im, 0x99,0x99,0x99);
	imagerectangle($im, 0, 0, 49, 19, $bordercolor);


	//输出文字
	$fontColor = ImageColorAllocate($im, 48,61,50);
	for($i=0;$i<$rndcodelen;$i++)
	{
		$bc = mt_rand(0,1);
		$rndstring[$i] = strtoupper($rndstring[$i]);
		imagestring($im, 5, $i*10+6, mt_rand(2,4), $rndstring[$i], $fontColor);
		
		$ag = rand(-44,44);
		
		// 旋转字符随机角度
		$oimg = imagerotate($im, $ag, $fontColor); 
		imagecopy($im, $oimg, $i*75, 0 , 0 , 0 , imagesx($oimg) , imagesy($oimg));
		
		//干扰线
		$x1 = rand(1,$width-1);
		$y1 = rand(1,$height-1);
		$x2 = rand(1,$width-1);
		$y2 = rand(1,$height-1);
		//imageline($im,$x1,$y1,$x2,$y2,ImageColorAllocate($im, rand(50, 180),rand(50, 180),rand(50, 180)));
		imageline($im,$x1,$y1,$x2,$y2,ImageColorAllocate($im, rand(0, 255),rand(0, 255),rand(0, 255)));
	}
	
	header("Pragma:no-cache\r\n");
	header("Cache-Control:no-cache\r\n");
	header("Expires:0\r\n");

	//输出特定类型的图片格式，优先级为 gif -> jpg ->png
	if(function_exists("imagejpeg"))
	{
		header("content-type:image/jpeg\r\n");
		imagejpeg($im);
	}
	else
	{
		header("content-type:image/png\r\n");
		imagepng($im);
	}

	ImageDestroy($im);
	exit();
}
//不支持GD
else
{
	//输出字母 ABCD
	$vdcode_path = 'vdcode.jpg';
	$_SESSION['ckstr'] = 'abcd';

	header("content-type:image/jpeg\r\n");
	header("Pragma:no-cache\r\n");
	header("Cache-Control:no-cache\r\n");
	header("Expires:0\r\n");

	$fp = fopen($vdcode_path,'r');
	echo fread($fp, filesize($vdcode_path));
	fclose($fp);
	exit();
}
?>