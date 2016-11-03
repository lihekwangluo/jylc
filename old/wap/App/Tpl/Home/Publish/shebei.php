<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>发布设备</title>
<script type="text/javascript" src="{$_static_}/js/jquery-1.10.2.min.js"></script>
<link href="{$_static_}/css/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{$_static_}/css/style.css">
<link href="{$_static_}/css/public.css" rel="stylesheet" type="text/css" />
<link href="{$_static_}/css/index.css" rel="stylesheet" type="text/css" />
<style>
  .diqu{
    width: 25%;
    height: 25px;
    line-height: 25px;
    border: #CCC 1px solid;
    color: #666;
  }
</style>
</head>

<body>
<div  class="lobab_nav">
 <div class="header  daohang"> <div class="fanhui_img"><img onclick="window.history.go(-1)" src="{$_static_}/images/fh1.png" /></div>设备信息 </div>
   <form action="" method="get">
     <div class="fabu_w">
   <table   width="100%" border="0" cellspacing="0" cellpadding="0">
   
   <tr>
   <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>设备名称：</td>
        <td width="75%"><label for="dpname"></label>
          <select class="loybn" name="dianpu_name" id="dianpu_name">
           <option value="0" selected>- 选择设备 -</option>
           <volist name="d_list" id="vl">
             <option <eq name="vo[$key][cid]" vaule="vl[id]">selected</eq> value="{$vl.id}">{$vl.name}</option>
           </volist>
          </select>
          </td>
      </tr>
    </table></td>
   </tr>

       <tr>
           <td height="50">
               <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">


                   <tr>
                       <td width="25%" height="50" align="right"><span style="color:red">*</span>业主名称：</td>
                       <td width="75%">
                           <label for="yezhuming"></label>

                           <input type="text" class="loyab" name="sb_yzm" id="sb_yzm" value="{$vo.owner}" />
                       </td>
                   </tr>
               </table>
           </td>
       </tr>
 <tr>
 <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      
      
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>数&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;量：</td>
        <td width="75%"><label for="shenbei"></label>
          
          <input type="text" class="loyab" name="sb_sl" id="sb_sl" value="{$vo.num}" />
          </td>
      </tr>
    </table></td>
 </tr>
 
  <tr>
    <td height="50">
    <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>规格型号：</td>
        <td width="75%"><label for="fuw_fanw"></label>
          <input type="text" class="loyab" name="sb_xh" id="sb_xh" value="{$vo.model}" /> </td>
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
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
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
        <td width="25%" height="50" align="right"><span style="color:red">*</span>司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机：</td>
        <td width="75%"><p>
          <label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="driver" class="driver" <gt name="vo['driver']" value="0">checked</gt> value="1" />
            有</label>
          
          <label>
            <input type="radio" <eq name="vo['driver']" value="0">checked</eq> name="driver" class="driver" value="0" />
            无
          </label>
          <br />
        </p></td>
      </tr>
    </table></td>
  </tr>
 

  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>权&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;限：</td>
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
        <td width="25%" height="50" align="right">设备描述：</td>
        <td width="75%"><textarea name="yaoqiu" style="resize: none; border-radius:5px;" class="textb"  placeholder="请输入相关要求" id="yaoqiu" cols="45" rows="5">{$vo.content.0}</textarea></td>
      </tr>
    </table></td>
  </tr>
  
    
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25" height="50" align="right">&nbsp;</td>
        <td width="335"><input type="button"  class="fb_ok" onclick="sub()" id="ok" value="<gt name='vo[pid]' value='0'>修改<else/>发布</gt>">
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
    p.deviceid = $("#dianpu_name option:selected").val();
    p.model = $("#sb_xh").val();
    p.driver = $(".driver:checked").val();
    p.num = $("#sb_sl").val();
    p.owner = $("#sb_yzm").val();
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
    p.status = 1;

    if(!p.deviceid||!p.num||!p.model||!p.power||!p.moblie||!p.username||!p.owner){
        layer.msg("请填写完整再提交");
        return false;
    }

    var index = layer.load(2,{shade:false});
    $.ajax({
        url:"{$_root}publish/shebei",
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
                layer.msg("提交成功");
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