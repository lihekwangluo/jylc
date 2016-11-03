<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no">
<title>兑换记录</title>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<style type="text/css">
  .jilu{ width:95%; height:170px; margin:0 auto; border-bottom:1px solid #e3e3e3; min-width:480px; } 
.jilu1{ width:152px; height:170px; float:left;}
.jilu2{ width:220px; height:170px; float:left; margin-left:20px;}
.jilu2 h3{  color:#5e5e5e; line-height:50px; margin-top:12px;}
.liping{width:95%; margin:0 auto; height:170px;   min-width:480px; }
.liping1{ width:152px; height:170px; float:left;}
.liping2{ width:220px; height:170px; float:left; position:relative; margin-left:20px;}
.liping21{  width: 88px;  height: 37px; border-radius: 3px; background-color: #efab02;  position: absolute; z-index: 2;
  top: 97px;
  color:#FFF;
  line-height:37px;
  text-align:center;
  font-size:14px;
  left: 15px;
}
</style>
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>   
    <h2>兑换记录</h2>
  </div>
  <div  class="cha_29" style="height:800px; background-color:#FFF;">

    <volist name="list" id="vl">
  	<div class="jilu">
    	<div class="jilu1"><img style="margin-top:20px;" src="{$vl.pic}"></div>
        <div class="jilu2"><h3 >{$vl.content}</h3><p>消耗：<span style="color:#F30;">{$vl.num}积分</span></p><p>{$vl.addtime}</p></div>
    </div>
    </volist>

</div>
</div>
</body>
</html>
