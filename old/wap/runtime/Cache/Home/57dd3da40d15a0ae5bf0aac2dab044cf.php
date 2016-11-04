<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>发布设备</title>
<script type="text/javascript" src="<?php echo ($_static_); ?>/js/jquery-1.10.2.min.js"></script>
<link href="<?php echo ($_static_); ?>/css/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo ($_static_); ?>/css/style.css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/index.css" rel="stylesheet" type="text/css" />
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
 <div class="header  daohang"> <div class="fanhui_img"><img onclick="window.history.go(-1)" src="<?php echo ($_static_); ?>/images/fh1.png" /></div>设备信息 </div>
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
           <?php if(is_array($d_list)): $i = 0; $__LIST__ = $d_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><option <?php if(($vo[$key][cid]) == ""): ?>selected<?php endif; ?> value="<?php echo ($vl["id"]); ?>"><?php echo ($vl["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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

                           <input type="text" class="loyab" name="sb_yzm" id="sb_yzm" value="<?php echo ($vo["owner"]); ?>" />
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
          
          <input type="text" class="loyab" name="sb_sl" id="sb_sl" value="<?php echo ($vo["num"]); ?>" />
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
          <input type="text" class="loyab" name="sb_xh" id="sb_xh" value="<?php echo ($vo["model"]); ?>" /> </td>
      </tr>
    </table></td>
  </tr>
   <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>地　　区：</td>
        <td width="75%" align="center">
          <?php if(($vo["pid"]) > "0"): ?><input type="text" class="loyab" readonly onclick="show('diqu')" value="<?php echo ($vo["area"]["0"]["area_name"]); echo ($vo["area"]["1"]["area_name"]); echo ($vo["area"]["2"]["area_name"]); ?>" />
          <?php else: ?>
          <a href="javascript:;" onclick="show('diqu')">添加</a><?php endif; ?>
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
        <td width="75%"><input type="text" class="loyab" name="gz_dz" id="gz_dz" value="<?php echo ($vo["address"]); ?>" /> 
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="driver" class="driver" <?php if(($vo['driver']) > "0"): ?>checked<?php endif; ?> value="1" />
            有</label>
          
          <label>
            <input type="radio" <?php if(($vo['driver']) == "0"): ?>checked<?php endif; ?> name="driver" class="driver" value="0" />
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
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="RadioGroup1" class="power" <?php if(($vo['power']) == "2"): ?>checked<?php endif; ?> value="2" id="RadioGroup1_0" />
            全部用户可见</label>
          
          <label>
            <input type="radio" name="RadioGroup1" class="power" <?php if(($vo['power']) == "1"): ?>checked<?php endif; ?> value="1" id="RadioGroup1_1" />
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
        <td width="75%"><input type="text" class="loyab" name="gz_name" id="gz_name" value="<?php echo ($vo["username"]); ?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联系电话：</td>
        <td width="75%"><input type="text" class="loyab" name="gz_dh" id="gz_dh" value="<?php echo ($vo["moblie"]); ?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right">设备描述：</td>
        <td width="75%"><textarea name="yaoqiu" style="resize: none; border-radius:5px;" class="textb"  placeholder="请输入相关要求" id="yaoqiu" cols="45" rows="5"><?php echo ($vo["content"]["0"]); ?></textarea></td>
      </tr>
    </table></td>
  </tr>
  
    
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25" height="50" align="right">&nbsp;</td>
        <td width="335"><input type="button"  class="fb_ok" onclick="sub()" id="ok" value="<?php if(($vo[pid]) > "0"): ?>修改<?php else: ?>发布<?php endif; ?>">
</td>
      </tr>
    </table></td>
  </tr>
   </table>
</div></form>

</div>

<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<script type="text/javascript">

get_sheng();

function show(id){
    if($("#"+id).is(":hidden")) $("#"+id).fadeIn();
    else $("#"+id).fadeOut();
}
function get_sheng(){

    $.ajax({
        url:"<?php echo ($_root); ?>publish/regin",
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
        url:"<?php echo ($_root); ?>publish/regin",
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
        url:"<?php echo ($_root); ?>publish/regin",
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
    var id = <?php echo (($vo["pid"])?($vo["pid"]):"0"); ?>;
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
    if(!p.area1) p.area1 = <?php echo (($vo["area"]["0"]["area_id"])?($vo["area"]["0"]["area_id"]):"0"); ?>;
    if(!p.area2) p.area2 = <?php echo (($vo["area"]["1"]["area_id"])?($vo["area"]["1"]["area_id"]):"0"); ?>;
    if(!p.area3) p.area3 = <?php echo (($vo["area"]["2"]["area_id"])?($vo["area"]["2"]["area_id"]):"0"); ?>;
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
        url:"<?php echo ($_root); ?>publish/shebei",
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
                window.location.href = "<?php echo ($_root); ?>";
            }else {
              layer.msg(res.message);
            }
        }
    })

}

</script>
</body>
</html>