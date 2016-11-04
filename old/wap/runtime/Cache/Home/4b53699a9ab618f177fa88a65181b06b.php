<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php if($vo["status"] == 1): ?>工友圈<?php else: ?>子女教育<?php endif; ?></title>
<link href="<?php echo ($_static_); ?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/gongy.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/user.css" rel="stylesheet" type="text/css">
<script src="<?php echo ($_static_); ?>/js/jquery-1.8.3.min.js"></script>
<script>
$(window).load(function() {
  $("#status").fadeOut();
  $("#preloader").delay(350).fadeOut("slow");
})
</script>
</head>

<body>
<div class="mobile">
    <div class="weixin weixin_fd ">
        <div class="fabu_an"><a  data-toggle="modal"  href="<?php echo ($_root); ?>member/index/exchange" style="font-size: 14px;color: white;text-decoration: none">发布</a></div>
        <!--弹出-->
    </div>
  <!--页面加载 开始-->
  <div id="preloader">
    <div id="status">
      <p class="center-text"><span>拼命加载中···</span></p>
    </div>
  </div>
  <!--页面加载 结束--> 
  <!--header 开始-->
  <header>
    <div class="header"> <a class="new-a-back" href="javascript:history.back();"> <span><img src="<?php echo ($_static_); ?>/images/iconfont-fanhui.png"></span> </a>
      <h2><?php if($vo["status"] == 1): ?>工友圈<?php else: ?>子女教育<?php endif; ?></h2>
    </div>
  </header>
  <!--header 结束-->
  <div class="news_view w"> <div class="news_tags"><span>时间：<?php echo ($vo["addtime"]); ?></span><span>来源：<?php echo (($vo["nickname"])?($vo["nickname"]):"无"); ?></span></div>
      <h1><?php echo ($vo["title"]); ?></h1>
       
      <div class="news_content">
        <?php if(!empty($vo['pics'][0])): if(is_array($vo[pics])): $i = 0; $__LIST__ = $vo[pics];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><span style="text-align:center; width:100%;padding:0 10px; float:left;">
            <img width="90%" height="200" src="<?php echo ($vl); ?>" />
          </span><?php endforeach; endif; else: echo "" ;endif; endif; ?>
      <p>
        <?php echo ($vo["content"]); ?>
      </p>
      </div>
      <?php if($_COOKIE['uid']<= 0): ?><div class="m_user w">
              <a href="<?php echo ($_root); ?>login.html">登录</a>
              <a href="<?php echo ($_root); ?>register.html">注册</a>

          </div><?php endif; ?>
      <div style="height:200px;"></div>    
  </div>
 
    <div>
      <p style="line-height: 100px;" class="reply"><input type="text" name="huifu" style="border-top:2px #000; width: 100%;height: 50px;" placeholder="有什么想说的吗，在这写一写吧"></p><p><button style="float: right;" id="dianji">回复</button></p>
    </div>
    
    <div style="position:fixed;width:100%;background-color:White;bottom:0px">
        <div class="footer w">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.zjtd.buildinglife" style="float: left;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-and.png"></div><span style="color:#00bb9c">安卓客户端</span></a>
            <a href="https://itunes.apple.com/cn/app/jian-yu-liang-cai/id1071761808?mt=8" style="float: left;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-ios.png"></div><span style="color:#00bb9c">IOS客户端</span></a>
            <a href="http://www.jylc8.com:8081/wap/index.php" style="text-align: center;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-shouji.png"></div><span style="color:#eb4f38">触摸版</span></a>
            <a href="http://www.jylc8.com:8081/index.php/index" style="float: right;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-diannao.png"></div><span>电脑版</span></a>
        </div>
        <div class="copyright">Copyright © 2012-2015 建遇良才 版权所有</div>
    </div>
    <div style="clear:both"></div>
    </div>
</body>
<script type="text/javascript">
    $("#dianji").click(function(){
        var content=$(".reply input").val();
        alert(content);
    })
        
</script>
</html>