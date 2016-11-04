<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no">
<title>积分商城</title>
<link href="<?php echo ($_static_); ?>/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/nei.css" rel="stylesheet" type="text/css">
<style type="text/css">
  .duihuan{
    padding: 20px;
  }
  .duihuan1{
    width: 46%;
    float:left;
    padding:0 2%;
    margin-bottom:20px;
  }
</style>
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
  <div class="tou"><a href="javascript:history.back();">
    <img src="<?php echo ($_static_); ?>/images/zuo.png" style="margin-top:10px; cursor:pointer; float:left;"></a>   
    <h2>积分商城</h2><div class="head_right"><a href="<?php echo ($_root); ?>member/index/record" style="color:#FFFFFF; font-size:14px;">记录</a></div>
  </div>
  <div  class="cha_29" style="height:800px; background-color:#FFF;">
  	<div class="duihuan">
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><div class="duihuan1">
          <a href="<?php echo ($_root); ?>member/index/detail/productid/<?php echo ($vl["pid"]); ?>.html"><img src="<?php echo ($vl["pic"]); ?>" height="150"></a>
          <p style="font-size:24px; line-height:60px; color:#373737;"><a href="<?php echo ($_root); ?>member/index/detail/productid/<?php echo ($vl["pid"]); ?>.html"><?php echo ($vl["title"]); ?></a></p>
          <span style=" float:left; color:#0C3; "><?php echo ($vl["integral"]); ?>积分</span>
          <span style=" float:left; color:#0C3; margin-left:50px;">库存<?php echo ($vl["snum"]); ?></span>
        </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
  </div>

</div>

</body>
</html>