<!doctype html>
<html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>建遇良才-忘记密码</title>
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/login.css" rel="stylesheet" type="text/css">
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<script src="{$_static_}/layer/layer.js"></script>
<script>
$(window).load(function() {
	$("#status").fadeOut();
	$("#preloader").delay(350).fadeOut("slow");
})
</script>
</head>

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
    <div class="header"> <a class="new-a-back" href="javascript:history.back();"> <span><img src="{$_static_}/images/iconfont-fanhui.png"></span> </a>
      <h2>忘记密码</h2>
      </div>
  </header>
  <!--header 结束-->
  
  <div class="w main">
  	<form id="frm_login" action="">
        <div class="item item-username">
          <input id="mobile" class="txt-input txt-username" type="text" placeholder="请输入手机号" value="" name="username">
          <b class="input-close" style="display: none;"></b> </div>
           <div class="item item-username">
          <input id="yanzhenma" class="txt-input txt-yanzhenma" type="text" placeholder="请输入验证码" value="" name="yanzhenma">
          <b class="input-close" style="display:none;"></b>
           <input type="button" name="houqu" class="houqu " id="houqu" onclick="get_code(this)" value="获取验证码"></div>
        
        <div class="item item-password">
          <input id="password" class="txt-input txt-password_PwdTwo ciphertext_PwdTwo" type="password" placeholder="请输入新密码" name="password_PwdTwo" style="display: inline;">
          <input id="ptext_PwdTwo" class="txt-input txt-password_PwdTwo plaintext_PwdTwo" type="text" placeholder="请输入新密码" style="display: none;" name="ptext_PwdTwo">
        </div>
        <div class="item item-username">
          <input id="repassword" class="txt-input txt-username" type="password" placeholder="请再次输入新密码" value="" name="username">
          <b class="input-close" style="display:none;"></b> </div>
        <div class="ui-btn-wrap"> <a class="ui-btn-lg ui-btn-primary" href="javascript:;" onclick="sub()">确认</a> </div>
    </form>
  </div>
</div>

<script type="text/javascript" >

function sub(){
    var mobile = $.trim($("#mobile").val());
    var yzm = $.trim($("#yanzhenma").val());
    var password = $.trim($("#password").val());
    var password_PwdTwo = $.trim($("#repassword").val());
    var invitecode = $.trim($("#invitecode").val());
    if(mobile == ''){
      layer.tips('请输入手机号码','#mobile', {tips: 1});
      return false;
    }else if(yzm ==''){
      layer.tips('请输入验证码','#yanzhenma', {tips: 1});
      return false;
    }else if(password == ''){
      layer.tips('请输入密码','#password', {tips: 1});
      return false;
    }else if(password!=password_PwdTwo){
      layer.tips('2次输入的密码不一样','#repassword', {tips: 1});
      return false;
    }
    $.ajax({
        url:"{$_root}index/forgetpwd",
        type:"post",
        data:{mobile:mobile,code:yzm,pass1:password,pass2:password_PwdTwo},
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
            	layer.msg("修改成功");
              window.location.href="{$_root}login";
            }else{
              layer.msg(res.message);
            }
        }
    })
}

var wait=60;
function get_code(obj){
  var mobile = $("#mobile").val();
  if(!mobile && !/^1[3|4|5|7|8]\d{9}$/.test(mobile)){
    layer.tips('请输入正确手机号码','#mobile', {tips: 1});
    return false;
  }
  time(obj);
  $.ajax({
      url:"{$_root}register/send_code",
      type:"post",
      data:{mobile:mobile},
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
            layer.msg("验证码发送成功");
          }else{
            layer.msg(res.message);
          }
      }
  })
}

function time(o) {
    if (wait == 0) {
        o.removeAttribute("disabled"); 
         o.value="发送验证码";          
        wait = 60;
    } else {
        o.setAttribute("disabled", true);
        o.value="倒计时(" + wait + ")";
        wait--;
        setTimeout(function() {
            time(o)
        },
        1000)
    }
}

    $(function() {
		$(".input-close").hide();
		displayPwd();
		displayPwd_PwdTwo();
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
		if(document.getElementById("password_PwdTwo").value != ''){
			$(".ciphertext_PwdTwo").siblings(".input-close").show();
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
			if(this.id=="ptext_PwdTwo" || this.id=="password_PwdTwo"){
				$("#password_PwdTwo").val('');
				$("#ptext_PwdTwo").val('');
			}
         });
    });  
	
	//设置password字段的值	
	$('.txt-password').bind('input',function(){
		$('#password').val($(this).val());
	});
	$('.txt-password_PwdTwo').bind('input',function(){
		$('#password_PwdTwo').val($(this).val());
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
		  	var textInput = $(this).siblings(".plaintext");
    		var pwdInput = $(this).siblings(".ciphertext");
            textInput.hide();
			pwdInput.val(textInput.val()).show().focusEnd();
          }
    	);
	}
	//显隐密码切换
	function displayPwd_PwdTwo(){
    	$(".tp-btn_PwdTwo").toggle(
          function(){
            $(this).addClass("btn-on_PwdTwo");
			var textInput = $(this).siblings(".plaintext_PwdTwo");
    		var pwdInput = $(this).siblings(".ciphertext_PwdTwo");
			pwdInput.hide();
			textInput.val(pwdInput.val()).show().focusEnd();
          },
          function(){
		  	$(this).removeClass("btn-on_PwdTwo");
		  	var textInput = $(this).siblings(".plaintext_PwdTwo");
    		var pwdInput = $(this).siblings(".ciphertext_PwdTwo");
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
	})
</script> 

</body>
</html>