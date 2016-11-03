    <volist name="list" id="vl">
  	<div class="tp1">
    	<div>
    		<a href="{$_root}/workmate/detail/id/{$vl.wid}">
        		<div class="tn" >
		          	<p>{$vl.addtime}</p>
		          	<h2>{$vl.title}</h2><br/>
                <!-- <p><span>点赞</span><span>评论</span></p> -->
          			<span style=" display:block; font-size:14px; margin-bottom:30px;">{$vl.content|mb_substr=###,0,20,'utf-8'}</span>
          		</div>
          	</a>
         </div>
    </div>
    </volist>