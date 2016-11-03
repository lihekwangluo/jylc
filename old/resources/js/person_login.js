$('document').ready(function(){
    $('input[name="uname"]').focus(function(){
        $('#uname-wrap').addClass('on').removeClass('off');
        $('#remember3').fadeOut();
        $(this).css({'border':'1px solid #dedede'});
        $(".user_tips").hide();
        if($(this).val() == '请输入手机号/邮箱/用户名' || $(this).val() == '例：hrm@hrm.cn'){
            $(this).val('');
        }
    }).blur(function(){
        $('#uname-wrap').addClass('off').removeClass('on');

        if($(this).val() == ''){
            $(this).val('请输入手机号/邮箱/用户名');
            $(this).css("color","#808285");
        }
    }).keyup(function(){
                 $(this).css("color","black");
             });
    $(document).on('focus','input[name="password"]',function(){
        $('#password-wrap').addClass('on').removeClass('off');
        $('#remember3').fadeOut();
        $(this).css({'border':'1px solid #dedede'});
        $(".user_tips").hide();
        $(".onfocus_psw").hide();
    }).on('blur','input[name="password"]',function(){
        $('#password-wrap').addClass('off').removeClass('on');
        if($(this).val()=="")
        {
            $(".onfocus_psw").show();
        }
        else
        {
            $(".onfocus_psw").hide();
        }
    }).on('keyup','input[name="password"]',function(){
                 $(this).css("color","black");
             });
    $('input[name="xoopscaptcha"]').focus(function(){
        $('#remember3').fadeOut();
        $(this).css({'border':'1px solid #dedede'});
        if($(this).val() == '请输入验证码'){
            $(this).val('');
        }
    }).blur(function(){
        if($(this).val() == ''){
            $(this).val('请输入验证码');
        }
    });
    
    if(getcookie('rememberPassword') == 2){
        $('input[name=remember]').removeAttr('checked');
    }
	//new
	if(jsperson.captcha_flag==true){
		$("#remember2").show();
		jsperson.loadImage();
		setcookie("TopLoginXoopscaptcha", 'true', 60000000*24 , '/', '',0);
	}else{
		setcookie("TopLoginXoopscaptcha", '', 0 , '/', '',0);
	}
	/*if(getcookie('login_error')){
		var msg = getcookie('login_error');
		jsperson.login_show(msg);
    }*/
	//new end
	var typeid = jsperson.getInfoId('typeid');
	if (typeid!=""){
		$("#typeid").value="/modules/mixed/registerqztjc.php?typeid="+typeid;
	}
    setTimeout(function(){
        if($("#password").val()!="")
        {
            $(".onfocus_psw").hide();
        }
    },1000);
});

var TOPUSERLOGIN = {
    // 检查登录状态
    check           : function () {
        // Clone `this` keyword.
        //var self = this;
        // Send Ajax Request.
        
		return true;
    }
};

var jsperson=jsperson||{};
jsperson.captcha_flag=false;
jsperson.is_common = false;
jsperson.login_show = function(msg){
    $("#remember3").html(msg);
    $("#remember3").show();
	// var timerHide = setTimeout("$('#remember3').hide();;",2000);
};
jsperson.loginIng = function(){
	$('.bottom').addClass('bottom_hidden');
	$('.loading_image').addClass('display');
	$('.loading_image_bg').addClass('display');
	jsperson.is_common = true;
}
jsperson.loginFail = function(){
	$('.bottom').removeClass('bottom_hidden');
	$('.loading_image').removeClass('display');
	$('.loading_image_bg').removeClass('display');
	jsperson.is_common = false;
}
jsperson.checkJobseekerLogin = function(){
    if(jsperson.is_common == true){
        jsperson.login_show('正在登录...');
        return false;
    }
    jsperson.is_common=true;
    var username = $('#uname');
    var password = $('#password');
    var reg = /^([a-zA-Z0-9]|[*_#^@%$&\-=\+~!`():;',.\]\[<>\{\}]){6,20}$/;
    var flag = reg.test(password.val());
    if(flag == false){
        jsperson.login_show('密码格式错误');
        return false;
    }
    if (username.val() == ''  || $('#uname').val() == '请输入手机号/邮箱/用户名') {
        alert(jsperson._MD_NEED_USERNAME);
        username.val();
        username.focus();
        jsperson.is_common=false;
        return false;
    }
    if (password.val() == '') {
        alert(jsperson._MD_NEED_PASSWORD);
        password.focus();
        jsperson.is_common=false;
        return false;
    }
    // var param="uname="+username.val()+"&password="+encodeURIComponent(password.val())+"&http_referer="+$("#http_referer").val();
    var param = {"action":$("#action").val(),"typeid":$("#typeid").val(),"remember":($('input[name=remember]').is(":checked") ? 1 : 0),"uname":username.val(),"password":encodeURIComponent(password.val()),"http_referer":$("#http_referer").val()}
    if(jsperson.captcha_flag==true){
        var xoopscaptcha = $('#id_xoopscaptcha');
        if($('input[name=xoopscaptcha]').val()=='' || $('input[name=xoopscaptcha]').val()=='请输入验证码') {
            alert(jsperson._MD_NEED_CAPTCHA);
            xoopscaptcha.focus();
            jsperson.is_common=false;
            return false;
        }
        // param=param+"&xoopscaptcha="+xoopscaptcha.val();
        param.xoopscaptcha = xoopscaptcha.val();
    }
	jsperson.loginIng();
    // param=param+"&action="+$("#action").val();
    // param=param+"&typeid="+$("#typeid").val();
    // param=param+"&remember="+($('input[name=remember]').is(":checked") ? 1 : 0);

    // 绑定第三方账号也使用登录功能，判断是否绑定
    if($('#isBind').length) {
        param.isBind = 1;
    }
    $.ajax({
        type: "post",
        url: '/modules/jsperson/login_ajax.php'+"?noblock=1",
        data: param,
		dataType: "json",
		//timeout: 3000, //超时时间
        success: function(msg) {
            if(msg.success == 1){
                $(".user_tips").show();
				var cookies = msg.result.cookies;
				setcookie('uid', cookies.uid, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('uname', cookies.uname, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('email', cookies.email, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('utype', cookies.utype, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('login_time', cookies.login_time, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('last_login', cookies.last_login, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie('rememberPassword', cookies.rememberPassword, cookies.expire, '/', '',0);
				setcookie('rememberPassword', cookies.rememberPassword, cookies.expire, '/', cookies.cookiedomain,0);
				setcookie("TopLoginXoopscaptcha", '', 0, '/', '',0);
				setcookie("login_error", '', 0, '/', '',0);
                var domain_num = msg.result.synccookie.length;
                for(i=0;i<msg.result.synccookie.length;i++){
                    $('body').append('<iframe src="'+msg.result.synccookie[i]+'" style="display:none"  rel="synccookie"></iframe>');
                     $("iframe:[rel='synccookie']").bind('load',function () {
                        domain_num--;
                        if(domain_num<=0){
                            // 第三方账号成功绑定跳转至首页
                            if($('#isBind').length) {
                                window.location.href = "/modules/jsperson/index.php";
                                return;
                            }

                            //判断是否可以跳转首页
                            if(cookies.ishost!=null&&cookies.ishost==1)
                            {
                                window.location.href = "http://"+window.location.host;
                            }  
                            else
                                window.location.href = msg.result.url;
                        }
                    });
                }
               
				
				jsperson.is_common=false;
				$.ajax({
					type    : "GET",
					url     : "/modules/jsperson/userinfo_json.php"+"?noblock=1",
					data    : "a=1"
				});

            }else{
                if($("#accountDisable").length && msg.result.disable == 1){
            		$("#accountDisable").show();
            	}else{
                	jsperson.login_show(msg.msg);
                    var errmsg = msg.msg;
                    if(errmsg.indexOf("账号或密码")>-1)
                    {
                        $("input[name='password']").css({'border':'1px solid #f56e6a'});
                        $("input[name='uname']").css({'border':'1px solid #f56e6a'});
                    }
                    else if(errmsg.indexOf("验证码")>-1)
                    {
                        $("input[name='xoopscaptcha']").css({'border':'1px solid #f56e6a'});
                    }
                }
				jsperson.loginFail();
                if(msg.result.captcha_flag==true){
                    $("#remember2").show();
					if(jsperson.captcha_flag==false){
						jsperson.loadImage();
					}else{
						$("#xoopscaptcha").click();
					}
					setcookie("TopLoginXoopscaptcha", 'true', 60000000*24 , '/', '',0);
                    jsperson.captcha_flag = true;
                }
            }
        },
		error:function(XMLHttpRequest, textStatus, errorThrown) {
			jsperson.login_show('登录失败,请重试!!');
			jsperson.loginFail();
		}
    });
    return false;
};
jsperson.loadImage = function(){
    $.ajax({
        type: "get",
        url: '/modules/jsperson/ajax/login_image.php'+"?noblock=1",
        success: function(msg) {
            $("#loadImage").html(msg);
        }
    });
};
jsperson.getInfoId = function(tpyename){
	var request = { 
	 QueryString : function(url, val) {
	  var uri = url;
	  var re = new RegExp("" +val+ "=([^&?#]*)", "ig"); 
	  return ((uri.match(re))?(uri.match(re)[0].substr(val.length+1)):"");
	 } 
	} 
	return request.QueryString(window.location.search, tpyename);
}