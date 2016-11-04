<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="applicable-device" content="mobile" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?php if($status == 1): ?>工友圈<?php else: ?>子女教育<?php endif; ?> — 建遇良才</title>
<link href="<?php echo ($_static_); ?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/public.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ($_static_); ?>/css/gongy.css" rel="stylesheet" type="text/css" />
<script src="<?php echo ($_static_); ?>/js/jquery-1.8.3.min.js"></script>
<script>
$(window).load(function() {
	$("#status").fadeOut();
	$("#preloader").delay(350).fadeOut("slow");
})
</script>
<style>
.bl_more {
    line-height: 40px;
    text-align: center;
    border-bottom-width: 1px;
    border-bottom-style: solid;
    border-bottom-color: #EEEEEE;
    float: left;
    width: 100%;
}
.bl_more a {
    line-height: 40px;
    height: 40px;
    width: 100%;
    color: #666666;
    text-decoration: none;
    float: left;
    font-size: 12px;
}
</style>
</head>

<body>
<div class="mobile" style="position:relative">
  <div class="weixin weixin_fd "> 
    <div class="fabu_an" style=" width:50px; height:50px;line-height:50px;"><a   data-toggle="modal"  href="#login-modal"> 发布</a></div> 
    <!--弹出--> 
  </div>
	<!--页面加载 开始-->
  <div id="preloader">
    <div id="status">
      <p class="center-text"><span>拼命加载中···</span></p>
    </div>
  </div>
  <!--页面加载 结束--> 
  <!--header 开始-->
  <header>
    <div class="header"> <a class="new-a-back" href="javascript:history.back();"> <span><img src="<?php echo ($_static_); ?>/images/iconfont-fanhui.png"></span> </a>
      <h2><?php if($status == 1): ?>工友圈<?php else: ?>记工<?php endif; ?></h2> 
    </div>
  </header>
  <!--header 结束-->
  <div class="tp">

    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><div class="tp1">
    	<div><a href="<?php echo ($_root); ?>/workmate/detail/id/<?php echo ($vl["wid"]); ?>">
        <div style="position: relative;" > 
            <table style="height:80px;">
                <tr>
                    <td rowspan="2" style="width:80px;height:80px">
                        <img src="<?php echo ($vl["upic"]); ?>" style="width:100%;"/>
                    </td>
                    <td><span style=" margin-left:10px; display:block; font-size:14px; margin-bottom:30px;"><?php echo (mb_substr($vl["content"],0,20,'utf-8')); ?></span></td>
                </tr>
                <tr>                 
                    <td><span style="margin-left:10px;color:#999;font-size:14px;"><?php echo ($vl["nickname"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vl["addtime"]); ?></span>  </td>
                </tr>
            </table>   
          
          
        </div></a></div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    
  </div>
  <?php if(is_array($list)): ?><div class="bl_more" style="text-align: center" id="more"><a href="javascript:;" onclick="get_content()">加载更多</a></div><?php endif; ?>
    <div style="height:250px;"></div>
    <div style="position:fixed;width:100%;background-color:White;bottom:0px">
        <div class="m_user w">
        </div>
        <div class="footer w">
            <a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.zjtd.buildinglife" style="float: left;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-and.png"></div><span style="color:#00bb9c">安卓客户端</span></a>
            <a href="https://itunes.apple.com/cn/app/jian-yu-liang-cai/id1071761808?mt=8" style="float: left;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-ios.png"></div><span style="color:#00bb9c">IOS客户端</span></a>
            <a href="http://www.jylc8.com:8081/wap/index.php" style="text-align: center;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-shouji.png"></div><span style="color:#eb4f38">触摸版</span></a>
            <a href="http://www.jylc8.com:8081/index.php/index" style="float: right;width: 25%"><div class="ico_img"><img src="<?php echo ($_static_); ?>/images/178hui-diannao.png"></div><span>电脑版</span></a>
        </div>
        <div class="copyright">Copyright © 2012-2015 建遇良才 版权所有</div>
    </div>
</div>

<script src="<?php echo ($_static_); ?>/layer/layer.js"></script>
<script type="text/javascript">
var p=2;
var index;
function get_content(){
  var status = <?php echo (($vo["status"])?($vo["status"]):"0"); ?>;
  $.ajax({
    url:"<?php echo ($_root); ?>workmate",
    type: 'post', 
    data:{page:p,status:status}, 
    dataType: 'json', 
    timeout: 10000, 
    error: function(){
       layer.close(index);
           layer.msg("出错啦");
    },
    beforeSend:function(){
        index = layer.load(2, {shade: false});
    },
    success:function(result){
      layer.close(index);
      if(result.status==1) {
        $('#result_inner').append(result.info);
        p = result.next;
      }
      else {
        $("#more").hide();
        layer.msg(result.message);
      }
    } 
  }); 

}
</script>
</body>
</html>