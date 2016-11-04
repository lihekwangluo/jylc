<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>发布队找活</title>
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
<div class="header  daohang"> <div class="fanhui_img"><img onclick="window.history.go(-1);" src="<?php echo ($_static_); ?>/images/fh1.png" /></div>队找活发布 </div>
   <form action="" method="get">
     <div class="fabu_w">
   <table   width="100%" border="0" cellspacing="0" cellpadding="0">
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

 <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>队伍人数：</td>
        <td width="75%"><label for="textfield"></label>
          <input type="text" class="loyab" name="duiw_rs" id="duiw_rs" value="<?php echo ($vo["num"]); ?>" /><span class="loyb_hz">人</span>
          </td>
      </tr>
    </table>
 
 </td ></tr>
  <tr>
    <td height="50">
    <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>需要工种：</td>
        <td width="75%">
          <label for="gongz"></label>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php if(is_array($vo["craft"])): $i = 0; $__LIST__ = $vo["craft"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><input type="hidden" id="gzz" value="<?php if(($key) == "0"): echo ($vl["cid"]); else: ?>,<?php echo ($vl["cid"]); endif; ?>" />
            <?php echo ($vl["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
          
          &nbsp;&nbsp;<a href="javascript:;" onClick="show('gz')"><?php if(($vo[pid]) > "0"): ?>修改<?php else: ?>添加<?php endif; ?></a>

          </td>
      </tr>
    </table></td>
  </tr>

  <tr id="gz" style="display:none">
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%" cols='2' height="50">
          <?php if(is_array($t_list)): $i = 0; $__LIST__ = $t_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><input class="gz" type="checkbox" style="border:none; line-height:30px;" value="<?php echo ($vl["id"]); ?>"/><?php echo ($vl["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
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
        <td width="75%"><input type="text" class="loyab" name="gz_name" value="<?php echo ($vo["username"]); ?>" id="gz_name" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联系电话：</td>
        <td width="75%"><input type="text" class="loyab" name="gz_dh" value="<?php echo ($vo["moblie"]); ?>" id="gz_dh" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right">详情要求：</td>
        <td width="75%"><textarea name="yaoqiu" style="resize: none; border-radius:5px;" class="textb"  placeholder="请输入相关要求" id="yaoqiu" cols="45" rows="5"><?php echo ($vo["content"]["0"]); ?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
  </tr>
  <tr>
    
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="165" height="50" align="right">&nbsp;</td>
        <td width="335"><input type="button"  class="fb_ok" onclick="sub()" id="ok" value="<?php if(($vo[pid]) > "0"): ?>修改<?php else: ?>发布<?php endif; ?>" /></td>
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

    $(".gz:checked").each(function(key,v){
        if(key==0) p.craftid = $(v).val();
        else p.craftid += ","+ $(v).val();
    })

    if(!p.craftid) p.craftid = $("#gzz").val();
    //p.craftid = $("#gongz option:selected").val();
    p.num = $("#duiw_rs").val();
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
    p.status = 3;

    if(!p.craftid||!p.num||!p.power||!p.moblie||!p.username){
        layer.msg("请填写完整再提交");
        return false;
    }

    var index = layer.load(2,{shade:false});
    $.ajax({
        url:"<?php echo ($_root); ?>publish/duizhaohuo",
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