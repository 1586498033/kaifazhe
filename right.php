<div class="col-r">
  <div class="g-box2">
    <h3 class="g-tit2 g-tit2-2">搜索</h3>
    <form action="search.html" method="post" name="form" id="form" onSubmit="return checkSearch()">
      <div class="soBox">
        <input type="text" class="inp" placeholder="search" name="keywords" id="keywords" />
        <input type="hidden" name="id" value="1" />
        <input type="submit" class="sub" />
      </div>
    <form>
    <h3 class="g-tit2 g-tit2-2">相关新闻</h3>
    <ul class="ul-news">
      <!-- 读取推荐新闻 -->
      <?php
      $dopage->GetPage("SELECT id,classid,linkurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND siteid = 1 AND checkinfo=true AND delstate='' AND FIND_IN_SET('c',flag) ORDER BY posttime DESC",5);
      while($row=$dosql->GetArray()){
      ?>
        <li><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?> title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></li>
      <?php } ?>
    </ul>
    <h3 class="g-tit2 g-tit2-2">标签</h3>
    <ul class="ul-tags">
      <li><a href="<?php echo $cfg_weburl;?>list-1-1.html" target="_blank">网站建设</a></li>
      <li><a href="<?php echo $cfg_weburl;?>list-2-1.html" target="_blank">新闻</a></li>
      <li><a href="<?php echo $cfg_weburl;?>list-240-1.html" target="_blank">新闻中心</a></li>
      <li><a href="<?php echo $cfg_weburl;?>list-333-1.html" target="_blank">解决方案</a></li>
      <li><a href="<?php echo $cfg_weburl;?>list-239-1.html" target="_blank">资料下载</a></li>
      <li><a href="<?php echo $cfg_weburl;?>list-345-1.html" target="_blank">常见问题</a></li>
    </ul>
    <h3 class="g-tit2 g-tit2-2">最新动态</h3>
    <ul class="ul-dynamic">
      <?php
      $dopage->GetPage("SELECT id,classid,linkurl,title,posttime,description FROM `#@__infolist` WHERE classid=".$cid." AND checkinfo=true AND delstate='' AND FIND_IN_SET('n',flag) ORDER BY posttime DESC",2);
      while($row=$dosql->GetArray()){
      ?>
      <li>
        <p><a <?php echo gourl($row['linkurl'],'content',$row['classid'],$row['id']);?> title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a></p>
        <p><?php echo $row['description'];?></p>
        <span class="date"><?php echo date('Y年m月d日', $row['posttime']);?></span>
      </li>
      <?php } ?>
    </ul>
    <h3 class="g-tit2 g-tit2-2">关于我们</h3>
    <div class="m-about">
      <p>我们致力于网站建设、软件开发、手机应用开发等服务。我们坚持"智慧沟通，高效执行"的管理服务理念，已为10000+客户提供网站建设、100＋客户提供软件开发、100+客户提供手机应用开发服务。希望成为企业发展的技术伙伴。</p>
    </div>
  </div>
</div>