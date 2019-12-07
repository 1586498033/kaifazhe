<div class="m-tab1">
	<?php
	$dopage->GetPage("SELECT id,classname,linkurl FROM `#@__infoclass` WHERE parentid=".$pid." ORDER BY orderid ASC",8);
	$i = 1;
	while($row=$dosql->GetArray()){ 
	?>
		<a <?php echo gourl($row['linkurl'],'list',$row['id']);?> class="<?php if($cid == $row['id']){ echo 'on';}?>"><?php echo $row['classname'];?></a>
	<?php $i++;} ?>
</div>