<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php echo ($vo["title"]); ?>详情</title>
<script type="text/javascript" src="<?php echo ($_static_); ?>/js/jquery-1.10.2.min.js"></script>
<link href="<?php echo ($_static_); ?>/css/tcstyle.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css">
<link href="<?php echo ($_static_); ?>/css/nei.css" rel="stylesheet" type="text/css">
<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<style type="text/css">
.renz_bs { color:#FFF; font-size:12px; float:right; margin-bottom:10px; background:#C03; text-align:center; width:80px; height:25px; border-radius:3px; line-height:25px;}
.renz_bs1 { color:#FFF; font-size:12px; float:right; background:#06F; text-align:center; width:80px; height:25px; border-radius:3px; line-height:25px; margin-bottom:10px; }
</style>
</head>

<body>
<div style="width:100%; background-color:#ececec;" class="mobile">
	<div class="tou">
		<img src="<?php echo ($_static_); ?>/images/zuo.png" onclick="window.history.go(-1);" style="margin-top:6px; cursor:pointer; float:left;">  
		<a href="javascript:;" onclick="collect()"><img style="cursor:pointer; float: right;margin-top:6px;" src="<?php echo ($_static_); ?>/images/images/fden_05.png"></a>
    <!-- <img  style=" float: right; cursor:pointer;margin-top:10px; margin-right:10px;" src="<?php echo ($_static_); ?>/images/images/fden_03.png">  -->
    <h2>
    	<?php if($vo["status"] == 1): ?>设备出租
    	<?php elseif($vo["status"] == 2): ?>活找队
    	<?php elseif($vo["status"] == 3): ?>队找活
    	<?php elseif($vo["status"] == 4): ?>队找人
    	<?php elseif($vo["status"] == 5): ?>辅材购买<?php endif; ?>
    </h2>
  </div>
  <div class="biao" style="overflow:auto;">
  	<div  class="zuo"><h4><?php echo ($vo["title"]); ?></h4><p style="float:left;">发布时间：<?php echo ($vo["addtime"]); ?></p>
  	</div>
    <div  class="you">
    	<?php if(($vo["type"] == 1) and ($vl["renzheng"] == 1)): ?><div class="renz_bs1">个人认证</div>
	    <?php elseif($vl["rterrace"] == 1): ?>
	        <div class="renz_bs1">企业认证</div>
	    <?php else: ?>
	        <div class="renz_bs">未认证</div><?php endif; ?>
    	<p></p>
    	<a href="javascript:void(0);"><a href="<?php echo ($_root); ?>publish/jubao/pid/<?php echo ($vo["pid"]); ?>/title/<?php echo ($vo["title"]); ?>.html"><img src="<?php echo ($_static_); ?>/images/images/tu_07.png" style="margin-top:5px;"></a></div>
  </div>

  <?php if(in_array($vo['status'],array(1,5))): $pic = $vo['pic']; ?>
  <!-- <div class="wai">
	  <div class="da">
		       <ul class="dian">
		       	<?php if(is_array($pic)): $i = 0; $__LIST__ = $pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><li class="<?php if($key == 0): ?>on<?php endif; ?>"></li><?php endforeach; endif; else: echo "" ;endif; ?>
		       </ul>
		      <div class="nei">
		      <ul>
		      	<?php if(is_array($pic)): $i = 0; $__LIST__ = $pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><li><img src="<?php echo ($vl); ?>" width="300"/></li><?php endforeach; endif; else: echo "" ;endif; ?>
		      </ul>
		      </div>
	    </div>
  </div> -->
  <script>
	$(function(){
		var t=0
		var p
		var count = <?php echo count($pic)?count($pic):0; ?>;
		if(count>1){
			$(".dian li").click(function(){
			d=$(".dian li").index(this)
			for(var i=0;i<count;i++){
				$(".dian li").eq(i).removeClass("on")
				}
				$(".dian li").eq(d).addClass("on")
				$(".nei").animate({left:0-d*300},500)
			})
			window.onload=function aa(){
			t++
			for(var i=0;i<count;i++){
					$(".dian li").eq(i).removeClass("on")
					}
					var num = count-1;
				if(t>num){
					t=0
					}
					$(".dian li").eq(t).addClass("on")
					$(".nei").animate({left:0-t*300},500)
					p=window.setTimeout(function(){  aa() },2000)
			}
		}
		
	})
	</script><?php endif; ?>

  <div class="nei1">
  <!-- 第一行 -->
  	<p style="border-top:5px solid #e5e5e5;padding-left: 0px;">
  		<?php if($vo["status"] == 1): ?><span style="font-size:14px;">数&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;量</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["num"]); ?>台</span>
  		<?php elseif($vo["status"] == 2): ?>
  			<span style="font-size:14px;">项目类型</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["mold"]["0"]["name"]); ?></span>
  		<?php elseif($vo["status"] == 3): ?>
  			<span style="font-size:14px;">现有工种</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["craft"]); ?></span>
  		<?php elseif($vo["status"] == 4): ?>
  			<span style="font-size:14px;">需要工种</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["craft"]); ?></span>
  		<?php elseif($vo["status"] == 5): ?>
  			<span style="font-size:14px;">经营范围</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["alcor"]["0"]["name"]); ?></span><?php endif; ?>
    </p>
    
    <!-- 第二行 -->
  	<p>
  		<?php if($vo["status"] == 1): ?><span style="font-size:14px;">规格型号</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["model"]); ?></span>
  		<?php elseif($vo["status"] == 2): ?>
        <span style="font-size:14px;">工程总价</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["price"]); ?></span>
  		<?php elseif($vo["status"] == 3): ?>
  			<span style="font-size:14px;">队伍人数</span>
			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["num"]); ?>人</span>
  		<?php elseif($vo["status"] == 4): ?>
  			<span style="font-size:14px;">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["age1"]); ?>-<?php echo ($vo["age2"]); ?></span>
  		<?php elseif($vo["status"] == 5): ?>
  			<span style="font-size:14px;">详细地址</span>
  			<span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["area"]["0"]["area_name"]); echo ($vo["area"]["1"]["area_name"]); echo ($vo["area"]["2"]["area_name"]); echo ($vo["address"]); ?></span><?php endif; ?>
  	</p>
    
    <!-- 第三行 -->
    <p>
      <?php if($vo["status"] == 1): ?><span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["area"]["0"]["area_name"]); echo ($vo["area"]["1"]["area_name"]); echo ($vo["area"]["2"]["area_name"]); echo ($vo["address"]); ?></span>
      <?php elseif($vo["status"] == 4): ?>
        <span style="font-size:14px;">需要人数</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["num"]); ?></span><?php endif; ?>
    </p>
  </div>
  <div class="nei2">
    <!-- <h6>
    	<?php if($vo["status"] == 1): ?>文字描述
    	<?php elseif($vo["status"] == 2): ?>项目描述
    	<?php elseif($vo["status"] == 3): ?>队伍描述
    	<?php elseif($vo["status"] == 4): ?>招工要求
    	<?php elseif($vo["status"] == 5): ?>店铺描述<?php endif; ?>
    </h6> -->
    <!-- <p><?php echo ($vo['content'][0]); ?></p> -->
    <p>
      <?php if($vo["status"] == 1): ?><span style="font-size:14px;">设备描述</span>
        <p><span style="padding-left:16px;margin-left:16px;"><?php echo ($vo['content'][0]); ?></span></p>
      <?php elseif($vo["status"] == 2): ?>
        <span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["area"]["0"]["area_name"]); echo ($vo["area"]["1"]["area_name"]); echo ($vo["area"]["2"]["area_name"]); echo ($vo["address"]); ?></span>
      <?php elseif($vo["status"] == 3): ?>
        <span style="font-size:18px;">队伍描述</span>
        <p >
        <span style="margin-left:16px;"><?php echo ($vo['content'][0]); ?></span></p>
      <?php elseif($vo["status"] == 4): ?>
        <span style="font-size:14px;">工资待遇</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;">
        <?php if($vo["price"] == 0 and $vo["price2"] == 0): ?>面议 <?php else: ?> <?php echo ($vo["price"]); ?>-<?php echo ($vo["price2"]); endif; ?>      
        </span>
      <?php elseif($vo["status"] == 5): ?>
        <span style="font-size:18px;">店铺描述</span>
        <span style="padding-left:16px;margin-left:16px;">
        <?php echo (mb_substr($vo['content'][0],0,140,'utf-8')); ?>...</span><?php endif; ?>
    </p>

    <p>
      <?php if($vo["status"] == 2): ?><!-- <?php elseif($vo["status"] == 2): ?> -->
        <span style="font-size:14px;">工作要求</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo['content'][0]); ?></span>
      <?php elseif($vo["status"] == 4): ?>
        <span style="font-size:14px;">详细地址</span>
        <span style=" border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><img src=""><?php echo ($vo["address"]); ?></span><?php endif; ?>
    </p>

    <p>
      <?php if($vo["status"] == 4): ?><p style="border-top:5px solid #e5e5e5;padding-left: 10px;padding-top: 10px;">
        <span style="font-size:18px;">招工要求</span>
        <p style="padding-left:16px;"><?php echo ($vo['content'][0]); ?></p></p><?php endif; ?>
    </p>


    
      <!-- <?php if($vo["status"] == 1): ?>文字描述
      <?php elseif($vo["status"] == 2): ?>项目描述
      <?php elseif($vo["status"] == 3): ?>队伍描述
      <?php elseif($vo["status"] == 4): ?>招工要求
      <?php elseif($vo["status"] == 5): ?>店铺描述<?php endif; ?>
    
    <p><?php echo ($vo['content'][0]); ?></p> -->
  </div>
  <div class="nei3">
  		<p><span style="font-size:14px;">联&nbsp;&nbsp;系&nbsp;&nbsp;人</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php echo ($vo["username"]); ?></span></p>
  		<p><span style="font-size:14px;">联系电话</span>
  			<span style="border-left:1px solid #e5e5e5;padding-left:16px;margin-left:16px;"><?php if($_COOKIE['uid']> 0): echo ($vo["moblie"]); else: echo (substr($vo["moblie"],0,7)); ?>****<?php endif; ?>（联系我时请说在建业良机看到的。）</span></p></div>
    <div class="cha">
    	<a href="<?php echo ($_root); ?>publish/other/userid/<?php echo ($vo["uid"]); ?>"><img class="on1" style="cursor:pointer;" src="<?php echo ($_static_); ?>/images/images/dian_03.png"></a><br/>
    	<a href="<?php if($_COOKIE['uid']> 0): ?>tel:<?php echo ($vo["moblie"]); else: echo ($_root); ?>login<?php endif; ?>"><img style="cursor:pointer;" src="<?php echo ($_static_); ?>/images/images/dian_07.png"></a>
    	<!-- <img src="<?php echo ($_static_); ?>/images/images/dian_08.png">
    	<img style="cursor:pointer;" src="<?php echo ($_static_); ?>/images/images/dian_09.png"> -->
    </div>
</div>

<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"4","bdPos":"right","bdTop":"135.5"}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script type="text/javascript">
  
  function collect(){
      var pid = <?php echo (($vo["pid"])?($vo["pid"]):"0"); ?>;

      var index = layer.load(2,{shade:false});
      $.post("<?php echo ($_root); ?>publish/collect",{pid:pid},function(res,s){
            layer.close(index);
            layer.msg(res);
      })
  }

</script>
</body>
</html>