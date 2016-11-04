<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>发布辅材</title>
<script type="text/javascript" src="<?php echo ($_static_); ?>/js/jquery-1.10.2.min.js"></script>
<link href="<?php echo ($_static_); ?>/css/owl.carousel.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo ($_static_); ?>/css/style.css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/index.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ($_static_); ?>/js/jquery.form.js"></script>
<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<style type="text/css">

.upload-img{
  width:70%;
  text-align:center; 
  margin:20px auto;
  padding:40px 0;
  border-radius:10px; border:1px solid #ebebeb;
  position: relative;
  overflow: hidden;
}
.comment-pic-upd{
  position: absolute;
  top: 0;
  left: 0;
  z-index: 100;
  width: 100%;
  height: 100%;
  filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);
  filter:alpha(opacity=0);
  -moz-opacity:0;
  -khtml-opacity: 0;
  opacity:0;
  background: none;
  border: none;
  cursor: pointer;
}
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
 <div class="header  daohang"> <div class="fanhui_img"><img onclick="window.history.go(-1)" src="<?php echo ($_static_); ?>/images/fh1.png" /></div>辅材发布 </div>
  <form action="<?php echo ($_root); ?>publish/fucai" id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data">
    <input type="hidden" name="status" value="5">
    <input type="hidden" name="pid" value="<?php echo ($vo["pid"]); ?>">
    <input type="hidden" name="area1" id="area1" value="<?php echo ($vo["area"]["0"]["area_id"]); ?>" >
    <input type="hidden" name="area2" id="area2" value="<?php echo ($vo["area"]["1"]["area_id"]); ?>" >
    <input type="hidden" name="area3" id="area3" value="<?php echo ($vo["area"]["2"]["area_id"]); ?>" >

  <div class="fabu_w">
   <table   width="100%" border="0" cellspacing="0" cellpadding="0"> 
    <tr>
      <td height="50">
        <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%" height="50" align="right"><span style="color:red">*</span>店铺名称：</td>
            <td width="75%"><label for="shopname"></label>
              <input type="text" class="loyab" name="shopname" id="shopname" value="<?php echo ($vo["shopname"]); ?>" /></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td height="50">
      <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25%" height="50" align="right"><span style="color:red">*</span>地　　区：</td>
          <td width="75%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if(($vo["pid"]) > "0"): ?><input type="text" class="loyab" readonly onclick="show('diqu')" value="<?php echo ($vo["area"]["0"]["area_name"]); echo ($vo["area"]["1"]["area_name"]); echo ($vo["area"]["2"]["area_name"]); ?>" />
            <?php else: ?>
            <a href="javascript:;" onclick="show('diqu')">添加</a><?php endif; ?>
          </td>
        </tr>
      </table>
      </td>
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
    <td height="50">
    <table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>服务范围：</td>
        <td width="75%"><label for="fuw_fanw"></label>
           <select  class="loybn" name="alcorid" id="fuw_fanw">
            <option value="0">- 选择 -</option>
            <?php if(is_array($a_list)): $i = 0; $__LIST__ = $a_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><option <?php if($vo['alcor'][0][cid] == $vl['id']): ?>selected<?php endif; ?> value="<?php echo ($vl["id"]); ?>"><?php echo ($vl["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>详细地址：</td>
        <td width="75%"><input type="text" class="loyab" name="address" id="gz_dz" value="<?php echo ($vo["address"]); ?>"/> 
          </td>
      </tr>
    </table></td>
  </tr>
  
 

  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>权&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;限：</td>
        <td width="75%"><p>
          <label>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="power" class="power" <?php if(($vo['power']) == "2"): ?>checked<?php endif; ?> value="2" id="RadioGroup1_0" />
            全部用户可见</label>
          <label>
            <input type="radio" name="power" class="power" <?php if(($vo['power']) == "1"): ?>checked<?php endif; ?> value="1" id="RadioGroup1_1" />
            认证用户可见
          </label>
          <br />
        </p></td>
      </tr>
    </table></td>
  </tr>
  <tr><td><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>身 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 份：</td>
        <td width="75%"><p>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <label>
            <input type="radio" name="ptype" <?php if(($vo[ptype]) == "1"): ?>checked<?php endif; ?> value="1" id="shenfen_0" />
            厂家</label>
             
          <label>
            <input type="radio" name="ptype" <?php if(($vo[ptype]) == "2"): ?>checked<?php endif; ?> value="2" id="shenfen_1" />
            商家</label>
        
        </p></td>
      </tr>
    </table></td></tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联&nbsp; 系&nbsp; 人：</td>
        <td width="75%"><input type="text" class="loyab" name="username" id="gz_name" value="<?php echo ($vo["username"]); ?>"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right"><span style="color:red">*</span>联系电话：</td>
        <td width="75%"><input type="text" class="loyab" name="moblie" id="gz_dh" value="<?php echo ($vo["moblie"]); ?>"/></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="25%" height="50" align="right">详情：</td>
        <td width="75%"><textarea name="content" style="resize: none; border-radius:5px;" class="textb"  placeholder="请输入相关要求" id="yaoqiu" cols="45" rows="5"><?php echo ($vo["content"]["0"]); ?></textarea></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td height="200"><table style="border-bottom:#999 1px dashed;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="50"></td>
    </tr>
    <tr>
      <td><p>图片详情</p>
        <?php if(is_array($vo['pic'])): if(is_array($vo[pic])): $i = 0; $__LIST__ = $vo[pic];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><p class="upload-img">
          <input type="file" name="pic[$key]" class="comment-pic-upd" />
          <img class="add" src="<?php echo ($vl); ?>" style="margin-top:0;"></p><?php endforeach; endif; else: echo "" ;endif; ?>
        <?php else: ?>
          <p class="upload-img">
          <input type="file" name="pic0" class="comment-pic-upd" />
          <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p>
          <p class="upload-img">
          <input type="file" name="pic1" class="comment-pic-upd" />
          <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p>
          <p class="upload-img">
          <input type="file" name="pic2" class="comment-pic-upd" />
          <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p>
          <p class="upload-img">
          <input type="file" name="pic3" class="comment-pic-upd" />
          <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p><?php endif; ?>
        </td>
    </tr>
  </table></td>
  </tr>
  <!-- 上传营业执照 -->
  <!-- <tr> 
  <td height="200"><table style="border-bottom:#999 1px dashed;" width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="50"></td>
    </tr>
    <tr>
      <td height="150"><p>上传营业执照</p>
        <p class="upload-img">
          <input type="file" id="terracepic1" name="terracepic1" class="comment-pic-upd" />
          <img class="add" src="<?php if(is_array($vo[terracepic])): echo ($vo["terracepic"]["0"]); else: echo ($_static_); ?>/images/images/jia_03.png<?php endif; ?>" style="margin-top:0;"></p></td>
    </tr>
  </table></td>
  </tr> -->
  <!-- 上传身份证正面 -->
  <!-- <tr class="ptype2" style="<?php if(($vo[ptype]) == "2"): ?>display:block<?php else: ?>display:none<?php endif; ?>">
    <td height="200">
    <table style="border-bottom:#999 1px dashed;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr><td height="50"></td></tr>
      <tr>
        <td height="150"><p>上传身份证正面</p>
          <p class="upload-img">
            <input type="file" id="terracepic2" <?php if(($vo[ptype]) == "1"): ?>disabled<?php endif; ?> name="terracepic2" class="comment-pic-upd" />
            <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p>
      </td>
      </tr>
    </table>
    </td>
  </tr>   -->
  <!-- 上传身份证反面 -->
  <!-- <tr class="ptype2" style="<?php if(($vo[ptype]) == "2"): ?>display:block<?php else: ?>display:none<?php endif; ?>">
    <td height="200"><table  style="border-bottom:#999 1px dashed;" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="50"></td>
      </tr>
      <tr>
        <td height="150"><p>上传身份证反面</p>
          <p class="upload-img">
            <input type="file" id="terracepic3" <?php if(($vo[ptype]) == "1"): ?>disabled<?php endif; ?> name="terracepic3" class="comment-pic-upd" />
            <img class="add" src="<?php echo ($_static_); ?>/images/images/jia_03.png" style="margin-top:0;"></p></td>
      </tr>
    </table>
    </td>
  </tr> -->
  <tr>
    <td height="50"><table class="biaog" width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="35" height="50" align="right">&nbsp;</td>
        <td width="335"><input type="button" onclick="sub()" class="fb_ok" id="ok" value="<?php if(($vo[pid]) > "0"): ?>修改<?php else: ?>提交<?php endif; ?>"> 
</td>
      </tr>
    </table></td>
  </tr>
   </table>
</div>

</form>

</div>

<script type="text/javascript">

get_sheng();

$("input[name=ptype]").click(function(){
    var v = $(this).val();
    if(v==2){
        $(".ptype"+v).show();
        $(".ptype"+v).children('input').attr("disabled",true);
    }else{
        $(".ptype"+v).hide();
        $(".ptype"+v).children('input').attr("disabled",false);
    }
})

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

if(typeof FileReader==='undefined'){ 
      layer.msg("抱歉，你的浏览器不支持 FileReader");
      input.setAttribute('disabled','disabled'); 
  }else{ 
      $("input[type=file]").on("change",function(e){
          var p = $(this);
         
          var files = $(this).get(0).files;
           console.log(p,files);
          for(var i=0;i<files.length;i++){
              (function(file) {
                  if(!/image\/\w+/.test(files[i].type)){ 
                      layer.msg("文件必须为图片！");
                      delete files[i];
                      return false; 
                  } 
                  var reader = new FileReader();
                  reader.readAsDataURL(files[i]); 
                  reader.onload = function(e){ 
                      var url = e.target.result;
                      $(p).parent("p").find("img.add").hide();
                      $(p).parent("p").append('<img width="100%" src="'+url+'" alt=""/>');
                  } 
              })(files[i]);
          }
      })
  }

function sub() {
    area1 = $("#sheng option:selected").val();
    area2 = $("#city option:selected").val();
    area3 = $("#qu option:selected").val();
    if (area1 == '- 选择地区 -' || area2 == '- 选择地区 -' || area3 == '- 选择地区 -') {
        layer.msg("请选择地区");
        return false;
    }
    if(area1) $("#area1").val(area1);
    if(area2) $("#area2").val(area2);
    if(area3) $("#area3").val(area3);
    power = $(".power:checked").val();
    username = $("#gz_name").val();
    moblie = $("#gz_dh").val();

    if(!power||!moblie||!username){
        layer.msg("请填写完整再提交");
        return false;
    }

    var index = layer.load(2,{shade:false});

    $('#uploadForm').ajaxSubmit(function(data){
        layer.close(index);
        if(data==true){
            layer.msg("提交成功"); 
            window.location.href = "<?php echo ($_root); ?>"; 
        }else{
            layer.msg(data);
        }
    });

    return false;
    // $.ajax({
    //     url:"<?php echo ($_root); ?>publish/fucai",
    //     type:"post",
    //     data:queryString,
    //     dataType:"json",
    //     timeOut:2000,
    //     error:function(){
    //         layer.close(index);
    //         layer.msg("出错啦");
    //     },
    //     beforeSend:function(){

    //     },
    //     success:function(res){
    //       layer.close(index);
    //         if(res.status==1){
    //             layer.msg("处理成功");
    //             window.location.href = "<?php echo ($_root); ?>";
    //         }else {
    //           layer.msg(res.message);
    //         }
    //     }
    // })
}

</script>

</body>
</html>