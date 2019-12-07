<?php require_once(dirname(__FILE__).'/include/config.inc.php');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="format-detection" content="telephone=no" />
    <title>PHP 文件上传</title>
	<link rel="stylesheet" href="css/cui.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
	<header class="g-header1">
		<h1>PHP 文件上传</h1>
	</header>
	<section class="g-bd g-bd3">
		<form action="ajax_do.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="uploadFile" />
			<div class="m-edit">
				<ul>
					<li class="head">
						<span class="tit">选择文件</span>
						<div class="con">
							<div class="m-head">
								<?php
								$data = $dosql->GetOne("SELECT * FROM `#@__images` ORDER by id DESC");
								if($data){
									echo '<img src="'.$data['picurl']  .'" />';
								}else{
								?>
								<img src="images/img13.png" alt="" />
								<?php } ?>
								<input type="file" name="headimg" class="file js-uploadfile" />
							</div>
						</div>
					</li>
				</ul>
				<input type="submit" class="sub" value="上传图片" />
			</div>
		</form>
	</section>
	<footer>
		<h3>喜欢就关注下公众号呗</h3>
		<img src="images/weixin.jpg" />
	</footer>
	<script src="js/jquery.js"></script>
	<script src="js/lib.js"></script>
	<script>
		$(function(){
			//上传头像
			uploadFile();
		});
		//上传图片
		function uploadFile(){
			$(".js-uploadfile").each(function(index, el) {
				var that=$(this);
				var imgBox=that.prev("img");
				that.change(function(event) {
					var inputFile=that.get(0).files[0];
					if(inputFile){
						readFile(inputFile,imgBox);
					}
				});
			});
		}

		//读取上传文件信息
		function readFile(file,imgObj){
			var reader=new FileReader();
			reader.readAsDataURL(file);
			reader.addEventListener('load',function(){
				if(reader.result){
					imgObj.attr("src",reader.result);
				}
			});
		}
	</script>
</body>
</html>