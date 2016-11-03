require(["jquery"],function($){
	$("#j-showtip").hide();
    $(".fixedBg").click(function (){
    	$("#btnbm").removeClass('onpost');
        $(this).hide();
        $(".bmAlert").hide();
    });
    $(".bmclosed").click(function (){
    	$("#btnbm").removeClass('onpost');
        $(".fixedBg").hide();
    });
    function getCookie(key) {
		var arr = document.cookie.match(new RegExp("(^| )" + key + "=([^;]*)(;|$)"));
		if (arr !== null)
			return unescape(arr[2]);
		return null;
	}
	
	//报名按钮
	$("#j-baoming").bind('click', function(){
		//统计
		ga('send', 'event', 'pc', 'bm_button', pageConfig.param.zpid);
		
		var login = getCookie('pcuid');
		var obj = $(this);
		if(login){
			if(obj.hasClass('onpost')){
				return false;
			}else{
				obj.addClass('onpost');
			}
			$.ajax({
	            type: 'post',
	            url: '/baoming',
	            data: {
	                'zhaopinid':pageConfig.param.zpid
	            },
	            dataType : 'json',
	            success: function(data) {
	            	obj.removeClass('onpost');
	                if (data.status == '1') {
	                	$(".Js_bmSuccess,.fixedBg").show();
	                }else{
	                	alert(data.msg);
	                }
	            },
	            error:function(){
	            	obj.removeClass('onpost');
	            }
	        });
		}else{
	        $('.Js_bmAlert,.fixedBg').show();
	    }		
    });
    //输入图片验证码 解封短信验证码发送按钮
    $("input[name='captcha']").bind('keyup', function(){
    	var captcha = $("input[name='captcha']").val();
    	var c = /^[a-zA-Z0-9]{4}$/;
        if(!c.test(captcha)){
            return false;
        }else{
        	$(".reg-btn").removeClass('disabled');
        }
    });
    //输入手机号码 解封短信验证码发送按钮
    $("input[name='mobile']").bind('keyup', function(){
    	var mobile = $("input[name='mobile']").val();
    	var r = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/;
        if(!r.test(mobile)){
            return false;
        }else{
        	if(!$("#j-captcha").is(':visible')){
	        	$(".reg-btn").removeClass('disabled');
	        }
        }
    });
    
	//获取短信验证码
    $(".reg-btn").bind('click', function(){
    	if($(this).hasClass('disabled')) return false;
		//统计
		ga('send', 'event', 'pc', 'bm_yzm', pageConfig.param.zpid);
		if($("#j-captcha").is(':visible')){
	    	var captcha = $("input[name='captcha']").val();
	        var mobile = $('input[name="mobile"]').val();
	        var r = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/;
	        var c = /^[a-zA-Z0-9]{4}$/;
	        if(!c.test(captcha)){
	            alert("验证码不正确");
	            return false;
	        }
	        if(!r.test(mobile)){
	            alert("手机号格式错误");
	            return false;
	        }
	        $.ajax({
	            type: 'post',
	            url: '/sendphcode',
	            data: {
	                'phone':mobile,
	                'captcha':captcha,
	            },
	            dataType : 'json',
	            error: function() {
	                alert("请重新发送");
	            },
	            success: function(data) {
	                if (data.status == '1') {
	                	$(".reg-btn").addClass("disabled");
	                    var wait = 60;
						var stime=function(){
							if (wait == 0) {
								$(".reg-btn").removeClass("disabled").html("获取验证码");
								stime=null;
							} else {
								wait--;
								$(".reg-btn").html(wait+"后重新发送")
								setTimeout(function() {
									stime()
								},1000)
							}
						};
						stime();
	                }
	                alert(data.msg);
	            }
	        });	
	    }else{
	        var mobile = $('input[name="mobile"]').val();
	        var r = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/;
	        if(!r.test(mobile)){
	            alert("手机号格式错误");
	            return false;
	        }
	        $.ajax({
	            type: 'post',
	            url: '/sendphcode',
	            data: {
	                'phone':mobile
	            },
	            dataType : 'json',
	            error: function() {
	                alert("请重新发送");
	            },
	            success: function(data) {
	            	if(data.status != '2'){
	            		alert(data.msg);
	            	}else{
	            		$("#j-captcha").removeClass('hide');
	            		$(".reg-btn").addClass('disabled');
	            	}
	                if (data.status == '1') {
	                	$(".reg-btn").addClass("disabled");
	                    var wait = 60;
						var stime=function(){
							if (wait == 0) {
								$(".reg-btn").removeClass("disabled").html("获取验证码");
								stime=null;
							} else {
								wait--;
								$(".reg-btn").html(wait+"后重新发送")
								setTimeout(function() {
									stime()
								},1000)
							}
						};
						stime();
	                }
	            }
	        });
	    }
    });
    //验证短信验证码
    $('input[name="code"]').bind('blur',function(){
    	var code = $("input[name='code']").val();
        var mobile = $('input[name="mobile"]').val();
        var r = /^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/;
        var c = /^[a-zA-Z0-9]{4}$/;
        if(!c.test(code)){
            alert("验证码不正确");
            return false;
        }
        if(!r.test(mobile)){
            alert("手机号格式错误");
            return false;
        }
        $.ajax({
            type: 'post',
            url: '/checkmobile',
            data: {
                'mobile':mobile,
                'code':code
            },
            dataType : 'json',
            success: function(data) {
                if (data.status == '1') {
                	if(data.msg.truename){
						$('input[name="truename"]').val(data.msg.truename).prop('readonly', true);
					}
					if(data.msg.idcard){
						$('input[name="idcard"]').val(data.msg.idcard).prop('readonly', true);
					}
					$("#j-showtip").hide();
                }else{
                	$("#j-showtip").show();
                }
            }
        });
	    return false;
    });
	//报名
	$('#btnbm').click(function () {
		var obj = $(this);
		if(obj.hasClass('onpost')){
			return false;
		}else{
			obj.addClass('onpost');
		}
		var truename = $('input[name="truename"]').val();
		var mobile = $('input[name="mobile"]').val();
		var idcard = $('input[name="idcard"]').val();
		var code = $('input[name="code"]').val();
		if (truename == "")
		{
			alert("请输入你的姓名");
			return;
		}
		if(!/^[0-9]{17}[0-9xX]{1}$/.test(idcard)){
			alert("请输入正确的身份证号");
			return;
		}
		if (!/^1[0-9]{10}$/.test(mobile)) {
			alert("请输入正确的手机号");
			return;
		}
		if(!/^[a-zA-Z0-9]{4}$/.test(code)){
			alert("手机验证码不正确");
			return;
		}
		$.ajax({
			type: "post",
			url: pageConfig.param.bmurl,
			data: {truename:truename,idcard:idcard,mobile:mobile,code:code,zhaopinid:pageConfig.param.zpid},
			dataType:'json',
			success: function (data) {
				obj.removeClass('onpost');
				if (data.status == 0) {
					alert(data.msg);
				}else {
					$('.Js_bmAlert').hide();
					$(".Js_bmSuccess,.fixedBg").show();
					if(data.msg.mobile){
						$(".Js_bmSuccess").find(".j-showuserinfo").html('您的职多多账户: '+data.msg.mobile+'<i class="ins"></i>密码: '+data.msg.password+'</p>');
					}else{
						$(".Js_bmSuccess").find(".j-showuserinfo").html('');
					}	
				}
				//统计
				ga('send', 'event', 'pc', 'bm_confirm', pageConfig.param.zpid);			
				
			},
            error:function(){
            	obj.removeClass('onpost');
            }
		});
	});
	(function(){		
        var $big = $("#js_des_big");
        var strsrc,strtxt;
        var curimg="";
        var content = $("#js_content_img");
        var content_list = $("#js_content_img_list");
        var len = content.find(".pic_small_pic").length;
        var $_this = $("#js_content_img_list .pic_small_pic");
		$_this.each(function(index){
			$(this).bind("mouseenter",function(){
				//setTimeout(function(){
					o=$(this);
					strsrc = $(this).attr("rel");
					$("#loading").css("display","block");
 
					loadImage(strsrc,function(){
						$("#loading").css("display","none");
						$big.find("img.bigimg").attr("src",strsrc);
						$big.stop(1,1).fadeOut(0).fadeIn(500);
						o.addClass("selected").siblings().removeClass("selected");
						curimg = index;						
					})

				//},1000);
			})			
		});
		$_this.eq(0).trigger("mouseenter");
		function loadImage(url, callback) {     
			var img = new Image(); 
			img.onload = function(){
				img.onload = null;
				callback();
			}
			img.src = url; 
		}
        //绑定click事件
        $(".prevbtn").click(function(){
            curimg=curimg<=0 ? (len - 1) : --curimg;
            scrollpic(-1,138,4);
        });
        //往前 按钮
        $(".nextbtn").click(function(){
            curimg=curimg>=(len - 1) ? 0 : ++curimg;
            scrollpic(1,138,4);
        });
        function scrollpic(dir,wid,show) {
            if(!content_list.is(":animated") ){
                if(dir==-1) {
                    if(parseInt(content_list.css("left"))<0){
                        content_list.animate({ left : '+='+wid}, 300);
                    }else {
                        if(curimg == (len-1)&&(len>show)){
                            content_list.animate({ left : (-1*(len-show)*wid)}, 300);
                        }
                    }
                } else if(dir==1){
                    if(parseInt(content_list.css("left"))>(-1*(len-show)*wid)){
                        content_list.animate({ left : '-='+wid}, 300);
                    }else {
                        if(curimg == 0){
                            content_list.animate({ left : 0}, 300);
                        }
                    }
                }
                $_this.eq(curimg).trigger("mouseenter");
            }
        }
    })();
	$(function(){
        //鼠标经过
        $(".job-list .job-box").each(function(){
            $(this).hover(function(){
                $(this).addClass("hoverd");
            },function(){
                $(this).removeClass("hoverd");
            })
        });	
	})
	
}) 

 
