<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>发布对找人</title>
<script type="text/javascript" src="{$_static_}/js/jquery-1.10.2.min.js"></script>
<link href="{$_static_}/css/owl.carousel.css" rel="stylesheet">
<link href="{$_static_}/css/style.css" rel="stylesheet" type="text/css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/index.css" rel="stylesheet" type="text/css" />
<style>
  .diqu{
    width: 30%;
    height: 25px;
    line-height: 25px;
    border: #CCC 1px solid;
    color: #666;
  }
</style>
</head>

<body>
<div  class="lobab_nav">
<div class="header  daohang"> <div class="fanhui_img"><img onclick="window.history.go(-1);" src="{$_static_}/images/fh1.png" /></div>队找人发布 </div>
   <form action="" method="get">
     <div class="fabu_w">
   <table   width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50">
    <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>需要工种：</td>
        <td width="75%"><label for="gongz"></label>
          <select class="loybn" name="gongz" id="gongz">
           <option value="0">- 选择工种 -</option>
           <volist name="t_list" id="vl">
             <option value="{$vl.id}" <if condition="$vo['craft']['0']['cid'] eq $vl['id']">selected</if>>{$vl.name}</option>

           </volist>
          </select></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>人　　数：</td>
        <td width="75%"><label for="textfield"></label>
          <input type="text" class="loyab" name="gz_rs" id="gz_rs" value="{$vo.num}" /><span class="loyb_hz">人</span> 
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>年　　龄：</td>
        <td width="75%"><label for="gongznl"></label>
            <input type="number" id="age1" class="loyab" style="width:15%;" value="{$vo.age1}" /> <span style="float:left;margin-top: 10px;">一</span> <input type="number" class="loyab" id="age2" style="width:15%;" value="{$vo.age2}" />岁
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>工资待遇：</td>
        <td width="75%"><label for="gongzdy"></label>
          <input type="number" id="price" class="loyab" style="width:15%;" value="{$vo.price}" /> <span style="float:left;margin-top: 10px;">一</span> <input type="number" class="loyab" id="price2" style="width:15%;" value="{$vo.price2}" />元
          </td>
      </tr>
    </table></td>
  </tr>

 <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>地　　区：</td>
        <td width="75%" align="center">
          <gt name="vo.pid" value="0">
          <input type="text" class="loyab" readonly onclick="show('diqu')" value="{$vo.area.0.area_name}{$vo.area.1.area_name}{$vo.area.2.area_name}" />
          <else/>
          <a href="javascript:;" onclick="show('diqu')">添加</a>
          </gt>
          </td>
      </tr>
    </table></td>
  </tr>

  <tr id="diqu" style="display:none">
    <td height="50"><table class="biaog" width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" cols='2' height="50">
          <select id="sheng" class="diqu" onChange="get_city()">
            <option>- 选择地区 -</option>
          </select>

          <select id="city" class="diqu" onChange="get_qu()">
            <option>- 选择地区 -</option>
          </select>
          
          <select id="qu" class="diqu">
            <option>- 选择地区 -</option>
          </select>

        </td>
      </tr>
    </table></td>
  </tr>

  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>详细地址：</td>
        <td width="75%"><input type="text" class="loyab" name="gz_dz" id="gz_dz" value="{$vo.address}" /> 
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>权　　限：</td>
        <td width="75%"><p>
          <label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="RadioGroup1" class="power" <eq name="vo['power']" value="2">checked</eq> value="2" id="RadioGroup1_0" />
            全部用户可见</label>
          
          <label>
            <input type="radio" name="RadioGroup1" class="power" <eq name="vo['power']" value="1">checked</eq> value="1" id="RadioGroup1_1" />
            认证用户可见
          </label>
          <br />
        </p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联&nbsp; 系&nbsp; 人：</td>
        <td width="75%"><input type="text" class="loyab" name="gz_name" id="gz_name" value="{$vo.username}" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联系电话：</td>
        <td width="75%"><input type="text" class="loyab" name="gz_dh" id="gz_dh" value="{$vo.moblie}" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right">招聘要求：</td>
        <td width="75%"><textarea name="yaoqiu" class="textb" id="yaoqiu" cols="45" rows="5">{$vo.content.0}</textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" height="50" align="center" cols="2"><input type="button"  class="fb_ok" id="ok" onclick="sub()" value="确定"> 
</td>
      </tr>
    </table></td>
  </tr>
   </table>
</div></form>

</div>

<script src="{$_static_}/layer/layer.js"></script>
<script type="text/javascript">

get_sheng();

function show(id){
    if($("#"+id).is(":hidden")) $("#"+id).fadeIn();
    else $("#"+id).fadeOut();
}

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
    var p = {};
    var id = {$vo.pid|default="0"};
    if(id) p.pid = id;
    p.craftid = $("#gongz option:selected").val();
    p.num = $("#gz_rs").val();
    p.age1 = $("#age1").val();
    p.age2 = $("#age2").val();
    price = $("#price").val();
    price2 = $("#price2").val();
    p.area1 = $("#sheng option:selected").val();
    p.area2 = $("#city option:selected").val();
    p.area3 = $("#qu option:selected").val();
    if(p.area1 == '- 选择地区 -'||p.area2 == '- 选择地区 -'||p.area3 == '- 选择地区 -'){
        layer.msg("请选择地区");
        return false;
    }
    if(!p.area1) p.area1 = {$vo.area.0.area_id|default="0"};
    if(!p.area2) p.area2 = {$vo.area.1.area_id|default="0"};
    if(!p.area3) p.area3 = {$vo.area.2.area_id|default="0"};
    p.address = $("#gz_dz").val();
    p.power = $(".power:checked").val();
    p.username = $("#gz_name").val();
    p.moblie = $("#gz_dh").val();
    p.content = $("#yaoqiu").val();
    p.status = 4;
   
    if(!p.craftid||!p.num||!p.age1||!p.age2||!price||!price2||!p.power||!p.moblie||!p.username){
        layer.msg("请填写完整再提交");
        return false;
    }

    p.price = price+"-"+price2;
    //console.log(p);return false;
    var index = layer.load(2,{shade:false});
    $.ajax({
        url:"{$_root}publish/duizhaoren",
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
                layer.msg("处理成功");
                window.location.href = "{$_root}";
            }else {
              layer.msg(res.message);
            }
        }
    })

}

</script>

</body>
</html>
