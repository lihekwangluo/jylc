<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>建遇良才登录 —触摸版</title>
<link href="<?php echo ($_static_); ?>/frozenui/css/frozen.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/login.css" rel="stylesheet" type="text/css">
<script src="<?php echo ($_static_); ?>/js/jquery-1.8.3.min.js"></script>
<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3602390774" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101288044"  charset="utf-8"></script>
<script>
$(window).load(function() {
  $("#status").fadeOut();
  $("#preloader").delay(350).fadeOut("slow");
})
</script>
</head>
<script type="text/javascript">
var index = 0;
$(document).ready(function(){
  $("form").submit(function(e){
      var username = $.trim($("#username").val());
      var password = $.trim($("#password").val());
    if(username == ''){
      layer.tips('请输入手机号码','#username', {tips: 1});
      return false;
    }else if(password == ''){
      layer.tips('请输入登录密码','#password', {tips: 1});
      return false;
    }
    $.ajax({
        url:"<?php echo ($_root); ?>login",
        type:"post",
        data:{mobile:username,pass:password},
        dataType:"json",
        error:function(){
           layer.close(index);
           layer.msg("出错啦");
        },
        beforeSend:function(){
             index = layer.load(2, {shade: false});
        },
        success:function(res){
            layer.close(index);
            if(res.status==1){
              window.location.href="<?php echo ($_root); ?>member";
            }else{
              layer.msg(res.message);
            }
        }
    })
    return false;
  });
});
</script>
<body>
<div class="mobile">
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
      <h2>建遇良才登录</h2>
      </div>
  </header>
  <!--header 结束-->
  
  <div class="w main">
    <form id="frm_login" method="get" action="">
        <div class="item item-username">
          <input id="username" class="txt-input txt-username" type="text" placeholder="请输入手机号" value="" name="username">
          <b class="input-close" style="display: none;"></b> </div>
        <div class="item item-password">
          <input id="password" class="txt-input txt-password ciphertext" type="password" placeholder="请输入密码" name="password" style="display: inline;">
          <input id="ptext" class="txt-input txt-password plaintext" type="text" placeholder="请输入密码" style="display: none;" name="ptext">
          <b class="tp-btn btn-off"></b>
        </div>
        <div class="item item-login-option">
          <div class="aoutlogin">
                <label class="ui-checkbox ui-checkbox-s">
                    <input type="checkbox" name="checkbox" checked/>自动登录
                </label>
            </div>
            <span class="retrieve-password"> <a class="" href="<?php echo ($_root); ?>index/forgetpwd">忘记密码</a> </span>
        </div>
        <div class="ui-btn-wrap"><input name="" type="submit" value="用户登录"  class="ui-btn-lg ui-btn-primary" /> </div>
        <div class="ui-btn-wrap"> <a class="ui-btn-lg ui-btn-danger" href="<?php echo ($_root); ?>register">没有账号？立即注册</a> </div>
 
      </form>
  </div>
  
 <!--  <div class="m_user w">
    <a href="login.html"></a>
    <a href="register.html"></a>
    <a href="#">返回顶部</a>
  </div> -->
    <div class="footer w">
        <a href="http://app.qq.com/#id=detail&appid=1105006447" style="float: left;width: 25%"><div class="ico_img" ><img src="<?php echo ($_static_); ?>/images/178hui-and.png"></div><span style="color:#00bb9c">安卓客户端</span></a>
        <a href="http://apk.hiapk.com/appdown/com.zjtd.buildinglife" style="float: left;width: 25%"><div class="ico_img" ><img src="<?php echo ($_static_); ?>/images/178hui-ios.png"></div><span style="color:#00bb9c">IOS客户端</span></a>
        <a href="http://www.jylc8.com:8081/wap/index.php"  style="text-align: center;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-shouji.png"></div><span style="color:#eb4f38">触摸版</span></a>
        <a href="http://www.jylc8.com:8081/index.php/index"  style="float: right;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-diannao.png"></div><span>电脑版</span></a>
    </div>
    <div class="copyright">Copyright © 2012-2015 建遇良才 版权所有</div>
<script type="text/javascript">

WB2.anyWhere(function (W) {
    W.widget.connectButton({
        id: "wb_connect_btn",
        type: '3,2',
        callback: {
            login: function (o) { //登录后的回调函数
                send1(2,o.id,o.screen_name);
            },
            logout: function () { //退出后的回调函数
                window.location.href="<?php echo ($_root); ?>login/logout";
            }
        }
    });
});
$("#sina").click(function(){ 
    //send1(2,'123456','helloword');
    $("#wb_connect_btn").trigger("click");
    location.href = 'https://api.weibo.com/oauth2/authorize?client_id=' + '3602390774' + '&client_secrect=' + '6fee7568d4e413c568101c5baa1ccec2' + '&response_type=code&redirect_uri=' + "<?php echo ($_root); ?>member";

});

$("#qq").click(function(){
    window.location.href= "<?php echo ($_root); ?>login/get_openid";
})

function send1(type,id,name){
  var p = {};
  if(type==1){
      p.qq = id;
  }else if(type==2){
      p.weibo = id;
  }
  p.nickname = name;
  $.ajax({
      url:"<?php echo ($_root); ?>login",
      type:"post",
      data:p,
      dataType:"json",
      timeOut:2000,
      success:function(res){
          if(res.status==1){
            window.location.href="<?php echo ($_root); ?>member";
          }else{
            alert(res.message);
          }
      },
      error:function(){
          alert("出错啦");
      }
  })
}
</script>
    <script type="text/javascript" >
    $(function() {
    $(".input-close").hide();
    displayPwd();
    displayClearBtn();
    setTimeout(displayClearBtn, 200 ); //延迟显示,应对浏览器记住密码
  }); 

  //是否显示清除按钮
  function displayClearBtn(){
    if(document.getElementById("username").value != ''){
      $("#username").siblings(".input-close").show();
    }
    if(document.getElementById("password").value != ''){
      $(".ciphertext").siblings(".input-close").show();
    }
    if($("#codeLevel").val()!="" && $("#codeLevel").val()!='0'){
      if($("#validateCode").val()!=""){
        $("#validateCode").siblings(".input-close").show();
      }
    }
  }

  //清除input内容
    $('.input-close').click(function(e){  
    $(e.target).parent().find(":input").val("");
    $(e.target).hide();
    $($(e.target).parent().find(":input")).each(function(i){
      if(this.id=="ptext" || this.id=="password"){
        $("#password").val('');
        $("#ptext").val('');
      }
         });
    });  
  
  //设置password字段的值  
  $('.txt-password').bind('input',function(){
    $('#password').val($(this).val());
  });
  
  //显隐密码切换
  function displayPwd(){
      $(".tp-btn").toggle(
          function(){
            $(this).addClass("btn-on");
      var textInput = $(this).siblings(".plaintext");
        var pwdInput = $(this).siblings(".ciphertext");
      pwdInput.hide();
      textInput.val(pwdInput.val()).show().focusEnd();
          },
          function(){
        $(this).removeClass("btn-on");
        var textInput = $(this).siblings(".plaintext ");
        var pwdInput = $(this).siblings(".ciphertext");
            textInput.hide();
      pwdInput.val(textInput.val()).show().focusEnd();
          }
      );
  }

  //监控用户输入
  $(":input").bind('input propertychange', function() {
    if($(this).val()!=""){
      $(this).siblings(".input-close").show();
    }else{
      $(this).siblings(".input-close").hide();
    }
    });
</script>  
</body>
</html>