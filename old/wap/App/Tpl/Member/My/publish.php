<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>我的发布--建筑工人网</title>
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{$_static_}/js/modal.js"></script>
<style type="text/css">
  .zuo1{position: relative}
  #del{position: absolute;bottom: 20px;right: 20px;width: 40px;font-size: 16px;}
  .you1{margin-top: 10px;}
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
    <h2>我的发布记录</h2>
  </div>
  <div class="fa" id="result_inner">

    <volist name="list" id="vl">
        <div class="fa_1">
          <div class="zuo1">
            <div style=" float:left; margin-left:10px; margin-top:10px;position:relative">
              <p style="color:#474747; font-size:16px; line-height:40px; font-weight:700;"><a href="{$_root}publish/detail/pid/{$vl.pid}.html">{$vl.title}</p>
              <p style=" line-height:38px;">{$vl.appchange} <div style="position: absolute; width:60px; height:20px; top: 43px; left: 150px; background-color:#cc0c0c; color:#FFF; text-align:center; border-radius:5px; line-height:20px;">
                <if condition="$vo.rterrace eq 1">平台认证
                <elseif condition="$vo.renzheng eq 1"/>个人认证
                <else/>未认证
                </if></div></p>
              <p style=" line-height:40px;">发布时间：{$vl.addtime}</p>
            </div>
            <div class=" you1">
              <a href="{$_root}publish/edit/pid/{$vl.pid}.html">
              <img src="{$_static_}/images/fabu_07.png"></a></div>
            <span id="del"><a href="javascript:;" onclick="del({$vl.pid})">删除</a></span>
          </div>

        </div>
    </volist>
  </div>
  <if condition="is_array($list)">
    <div class="bl_more" id="more"><a href="javascript:;" onclick="get_content()">加载更多</a></div> 
    </if>
  <div class="xuqiu"><img src="{$_static_}/images/jia.png"><div class="xu"><a style="color:#fff" data-toggle="modal"  href="#login-modal">发布新需求</a></div></div>
</div>

<div class="modal" id="login-modal">
  <a class="close" data-dismiss="modal">×</a>
   <h1>请按规范发布相关类型</h1> 
  <ul class="login-bind-tp">
    <li class="duizhaoren"> <a href="{$_root}publish/duizhaoren">队找人</a> </li>
    <li class="huozhaodui"> <a href="{$_root}publish/huozhaodui"> 活找队</a> </li>
    <li class="duizhaohuo"> <a href="{$_root}publish/duizhaohuo"> 队找活</a> </li>
        <li class="fucai"> <a href="{$_root}publish/fucai">  辅材购买</a> </li>
    <li class="shebei"> <a href="{$_root}publish/shebei"> 设备承租</a> </li>
  </ul>
</div>

<script src="{$_static_}/layer/layer.js"></script>
<script type="text/javascript">

function del(pid){
  layer.confirm('您确定要删除吗？',  {skin: 'layui-layer-molv',offset: '30%'}, function(index){
      layer.close(index);
      $.ajax({
          url:"{$_root}member/my/delpubish",
          data:{pid:pid},
          type:"get",
          dataType:"json",
          timeOut:2000,
          success:function(res){
              if(res.status==1) {
                  layer.msg("删除成功");
                  window.location.reload();
              }else layer.msg(res.message);
          },
          error:function(){
              layer.msg("出错啦");
          }
      })
  })
}

var p=2;
var index;
function get_content(){
  $.ajax({
    url:"{$_root}member/my/publish",
    type: 'post', 
    data:{page:p}, 
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