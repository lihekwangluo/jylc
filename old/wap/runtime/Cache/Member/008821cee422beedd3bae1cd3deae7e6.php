<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php if(($type) == "1"): ?>会员<?php else: ?>企业<?php endif; ?>认证 — 建遇良才</title>

<link href="<?php echo ($_static_); ?>/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/nei.css" rel="stylesheet" type="text/css">
<script src="<?php echo ($_static_); ?>/js/jquery-1.8.3.min.js"></script>
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

</style>
</head>

<body>
<form action="<?php echo ($_root); ?>member/index/renzheng" id="uploadForm" name="uploadForm" method="post" enctype="multipart/form-data">
<div style="width:100%; background-color:#FFF;" class="mobile">
	<div class="tou"><a href="javascript:history.back();"><img src="<?php echo ($_static_); ?>/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>  
     <h2>会员认证</h2>
     <?php if($vo["renzheng"] != 1): ?><a href="javascript:;" onclick="sub()" style="position: absolute;right: 0;top: 0;height: 50px;line-height: 50px;font-size: 20px; margin-right: 10px;color: #fff;">提交</a><?php endif; ?>
  </div>
  <div class="nei3">
    <p><span style="font-size:14px;">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</span><span style="  border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
      <input type="text" id="name" name="name" value="<?php echo ($vo["name"]); ?>" style="border:none; line-height:30px;"/></span></p>
  <p><span style="font-size:14px;">身份证件</span>
    <span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
    <input type="text" id="idcard" name="idcard" value="<?php echo ($vo["idcard"]); ?>" style="border:none; line-height:30px;"/></span></p></div>
  
  <?php if(($type) == "2"): ?><div class="nei21_1">
    <h6 style="border:none; font-size:18px;">营业执照<span style=" font-size:12px; color:#6d6d6d; font-weight:700; margin-left:10px; ">请上传公司的营业执照</span></h6>
    <p class="upload-img">
      <input type="file" id="zhizhao" name="zhizhao" class="comment-pic-upd" />
      <img class="add" src="<?php if(empty($vo[enterprisepic])): echo ($_static_); ?>/images/images/jia_03.png<?php else: echo ($vo["enterprisepic"]); endif; ?>" style="margin-top:0;"></p>
  </div><?php endif; ?>

  <div class="nei21_1" style="padding-bottom: 40px;">
    <h6 style="border:none; font-size:18px;">身份证<span style=" font-size:12px; color:#6d6d6d; font-weight:700; margin-left:10px; ">请上传你身份证的正反面</span></h6>
    <p class="upload-img">
      <input type="file" id="idcard_1" name="idcard_1" class="comment-pic-upd" />
      <img class="add" src="<?php if(empty($vo[cardzpic])): echo ($_static_); ?>/images/images/jia_03.png<?php else: echo ($vo["cardzpic"]); endif; ?>" style="margin-top:0;"></p>
    <p class="upload-img">
      <input type="file" id="idcard_2" name="idcard_2" class="comment-pic-upd" />
      <img class="add" src="<?php if(empty($vo[cardfpic])): echo ($_static_); ?>/images/images/jia_03.png<?php else: echo ($vo["cardfpic"]); endif; ?>" style="margin-top:0;"></p></div>
</div>
<input type="hidden" name="type" value="<?php echo ($type); ?>" />
</form>

<script type="text/javascript">

  if(typeof FileReader==='undefined'){ 
      layer.msg("抱歉，你的浏览器不支持 FileReader");
      input.setAttribute('disabled','disabled'); 
  }else{ 
      $("input[type=file]").on("change",function(e){
          var p = $(this);
          var file = $(this).get(0).files[0];
          if(!/image\/\w+/.test(file.type)){ 
              layer.msg("文件必须为图片！");
              return false; 
          } 

          var reader = new FileReader();
          reader.readAsDataURL(file); 
          reader.onload = function(e){ 
              var url = e.target.result;
              $(p).parent("p").find("img").hide();
              $(p).parent("p").append('<img width="100%" src="'+url+'" alt=""/>');
          } 
      })
  }

  function sub(){
      var type = <?php echo (($type)?($type):"0"); ?>;
      var name = $("#name").val();
      var idcard = $("#idcard").val();

      if(!name||!idcard) {
          layer.msg("请填写完整");
          return false;
      }

      if(type==1 && !$("#idcard_1").val() && !("#idcard_2").val()){
          layer.msg("请上传身份证正反面");
          return false;
      }

      if(type==2 && !$("#zhizhao").val()){
          layer.msg("请上传营业执照");
          return false;
      }
      
      var index = layer.load(2,{shade:false});
       $('#uploadForm').ajaxSubmit(function(data){
            layer.close(index);
            if(data==true){
                layer.msg("提交成功");  
            }else{
                layer.msg(data);
            }
        });
        return false;
  }
</script>

</body>
</html>