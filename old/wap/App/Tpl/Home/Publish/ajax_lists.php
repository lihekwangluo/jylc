<volist name="list" id="vl">
    <div class="fa_1">
      <div class="zuo1">
        <div style=" float:left; margin-left:10px; margin-top:10px;position:relative">
          <p style="color:#474747; font-size:16px; line-height:40px; font-weight:700;">{$vl.title}</p>
          <p style=" line-height:38px;">{$vl.appchange} <div style="position: absolute; width:60px; height:20px; top: 43px; left: 150px; background-color:#cc0c0c; color:#FFF; text-align:center; border-radius:5px; line-height:20px;">
            <if condition="$vo.rterrace eq 1">平台认证
            <elseif condition="$vo.renzheng eq 1"/>个人认证
            <else/>未认证
            </if></div></p>
          <p style=" line-height:40px;">发布时间：{$vl.addtime}</p>
        </div>
        
      </div>
    </div>
</volist>