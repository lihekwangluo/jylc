<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no">
<title>建遇良才-首页</title>
<link href="{{ asset('wap/public/css/owl.carousel.css') }}" rel="stylesheet">
<link href="{{ asset('wap/public/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('wap/public/css/public.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('wap/public/css/index.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('wap/public/css/tcstyle.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('wap/public/js/jquery-1.10.2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('wap/public/js/modal.js') }}"></script>

<script src="{{ asset('wap/public/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('wap/public/layer/layer.js') }}"></script>
<script src="{{ asset('wap/public/js/tou.js') }}"></script>
<script src="{{ asset('wap/public/js/jquery.cookie.js') }}"></script>
<style type="text/css">
.m_nav a.current span {
   color:#279630;
}
</style>
  
</head>

<body>
<div style="height:840px; background-color:#f4f4f4;" class="mobile">
  <div class="header"> 
    <input name="sousuo" id="sousuo" type="text" class="sy_ss">
    <div class="m_search"><a href="javascript:;" onclick="soso()"><img src="{{ asset('wap/public/images/m-index_05.png') }}" width="40"></a></div>
  </div>
  <div class="da1" style="display:none;">
  <div class="qr" style=" width:90%; height:300px; background-color:#FFF; border-radius:10px; margin:0 auto; margin-top:10px;"> <div class="nei3"  style=" height:300px;">
    <p style="border:none;">
      <span style="font-size:14px; color:#F30; text-indent:24px;">热门搜索:</span>
      <volist name="s_list" id="vl">
        <if condition="$key eq 0">
          <span style="padding-left:16px;"><a href="index/search/soso/{$vl.name}">{$vl.name}</a></span>
          <else/>
          <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
            <a href="index/search/soso/{$vl.name}">{$vl.name}</a></span>
        </if>
      </volist>
    </p>
  </div></div>
  <div style=" width:90%; height:300px; background-color:#FFF; border-radius:10px; margin:0 auto; margin-top:10px;">
    <div class="nei3" style=" height:300px;">
       <p><span style="font-size:14px; color:#090;">历史搜索</span></p>
       <volist name="word" id="vl">
        <p><span style="font-size:14px;"><a href="index/search/soso/{$vl}">{$vl}</a></span></p>
        </volist>

    </div></div>
  </div>
  <div class="da11" style="display:block;">
  <div class="top w"> 
    <div class="m_nav"> 
    <a href="javascript:void(0)" onclick="get_content(4)" class="current"><img  style="width: 60px;height: 60px;" src="{{ asset('wap/public/images/1f_07.png') }}"><span>队找人</span></a>
    <a href="javascript:void(0)" onclick="get_content(2)"><img  style="width: 60px;height: 60px;" src="{{ asset('wap/public/images/1f_09.png') }}"><span>活找队</span></a>
    <a href="javascript:void(0)" onclick="get_content(3)"><img  style="width: 60px;height: 60px;" src="{{ asset('wap/public/images/1f_11.png') }}"><span>队找活</span></a>
    <a href="javascript:void(0)" onclick="get_content(5)"><img  style="width: 60px;height: 60px;" src="{{ asset('wap/public/images/1f_13.png') }}"><span>辅材购买</span></a>
    <a href="javascript:void(0)" onclick="get_content(1)"><img  style="width: 60px;height: 60px;" src="{{ asset('wap/public/images/1f_15.png') }}"><span>设备承租</span></a> </div>
  </div>

  <div class="fenge"></div>
  <div class="shaixuan">
    <label for="shen"></label>
    <select name="shen" class="loyln" id="shen">
      <option value="0" selected>--- 地区 ---</option>
      <volist name="a_list" id="vl">
      <option value="{$vl.id}">{$vl.area_name}</option>
      </volist>
    </select>
    <label for="gongzhong"></label>
    <select name="gongzhong"  class="loyln" id="gongzhong">
      <option value="0" selected>--- 工种 ---</option>
      <volist name="t_list" id="vl">
      <option value="{$vl.id}">{$vl.name}</option>
      </volist>
    </select>
    <label for="daiyu"></label>
    <select name="daiyu"  class="loyln" id="daiyu">
      <option value="0" selected>--- 待遇 ---</option>
      <option value="100,200">100-200/天</option>
      <option value="201,299">201-300/天</option>
      <option value="301,400">301-400/天</option>
      <option value="401,500">401-500/天</option>
      <option value="501,600">501-600/天</option>
    </select>
  </div>
  <div class="bw-menu">
    <ul>
      <li><span>认证</span> </li>
      <li class="bw-current"><span>全部</span> </li>
    </ul>
  </div>
  <div class="m_baoliao w" style="padding-bottom: 70px;"> 

    <div class="fenge"></div>
    <div class="baoliao_list" id="result_inner">
<!-- 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材 -->

  	</div>
      <div class="bl_more" id="more"><a href="javascript:;" onclick="get_content()">加载更多</a></div> 
  </div>
  </div>
  
  <div class="gotop backtop" style="display:none;"></div>
  <div class="daoh">
    <footer>
      <a href="/">
      <div class="foot act"> <img src="{{ asset('wap/public/images/foot/1f_45.png') }}">
        <p>首页</p>
      </div>
      </a>
      <a href="workmate?status=1">
      <div class="foot"> <img src="{{ asset('wap/public/images/foot/1f_39.png') }}">
        <p>工友圈</p>
      </div>
      </a>
      <a href="workmate?status=2">
      <div class="foot"> <img src="{{ asset('wap/public/images/images/tutu_07.png') }}">
        <p>子女教育</p>
      </div>
      </a>
      <a href="member">
      <div class="foot">  <img src="{{ asset('wap/public/images/foot/1f_51.png') }}">
        <p>我的</p>
      </div> </a>
      </footer>
    <div class="weixin weixin_fd "> 
    <div class="fabu_an" style=" width:60px; height:60px;line-height:60px;"><a  data-toggle="modal"  href="#login-modal"> 发布</a></div>
    <!--弹出--> 
  </div>
  <div class="modal" id="login-modal">
	<a class="close" data-dismiss="modal">×</a>
	 <h1>请按规范发布相关类型</h1> 
	<ul class="login-bind-tp">
		<li class="duizhaoren"> <a href="publish/duizhaoren">队找人</a> </li>
		<li class="huozhaodui"> <a href="publish/huozhaodui"> 活找队</a> </li>
		<li class="duizhaohuo"> <a href="publish/duizhaohuo"> 队找活</a> </li>
        <li class="fucai"> <a href="publish/fucai">  辅材购买</a> </li>
		<li class="shebei"> <a href="publish/shebei"> 设备承租</a> </li>
	</ul>
	 
</div>
 <!--弹出结束--> 
</div>
    </div>
    
<script type="text/javascript">

function soso(){
  var title = $("#sousuo").val();
  window.location.href="index/search/soso/"+title;
}

get_content(4);

$(".m_nav a").click(function(){
    $(this).addClass("current").siblings("a").removeClass('current');
})

$('#sousuo').click(function(){
    d=$(".da11").css("display")
    if(d=="block"){
        $(".da11").css("display","none")
        $(".da1").css("display","block")
    }else{
        $(".da1").css("display","none")
        $(".da11").css("display","block")
     }
})

var p=1;
var index;
var status = 4; //首页默认4
var craftid=0,area1=0,renzheng=0,price=null; //工种，地区，认证，价格

//地区筛选
$("#shen").change(function(){
    if($("#shen option:selected").val()){
       area1 = $("#shen option:selected").val();
       p=1
       get_content(status);
    }
})

//工种筛选
$("#gongzhong").change(function(){
    if($("#gongzhong option:selected").val()){
        craftid = $("#gongzhong option:selected").val();
        p=1
        get_content(status);
    }
})

//价格筛选
$("#daiyu").change(function(){
    if($("#daiyu option:selected").val()){
        price = $("#daiyu option:selected").val();
        p=1
        get_content(status);
    }
})

//认证筛选
$(".bw-menu ul li").click(function(){
    var index = $(this).index();
    if($(this).attr("class")!="bw-current"){
        $(this).addClass("bw-current").siblings("li").removeClass("bw-current");
        if(index==0) renzheng = 1;
        else renzheng=0;
        p=1
        get_content(status);
    }
})


function get_content(s){
	$("#more").show();
	if(s) {
		status = s;
		p=1;
		$('#result_inner').empty();
	}
	$.ajax({
		url:"index",
		type: 'post', 
		data:{status:status,area1:area1,craftid:craftid,price:price,renzheng:renzheng,page:p}, 
		dataType: 'json', 
		timeout: 10000, 
		error: function(){
		   layer.close(index);
        layer.msg("出错啦");
		},
		beforeSend:function(){
			index = layer.load(2, {shade: false});
		},
		success:function(result){
			layer.close(index);
			if(result.status==1) {
				$('#result_inner').append(result.info);
				p = result.next;
			}
			else {
				$("#more").hide();
				layer.msg(result.message);
			}
		} 
	});	

}
	
</script>

</body>
</html>