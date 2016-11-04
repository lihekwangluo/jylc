<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><a href="<?php echo ($_root); ?>publish/detail/pid/<?php echo ($vl["pid"]); ?>.html">
<div class="baoliao_content">
<div class="bl_right">
  <div class="bl_title"><?php echo ($vl["title"]); ?></div>
  <div class="bl_note">
    <?php echo ($vl["appchange"]); ?>
  </div>
  <div class="bl_tag">
    <div class="bl_price">发布时间</div>
    <div class="bl_oprice"><?php echo ($vl["addtime"]); ?></div>
  </div>
</div>
    <?php if($vl["rterrace"] == 1): ?><div class="renz_bs1">企业认证</div>
    <?php elseif($vl["renzheng"] == 1): ?>
        <div class="renz_bs1">个人认证</div>
    <?php else: ?>
        <!--<div class="renz_bs">未认证</div>--><?php endif; ?></div>
</a><?php endforeach; endif; else: echo "" ;endif; ?>