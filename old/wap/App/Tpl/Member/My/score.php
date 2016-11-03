<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>我的积分 — 建筑工人网</title>

<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
</head>

<body style="width:100%; background-color:#FFF;">
<div style="width:100%; background-color:#FFF;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"> </a>  <h2>我的积分</h2></div>
<div class="jifen">
	  <div class="yuan1"><span class="onn">积分额度</span><span class="onnn">{$score|default="0"}</span><span class="onnnn">积分详情</span></div>
        <a href="{$_root}member/index/exchange"><div class="dui">去兑换</div></a>
        
    </div>  

<div  class="lizi">积分规则</div>
<div class="guize">
	<volist name="list" id="vl">
	<p>{$vl}</p>
	</volist>
</div>
</div>

</body>
</html>
