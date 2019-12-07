<?php
require_once(dirname(__FILE__).'/include/config.inc.php'); 
$r = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id=".$cid." AND checkinfo=true ORDER BY orderid ASC");
if($r){
	if($r['parentid'] == 0){
		$pid = $cid;
	}else{ 
		$pid = $r['parentid'];
		$f = $dosql->GetOne("SELECT parentid,parentstr FROM `#@__infoclass` WHERE id=".$pid." AND checkinfo=true ORDER BY orderid ASC");
		if($f){
			if($f['parentid'] == 0) $fid = $pid;else $fid = $f['parentid'];
		}	
	}
}else{
	$pid = $cid;	//抑制错误信息
}
