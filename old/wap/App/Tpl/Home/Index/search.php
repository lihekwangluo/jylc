<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>搜索{$title}-建遇良才</title>
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<style type="text/css">
  #more{
    height: 40px;
    line-height: 40px;
    text-align: center;
  }
</style>
</head>

<body>
<div style="width:100%; background-color:#fff;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>
    <h2>搜索{$title}</h2>
  </div>
  <div class="fa" id="result_inner">

    <volist name="list" id="vl">
        <div class="fa_1">
          <div class="zuo1">
            <div style=" float:left; margin-left:10px; margin-top:10px;position:relative">
              <p style="color:#474747; font-size:16px; line-height:40px; font-weight:700;"><a href="{$_root}publish/detail/pid/{$vl.pid}.html">{$vl.title}</a></p>
              <p style=" line-height:38px;">{$vl.appchange} 
               </p>
              <p style=" line-height:40px;">发布时间：{$vl.addtime}</p>
            </div>
            <div class=" you1">
              <a href="{$_root}publish/detail/pid/{$vl.pid}.html">
                 <div style=" width:60px; height:20px;margin-top: 30px; background-color:#cc0c0c; color:#FFF; text-align:center; border-radius:5px; line-height:20px;">
                <if condition="$vo.rterrace eq 1">平台认证
                <elseif condition="$vo.renzheng eq 1"/>个人认证
                <else/>未认证
                </if></div>
              </a></div>
          </div>
        </div>
    </volist>
  </div>
  <if condition="is_array($list)">
    <div class="bl_more" id="more"><a href="javascript:;" onclick="get_content()">加载更多</a></div> 
    </if>
</div>

<script src="{$_static_}/layer/layer.js"></script>
<script type="text/javascript">
var p=2;
var index;
var title = '{$title|default="0"}';
function get_content(){
  $.ajax({
    url:"{$_root}index/search",
    type: 'post', 
    data:{page:p,soso:title}, 
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