<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><if condition="$vo.status eq 1">工友圈<else/>子女教育</if></title>
<link href="{$_static_}/css/index.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/gongy.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/user.css" rel="stylesheet" type="text/css">
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
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
        <div class="fabu_an"><a  data-toggle="modal"  href="{$_root}member/index/exchange" style="font-size: 14px;color: white;text-decoration: none">发布</a></div>
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
    <div class="header"> <a class="new-a-back" href="javascript:history.back();"> <span><img src="{$_static_}/images/iconfont-fanhui.png"></span> </a>
      <h2><if condition="$vo.status eq 1">工友圈<else/>子女教育</if></h2>
    </div>
  </header>
  <!--header 结束-->
  <div class="news_view w"> <div class="news_tags"><span>时间：{$vo.addtime}</span><span>来源：{$vo.nickname|default="无"}</span></div>
      <h1>{$vo.title}</h1>
       
      <div class="news_content">
        <if condition="!empty($vo['pics'][0])">
        <volist name="vo[pics]" id="vl">
          <span style="text-align:center; width:100%;padding:0 10px; float:left;">
            <img width="90%" height="200" src="{$vl}" />
          </span>
        </volist>
        </if>
      <p>
        {$vo.content}
      </p>
      </div>
      <if condition="$Think.cookie.uid elt 0">
          <div class="m_user w">
              <a href="{$_root}login.html">登录</a>
              <a href="{$_root}register.html">注册</a>

          </div>
      </if>
      <div style="height:200px;"></div>    
  </div>
 

    
    <div style="position:fixed;width:100%;background-color:White;bottom:0px">
        <div class="footer w">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.zjtd.buildinglife" style="float: left;width: 25%"><div class="ico_img"><img src="{$_static_}/images/178hui-and.png"></div><span style="color:#00bb9c">安卓客户端</span></a>
            <a href="https://itunes.apple.com/cn/app/jian-yu-liang-cai/id1071761808?mt=8" style="float: left;width: 25%"><div class="ico_img"><img src="{$_static_}/images/178hui-ios.png"></div><span style="color:#00bb9c">IOS客户端</span></a>
            <a href="http://www.jylc8.com:8081/wap/index.php" style="text-align: center;width: 25%"><div class="ico_img"><img src="{$_static_}/images/178hui-shouji.png"></div><span style="color:#eb4f38">触摸版</span></a>
            <a href="http://www.jylc8.com:8081/index.php/index" style="float: right;width: 25%"><div class="ico_img"><img src="{$_static_}/images/178hui-diannao.png"></div><span>电脑版</span></a>
        </div>
        <div class="copyright">Copyright © 2012-2015 建遇良才 版权所有</div>
    </div>
    <div style="clear:both"></div>
    </div>
</body>
</html>