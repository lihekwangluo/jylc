<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>我的收藏 — 建遇良才</title>
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<style>
  .bg a{
    color:#fff;
  }
</style>
</head>

<body>
<div style="width:100%;  background-color:#fff;" class="mobile">
  <div class="tou"><a href="{$_root}member"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>
    <h2>我的收藏</h2> </div>
  <br>
	<div class="shou">
	<ul>
    	<li><p class="<eq name='sort' value='1'>bg</eq>"><a href="{$_root}member/my/collect?sort=1">职位收藏</a></p></li>
      <li><p class="<eq name='sort' value='2'>bg</eq>"><a href="{$_root}member/my/collect?sort=2">辅材信息</a></p></li>
      <li style="border-right:none;"><p class="<eq name='sort' value='3'>bg</eq>"><a href="{$_root}member/my/collect?sort=3">设备承租</a></p></li>
	
    </ul></div>

  <div class="fa">

    <volist name="list" id="vl">
      <div class="fa_1">
        <div class="zuo1">
          <div style=" position:relative; float:left; margin-left:10px; margin-top:10px;">
            <p style="color:#474747; font-size:16px; line-height:40px; font-weight:700;">{$vl.title}</p>
            <p style=" line-height:38px;"></p>
            <p style=" line-height:40px;">{$vl.addtime}</p>
          </div>
          <div class=" you11">
            <div style="position: absolute; width:60px; height:20px; top: 0; left:50%; margin-left:-30px; color:#FFF; text-align:center; line-height:20px;">
              <a href="javascript:;" onclick="collect('{$vl.pid}')">删除</a></div>
            <div style="position: absolute; width:60px; height:20px; top: 60px; left:50%; background-color:#cc0c0c; margin-left:-30px; color:#FFF; text-align:center; border-radius:5px; line-height:20px;">
              <if condition="$vl.rterrace eq 1">平台认证
                <elseif condition="$vl.renzheng eq 1"/>个人认证
                <else/>未认证
                </if></div>
          </div>
        </div>
      </div>
    </volist>
  </div>

</div>
<script type="text/javascript" src="{$_static_}/layer/layer.js"></script>
<script type="text/javascript">
  
  function collect(pid){
      var index = layer.load(2,{shade:false});
      $.post("{$_root}publish/collect",{pid:pid},function(res,s){
            layer.close(index);
            layer.msg(res);
            window.location.reload();
      })
  }

</script>
</body>
</html>
