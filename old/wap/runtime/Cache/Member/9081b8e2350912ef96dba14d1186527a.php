<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>会员中心 — 建遇良才</title>
<script type="text/javascript" src="<?php echo ($_static_); ?>/js/jquery-1.10.2.min.js"></script>
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/user.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/index.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ($_static_); ?>/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<script>
$(window).load(function() {
	$("#status").fadeOut();
	$("#preloader").delay(350).fadeOut("slow");
})
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".login_out").click(function(){
		layer.confirm('您确定要退出吗？',  {skin: 'layui-layer-molv',offset: '30%'}, function(index){
			layer.close(index);
			layer.msg('拜拜！欢迎下次光临！', {shift: 6, time: 1500},function(){
				window.location='<?php echo ($_root); ?>login/logout';
			});
		});
	});
});
</script>

</head>

<body>
<div style="position:relative" class="mobile">
     <div class="weixin weixin_fd ">
        <div class="fabu_an"><a  data-toggle="modal"  href="<?php echo ($_root); ?>member/index/exchange" style="font-size: 14px;color: white;text-decoration: none">邀请有奖</a></div>
        <!--弹出 -->
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
      <h2>个人中心</h2>
    </div>
  </header>
  <!--header 结束-->

	<div class="user_top w">
   	  <div class="user_logo"><div class="img"><img src="<?php echo ($_static_); ?>/images/<?php if(empty($vo[pic])): ?>geren_03.png<?php else: echo ($vo["pic"]); endif; ?>"></div></div>
        <div class="user_info">
        	<div class="user_name" style="color:#3e3e3e"><?php echo ($vo["nickname"]); ?></div>
            <div class="user_dengji" style="color:#969696"><?php echo ($vo["mobile"]); ?></div>
        </div>
    </div>
    <div class="user_nav_list w">
    	<ul>
            <li>
            	<a href="<?php echo ($_root); ?>member/my/publish.html">
                	<div class="u_nav_icon money"></div>
                    <div class="u_nav_name">我的发布</div>
                     <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/my.html">
                	<div class="u_nav_icon huibi"></div>
                    <div class="u_nav_name">基本资料</div>
                    <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/my/score">
                	<div class="u_nav_icon tixian"></div>
                    <div class="u_nav_name">我的积分</div>
                    <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/my/collect">
                	<div class="u_nav_icon tixian1"></div>
                    <div class="u_nav_name">我的收藏</div>
                    <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/index/exchange">
                	<div class="u_nav_icon dingdan"></div>
                    <div class="u_nav_name">积分兑换</div>
                    <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/index/renzheng">
                	<div class="u_nav_icon qiandao"></div>
                    <div class="u_nav_name">我要认证</div>
                    <div class="nt_icon"></div>
                    <div class="u_money"><i></i></div>
              </a>
            </li>
           
            <li>
            	<a href="<?php echo ($_root); ?>member/safe">
                	<div class="u_nav_icon anquan"></div>
                    <div class="u_nav_name">安全中心</div>
                    <div class="nt_icon"></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>member/my/suggest">
                	<div class="u_nav_icon anquan1"></div>
                    <div class="u_nav_name">意见反馈</div>
                    <div class="nt_icon"></div>
              </a>
            </li>
            <li>
            	<a href="<?php echo ($_root); ?>/member/index/about">
                	<div class="u_nav_icon anquan2"></div>
                    <div class="u_nav_name">关于我们</div>
                    <div class="nt_icon"></div>
              </a>
            </li>
        </ul>
    </div>
    <div class="login_out w"><a href="javascript:void(0);"><span></span><i>退出登录</i></a></div>
    <div style="height:1000px;"></div>
    <div style="position:fixed;width:100%;background-color:White;bottom:0px">
  <div class="footer w">
  	<a href="<?php echo ($_root); ?>"><div class="ico_img">
      <img src="<?php echo ($_static_); ?>/images/foot/1f1_45.png"></div><span style="color:#7e7e7e">首页</span></a>

    <a href="<?php echo ($_root); ?>workmate?status=1"><div class="ico_img">
      <img src="<?php echo ($_static_); ?>/images/images/tutu_05.png"></div><span style="color:#7e7e7e">工友圈</span></a>
    <a href="<?php echo ($_root); ?>workmate?status=2"><div class="ico_img">
      <img src="<?php echo ($_static_); ?>/images/images/tutu_07.png"></div><span style="color:#7e7e7e">子女教育</span></a>
    <a href="javascript:void"><div class="ico_img">
      <img src="<?php echo ($_static_); ?>/images/foot/1f_51.png"></div><span style="color:#00bb9c">我的</span></a>
  </div>
  </div>
  <div style="clear:both"></div>
</div>
</body>
</html>