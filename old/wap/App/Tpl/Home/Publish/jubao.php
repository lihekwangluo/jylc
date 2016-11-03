<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>举报</title>
<script type="text/javascript" src="{$_static_}/js/jquery-1.10.2.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<script src="{$_static_}/layer/layer.js"></script>
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>   <h2>举报</h2>
  </div>
  <div class="nei21" style="height:250px; min-width:440px;">
    <h6 style="color:#666;">你将举报：<span  style="font-size:12px; color:#048e14;">{$title}</span></h6>
    <div class="juz">
    	<ul>
        	<li><input type="checkbox" name="reason" class="reason" value="信息与描述不符" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 72px; top: 3px;">信息与描述不符</span></li>
            <li><input type="checkbox" name="reason" class="reason" value="信息已过期" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 72px; top: 43px;">信息已过期</span></li>
            <li><input type="checkbox" name="reason" class="reason" value="联系电话不对" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 72px; top: 83px;">联系电话不对</span></li>
        </ul>
    </div>
    <div class="juy"><ul>
        	<li><input type="checkbox" name="reason" class="reason" value="敏感信息" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 32px; top: 3px;">敏感信息</span></li>
            <li><input type="checkbox" name="reason" class="reason" value="垃圾广告" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 32px; top: 43px;">垃圾广告</span></li>
            <li><input type="checkbox" name="reason" class="reason" value="拖欠工资" /><!-- <img src="{$_static_}/images/jubao.png"> --><span style="position: absolute; left: 32px; top: 83px;">拖欠工资</span></li>
        </ul></div>
  </div>
  
  <div style=" height:470px;" class="cha_2"><div class=" sl"><span style="margin-right:10px;">我有话说</span></div><div class=" sr"><textarea name="" id="content" style="border:none; width:97%; padding:10px; height:95px; margin-top:3px;" cols="" rows=""></textarea></div> 
  <div onclick="sub()" style="float:left;width:300px; height:42px; background-color:#06c1b0; border-radius:3px; 
  margin-left:50px; text-align:center; margin-top:40px;color:#FFF; font-size:18px; line-height:42px;">举报</div></div>
</div>
<script type="text/javascript">

function sub(){
  var p ={};
  var reason = '';
  var pid = {$pid|default="0"};
    p.pid = pid;
    $(".reason:checked").each(function(key,v){
        if(key==0) reason += $(v).val();
        else reason += " "+$(v).val();
    });
    p.reason = reason;
    p.content = $("#content").val();
    if(!p.pid||!p.reason||!p.content) {
      layer.msg("请填写举报信息");
      return false;
    }
    var index = layer.load(2,{shade:false});
    $.ajax({
        url:"{$_root}publish/jubao",
        type:"post",
        data:p,
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
                layer.msg("举报成功");
                window.history.go(-1);
            }else {
              layer.msg(res.message);
            }
        }
    }) 

}
    
</script>
</body>
</html>
