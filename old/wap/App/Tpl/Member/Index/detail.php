<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no">
<title>{$vo.title}</title>
<link href="{$_static_}/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/nei.css" rel="stylesheet" type="text/css">
<script src="{$_static_}/js/jquery-1.8.3.min.js"></script>
<script src="{$_static_}/layer/layer.js"></script>
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
.liping22{
  font-size:14px;
  line-height:37px;
  color:#FFF;
  width: 88px;
  text-align:center;
  height: 37px;
  border-radius: 3px;
  background-color: #16c5ca;
  position: absolute;
  z-index: 2;
  top: 98px;
  left: 125px;
}
.liping3{ 
    line-height: 30px;
    text-align: center;
    width: 122px;
    height: 170px;
    color: #fe7f0a;
    font-size: 24px;
    position: absolute;
    left: 0;
    z-index: 99;
}
.liping3 span{ margin-top:60px; padding-top:60px;}

.liping2 h3{  color:#5e5e5e; line-height:50px; margin-top:12px;}
.fanfa{ width:100%; height:115px; border-bottom:1px dashed #bbbbbb; background-color:#f9f7f8; border-top:1px dashed #bbbbbb;}
.dizhi{ width:80%; height:88px; line-height:88px;background-color:#FFF; margin:0 auto;}
.diqu{
  height: 25px;
  line-height: 25px;
  border: #CCC 1px solid;
  color: #666;
}
</style>
</head>

<body>
<div style="width:100%; height:1136px; background-color:#f9f7f8;" class="mobile">
  <div class="tou"><a href="javascript:history.back();"><img src="{$_static_}/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>   <h2>礼品兑换</h2>
  </div>
  <div  class="cha_29" style="height:950px; background-color:#f9f7f8;">
  <div class="lida" style="width:100%; background-color:#FFF;position: relative;">
  	<div class="liping">
    	<div class="liping1"><img style=" margin-top:20px;" src="{$vo.pic}"></div>
      <div class="liping2"> <h3 >{$vo.title}</h3><div class="liping21">还剩{$vo.snum}</div><div class="liping22">限量{$vo.num}</div></div>
        <div class="liping3"><div style=" height:170px; background:url({$_static_}/images/images/quan1_03.png) no-repeat center center;"><p style=" padding-top:60px;">消耗积分
    <p>{$vo.integral}</p></p></div></div>
    </div></div>
    <div class="fanfa"><p style=" font-size:18px; line-height:40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;兑换方法</p><p style=" font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;使用相应的积分进行兑换，并输入收货地址，收货人和电话，工作人员会以最快的方式吧礼品给你邮寄过去</p></div>
    <div style="width:100%; height:15px; margin-bottom:60px; background-color:#FFF;"></div>
     <p style=" color:#515151; margin-bottom:30px; font-size:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;收货地址</p>
     <div  class="dizhi" style=" margin-bottom:3px;"> <p style=" float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;姓名&nbsp;&nbsp;&nbsp;&nbsp;</p>
      <input id="username" style="margin-left:30px; float:left; width:200px; height:86px; border:none;" type="text"/></div>
     <div  class="dizhi"  style=" margin-bottom:3px;"> <p style=" float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;手机号</p>
      <input id="mobile" style=" margin-left:30px; float:left; width:200px; height:86px; border:none;" type="mobile"/></div>
    <div  class="dizhi"  style=" margin-bottom:3px;">

    <select id="sheng" class="diqu" onChange="get_city()" style="margin-top:30px; margin-left:10px;">
       <option value="0">--请选择--</option>
    </select>

    <select id="city" class="diqu" onChange="get_qu()" style="margin-top:30px; margin-left:10px;">
       <option value="0">--请选择--</option>
    </select>

     <select id="qu" class="diqu" style="margin-top:30px; margin-left:10px;">
       <option value="0">--请选择--</option>
    </select>

    </div>
     <div  class="dizhi"  style=" margin-bottom:3px;"> <p style=" float: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;详细地址 &nbsp;&nbsp;&nbsp;&nbsp;</p>
      <input id="address2" style=" margin-left:30px; float:left; width:200px; height:86px; border:none;" type="text"/></div>
  </div>
  <div onclick="sub()" style=" width:80%; background-color:#06c1b0; height:85px; border-radius:5px; margin:0 auto; text-align:center; line-height:85px; font-size:30px; color:#FFF;">立即兑换</div>

</div>

<script type="text/javascript">
get_sheng();

function get_sheng(){

    $.ajax({
        url:"{$_root}publish/regin",
        type:"get",
        dataType:"json",
        timeOut:2000,
        error:function(){
            alert("获取出错");
        },
        success:function(res){
            if(res.status==1){
                $("#sheng").append(res.info);
            }
        }
    })
}

function get_city(){
    $("#city option").not("#city option:eq(0)").remove();
    $("#qu option").not("#qu option:eq(0)").remove();
    var id = $("#sheng option:selected").val();
    if(!id){
        alert("请先选择上一级");
        return false;
    }

    $.ajax({
        url:"{$_root}publish/regin",
        type:"get",
        data:{id:id},
        dataType:"json",
        timeOut:2000,
        error:function(){
            alert("获取出错");
        },
        success:function(res){
            if(res.status==1){
                $("#city").append(res.info);
            }
        }
    })
}

function get_qu(){
    $("#qu option").not("#qu option:eq(0)").remove();
    var id = $("#city option:selected").val();
    if(!id){
        alert("请先选择上一级");
        return false;
    }

    $.ajax({
        url:"{$_root}publish/regin",
        type:"get",
        data:{id:id},
        dataType:"json",
        timeOut:2000,
        error:function(){
            alert("获取出错");
        },
        success:function(res){
            if(res.status==1){
                $("#qu").append(res.info);
            }
        }
    })
}

function sub(){
    var sheng = $("#sheng option:selected").val();
    var city = $("#city option:selected").val();
    var qu = $("#qu option:selected").val();
    var p = {};
    p.productid = {$vo.pid|default="0"};
    //p.num = 1;
    p.username = $("#username").val();
    p.mobile = $("#mobile").val();
    p.address2 = $("#address2").val();
    if(!p.productid||!p.username||!p.mobile||!sheng||!city||!qu||!address2){
        layer.msg("请先写收货信息再提交");
        return false;
    }
    p.address = sheng+city+qu;
    
    var index = layer.load(2,{shade:false});
    $.ajax({
        url:"{$_root}member/index/detail",
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
                layer.msg("兑换成功");
            }else{
                layer.msg(res.message);
            }
        }
    })
}

</script>

</body>
</html>
