<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>{$vo.title}详情</title>
<script type="text/javascript" src="{$_static_}/js/jquery-1.10.2.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<script src="{$_static_}/layer/layer.js"></script>
<style type="text/css">
.renz_bs { color:#FFF; font-size:12px; float:right; margin-bottom:10px; background:#C03; text-align:center; width:80px; height:25px; border-radius:3px; line-height:25px;}
.renz_bs1 { color:#FFF; font-size:12px; float:right; background:#06F; text-align:center; width:80px; height:25px; border-radius:3px; line-height:25px; margin-bottom:10px; }
</style>
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
	<div class="tou">
		<img src="{$_static_}/images/zuo.png" onclick="window.history.go(-1);" style="margin-top:6px; cursor:pointer; float:left;">  
		<a href="javascript:;" onclick="collect()"><img style="cursor:pointer; float: right;margin-top:6px;" src="{$_static_}/images/images/fden_05.png"></a>
    <!-- <img  style=" float: right; cursor:pointer;margin-top:10px; margin-right:10px;" src="{$_static_}/images/images/fden_03.png">  -->
    <h2>
    	<if condition="$vo.status eq 1">设备出租
    	<elseif condition="$vo.status eq 2"/>活找队
    	<elseif condition="$vo.status eq 3"/>队找活
    	<elseif condition="$vo.status eq 4"/>队找人
    	<elseif condition="$vo.status eq 5"/>辅材购买
    	</if>
    </h2>
  </div>
  <div class="biao" style="overflow:auto;">
  	<div  class="zuo"><h4>{$vo.title}</h4><p style="float:left;">发布时间：{$vo.addtime}</p>
  	</div>
    <div  class="you">
    	<if condition="($vo.type eq 1) and ($vl.renzheng eq 1)">
	        <div class="renz_bs1">个人认证</div>
	    <elseif condition="$vl.rterrace eq 1"/>
	        <div class="renz_bs1">企业认证</div>
	    <else/>
	        <div class="renz_bs">未认证</div>
	    </if>
    	<p></p>
    	<a href="javascript:void(0);"><a href="{$_root}publish/jubao/pid/{$vo.pid}/title/{$vo.title}.html"><img src="{$_static_}/images/images/tu_07.png" style="margin-top:5px;"></a></div>
  </div>

  <if condition="in_array($vo['status'],array(1,5))">
  <php>$pic = $vo['pic'];</php>
  <!-- <div class="wai">
	  <div class="da">
		       <ul class="dian">
		       	<volist name="pic" id="vl">
		      	<li class="<if condition='$key eq 0'>on</if>"></li>
		      	</volist>
		       </ul>
		      <div class="nei">
		      <ul>
		      	<volist name="pic" id="vl">
		      	<li><img src="{$vl}" width="300"/></li>
		      	</volist>
		      </ul>
		      </div>
	    </div>
  </div> -->
  <script>
	$(function(){
		var t=0
		var p
		var count = <php>echo count($pic)?count($pic):0;</php>;
		if(count>1){
			$(".dian li").click(function(){
			d=$(".dian li").index(this)
			for(var i=0;i<count;i++){
				$(".dian li").eq(i).removeClass("on")
				}
				$(".dian li").eq(d).addClass("on")
				$(".nei").animate({left:0-d*300},500)
			})
			window.onload=function aa(){
			t++
			for(var i=0;i<count;i++){
					$(".dian li").eq(i).removeClass("on")
					}
					var num = count-1;
				if(t>num){
					t=0
					}
					$(".dian li").eq(t).addClass("on")
					$(".nei").animate({left:0-t*300},500)
					p=window.setTimeout(function(){  aa() },2000)
			}
		}
		
	})
	</script>
  </if>

  <div class="nei1">
  <!-- 第一行 -->
  	<p style="border-top:5px solid #e5e5e5;padding-left: 0px;">
  		<if condition="$vo.status eq 1">
  			<span style="font-size:14px;">数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;量</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.num}台</span>
  		<elseif condition="$vo.status eq 2" />
  			<span style="font-size:14px;">项目类型</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.mold.0.name}</span>
  		<elseif condition="$vo.status eq 3" />
  			<span style="font-size:14px;">现有工种</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.craft}</span>
  		<elseif condition="$vo.status eq 4" />
  			<span style="font-size:14px;">需要工种</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.craft}</span>
  		<elseif condition="$vo.status eq 5" />
  			<span style="font-size:14px;">经营范围</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.alcor.0.name}</span>
		 </if>
    </p>
    
    <!-- 第二行 -->
  	<p>
  		<if condition="$vo.status eq 1">
  			<span style="font-size:14px;">规格型号</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.model}</span>
  		<elseif condition="$vo.status eq 2" />
        <span style="font-size:14px;">工程总价</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.price}</span>
  		<elseif condition="$vo.status eq 3" />
  			<span style="font-size:14px;">队伍人数</span>
			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.num}人</span>
  		<elseif condition="$vo.status eq 4" />
  			<span style="font-size:14px;">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.age1}-{$vo.age2}</span>
  		<elseif condition="$vo.status eq 5" />
  			<span style="font-size:14px;">详细地址</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.area.0.area_name}{$vo.area.1.area_name}{$vo.area.2.area_name}{$vo.address}</span>
		  </if>
  	</p>
    
    <!-- 第三行 -->
    <p>
      <if condition="$vo.status eq 1">
        <span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.area.0.area_name}{$vo.area.1.area_name}{$vo.area.2.area_name}{$vo.address}</span>
      <elseif condition="$vo.status eq 4" />
        <span style="font-size:14px;">需要人数</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.num}</span>
      </if>
    </p>
  </div>
  <div class="nei2">
    <!-- <h6>
    	<if condition="$vo.status eq 1">文字描述
    	<elseif condition="$vo.status eq 2" />项目描述
    	<elseif condition="$vo.status eq 3" />队伍描述
    	<elseif condition="$vo.status eq 4" />招工要求
    	<elseif condition="$vo.status eq 5" />店铺描述
    	</if>
    </h6> -->
    <!-- <p>{$vo['content'][0]}</p> -->
    <p>
      <if condition="$vo.status eq 1">
        <span style="font-size:14px;">设备描述</span>
        <p><span style="padding-left:16px;margin-left:16px;">{$vo['content'][0]}</span></p>
      <elseif condition="$vo.status eq 2" />
        <span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.area.0.area_name}{$vo.area.1.area_name}{$vo.area.2.area_name}{$vo.address}</span>
      <elseif condition="$vo.status eq 3" />
        <span style="font-size:18px;">队伍描述</span>
        <p >
        <span style="margin-left:16px;">{$vo['content'][0]}</span></p>
      <elseif condition="$vo.status eq 4" />
        <span style="font-size:14px;">工资待遇</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
        <if condition="$vo.price eq 0 and $vo.price2 eq 0">面议 <else/> {$vo.price}-{$vo.price2}</if>      
        </span>
      <elseif condition="$vo.status eq 5" />
        <span style="font-size:18px;">店铺描述</span>
        <span style="padding-left:16px;margin-left:16px;">
        {$vo['content'][0]|mb_substr=###,0,140,'utf-8'}...</span>
      </if>
    </p>

    <p>
      <if condition="$vo.status eq 2">
      <!-- <elseif condition="$vo.status eq 2" /> -->
        <span style="font-size:14px;">工作要求</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo['content'][0]}</span>
      <elseif condition="$vo.status eq 4" />
        <span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><img src="">{$vo.address}</span>
      </if>
    </p>

    <p>
      <if condition="$vo.status eq 4">
      <p style="border-top:5px solid #e5e5e5;padding-left: 10px;padding-top: 10px;">
        <span style="font-size:18px;">招工要求</span>
        <p style="padding-left:16px;">{$vo['content'][0]}</p></p>
      </if>
    </p>


    
      <!-- <if condition="$vo.status eq 1">文字描述
      <elseif condition="$vo.status eq 2" />项目描述
      <elseif condition="$vo.status eq 3" />队伍描述
      <elseif condition="$vo.status eq 4" />招工要求
      <elseif condition="$vo.status eq 5" />店铺描述
      </if>
    
    <p>{$vo['content'][0]}</p> -->
  </div>
  <div class="nei3">
  		<p><span style="font-size:14px;">联&nbsp;&nbsp;系&nbsp;&nbsp;人</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">{$vo.username}</span></p>
  		<p><span style="font-size:14px;">联系电话</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><if condition="$Think.cookie.uid gt 0">{$vo.moblie}<else/>{$vo.moblie|substr=###,0,7}****</if>（联系我时请说在建业良机看到的。）</span></p></div>
    <div class="cha">
    	<a href="{$_root}publish/other/userid/{$vo.uid}"><img class="on1" style="cursor:pointer;" src="{$_static_}/images/images/dian_03.png"></a><br/>
    	<a href="<if condition='$Think.cookie.uid gt 0'>tel:{$vo.moblie}<else/>{$_root}login</if>"><img style="cursor:pointer;" src="{$_static_}/images/images/dian_07.png"></a>
    	<!-- <img src="{$_static_}/images/images/dian_08.png">
    	<img style="cursor:pointer;" src="{$_static_}/images/images/dian_09.png"> -->
    </div>
</div>

<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"4","bdPos":"right","bdTop":"135.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script type="text/javascript">
  
  function collect(){
      var pid = {$vo.pid|default="0"};

      var index = layer.load(2,{shade:false});
      $.post("{$_root}publish/collect",{pid:pid},function(res,s){
            layer.close(index);
            layer.msg(res);
      })
  }

</script>
</body>
</html>