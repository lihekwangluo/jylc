<volist name="list" id="vl">
<a href="{$_root}publish/detail/pid/{$vl.pid}.html">
<div class="baoliao_content">
<div class="bl_right">
  <div class="bl_title">{$vl.title}</div>
  <div class="bl_note">
    {$vl.appchange}
  </div>
  <div class="bl_tag">
    <div class="bl_price">发布时间</div>
    <div class="bl_oprice">{$vl.addtime}</div>
  </div>
</div>
    <if condition="$vl.rterrace eq 1">
        <div class="renz_bs1">企业认证</div>
    <elseif condition="$vl.renzheng eq 1"/>
        <div class="renz_bs1">个人认证</div>
    <else/>
        <!--<div class="renz_bs">未认证</div>-->
    </if></div>
</a> 
</volist>