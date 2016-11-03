<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no">
<title>完善个人资料</title>
<script type="text/javascript" src="{$_static_}/js/jquery-1.10.2.min.js"></script>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="{$_static_}/My97DatePicker/WdatePicker.js"></script>
<style type="text/css">

</style>
</head>

<body>
<div style="width:100%; background-color:#ececec;padding-bottom: 30px;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>   <h2>完善个人资料</h2>
  </div>
  <div class="biao">
  	<div  class="zuo">
    <img src="{$_static_}/images/<if condition='empty($vo[pic])'>geren_03.png<else/>{$vo.pic}</if>"> 
    </div>
    <div  class="you"><!-- <img style="margin-top:27%;" src="{$_static_}/images/hui.png"> --></div>
  </div>
  <div class="nei3">
    <p><span style="font-size:14px;">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称</span>
      <span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
        <input type="text" id="nickname" value="{$vo.nickname}" style="border:none; line-height:30px;"/></span></p>
  <p><span style="font-size:14px;">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span>
    <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
      <input type="text" id="name" readonly value="{$vo.name}" style="border:none; line-height:30px;"/></span></p></div>
   <div class="nei3">
    <p style=""><span style="font-size:14px;">出生年月</span>
      <span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
         <input class="Wdate" id="Wdate_b" readonly type="text" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" style="border:none; line-height:30px;" value="{$vo.chusheng}"> 
        </span></p>
  <p style="">
    <span style="font-size:14px;">性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</span>
    <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
      <select name="" id="sex">
        <option <eq name="vo.sex" value="1">selected</eq> value="1">男</option>
        <option <eq name="vo.sex" value="2">selected</eq> value="2">女</option>
      </select>
    </span></p>
  <p><span style="font-size:14px;">联系电话</span>
    <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
      <input type="text" id="mobile" value="{$vo.mobile}" style="border:none; line-height:30px;"/></span></p></div>
  <div class="nei3">
    <p><span style="font-size:14px;">现居住地</span>
      <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
        <input type="text" id="address" style="border:none; line-height:30px;" value="{$vo.address}"/></span></p>
  <p><span style="font-size:14px;">工&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;种</span>
    <span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
      <volist name="vo['craft']" id="vl">
        {$vl.name}&nbsp;&nbsp;
      </volist>
      &nbsp;&nbsp;<a href="javascript:;" onClick="show()">修改</a>
    </span>
  <p id="show" style="line-height: 30px;display:none">
      <volist name="t_list" id="vl">
        <input class="gz" type="checkbox" style="border:none; line-height:30px;" value="{$vl.id}"/>{$vl.name}&nbsp;&nbsp;
      </volist>
    <!-- </span> --></p>
    </div>
      <div style="" class="cha_2"><img style="margin-top:100px;" onClick="sub()" src="{$_static_}/images/aniu.png"></div>
</div>

<script src="{$_static_}/layer/layer.js"></script>
<script type="text/javascript">
  
  function show(){
      if($("#show").is(":hidden")){
          $("#show").fadeIn();
      }else{
          $("#show").fadeOut();
      }
  }

  function sub(){
      var p={};
      p.nickname = $("#nickname").val();
      p.chusheng = $("#Wdate_b").val();
      p.sex = $("#sex option:selected").val();
      p.mobile = $("#mobile").val();
      p.address = $("#address").val();
      $(".gz:checked").each(function(key,v){
          if(key==0) p.craftid = $(v).val();
          else p.craftid += ","+ $(v).val();
      })

      var index = layer.load(2,{shade:false});
      $.ajax({
          url:"{$_root}member/my",
          type: 'post', 
          data:p,
          dataType: 'json', 
          timeout: 2000, 
          error: function(){
              layer.close(index);
              layer.msg("出错啦");
          },
          beforeSend:function(){
              
          },
          success:function(result){
            layer.close(index);
            if(result.status==1) {
                layer.msg("修改成功");
                window.location.href="{$_root}member";
            }
            else {
                layer.msg(result.message);
            }
          } 
        }); 
  }


</script>

</body>
</html>
