 
var Efly = {};//这是一个唯一的全局变量
Efly.tips = function()
{
  var $tips = $("#tips");//显示提示信息
  if($tips.text())
  {
      var outTime = 1500;//设置自动消失的时间
      var box = new Boxy($tips, {title: "消息提示",closeText:"关闭",y:50,behaviours:function(r)
      {
          $(r).hover(
          function(){ clearTimeout(hand);},//当鼠标滑时暂停
          function(){ hand = setTimeout(x,outTime);});
      }
  });
 
  var x = function()
  {
       box.hide();
    };
    var hand = setTimeout(x,outTime);
  }//显示信息提示代码结束
 
};
 