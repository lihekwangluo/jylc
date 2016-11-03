<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>意见反馈 — 建筑工人网</title>

<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"> </a>  <h2>意见反馈</h2>
  </div>
  <div class="nei21_1" style=" padding-top:20px;">
   <textarea id="content" style=" width:100%; display:block; height:200px; margin:0 auto; text-align: left; border-radius:10px; border:1px solid #ccc; line-height:30px;"></textarea> 
    
  </div>
  <div class="cha_2"><div class="nei3" style="text-align: left;">
    <p><span style="font-size:14px;">姓 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span><span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><input id="name" type="text" style="border:none; line-height:30px;"/></span></p>
  	<p><span style="font-size:14px;">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话</span><span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><input id="mobile" type="mobile" style="border:none; line-height:30px;"/></span></p></div>
  	<img style="margin-bottom:0px;" id="sub" src="{$_static_}/images/aniu.png"></div>
</div>

<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<script src="{$_static_}/layer/layer.js"></script>

<script type="text/javascript">
	
	$("#sub").click(function(){
	    var name = $("#name").val();
	    var mobile = $("#mobile").val();
	    var content = $("#content").val();
	    if(!name||!mobile||!content) {
	    	layer.msg("请填写完整再提交");
	    	return false;
	    }
	    var index = layer.load(2,{shade:false});
	    $.ajax({
	    	url:"{$_root}member/my/suggest",
	    	type:"post",
	    	data:{name:name,mobile:mobile,content:content},
	    	dataType:"json",
	    	timeOut:2000,
	    	error:function(){
	    		layer.close(index);
	    		layer.msg("出错啦");
	    	},
	    	beforeSend:function(){

	    	},
	    	success:function(res){
	    		layer.close(index);
	    		if(res.status==1){
	    			layer.msg("提交成功");
	    			window.location.reload();
	    		}else{
	    			layer.msg(res.message);
	    		}
	    	}
	    })
	})

</script>

</body>
</html>
