$(function(){
	//设备选择
	$('#device').live('click',function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['设备选择' , true],
		    content: "<div style='width:100px;padding:20px'><select id='Xdevice'>"+device+"</select></div>"
		});
	});
	$('#Xdevice').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#Xdevice option:selected").text();
		$('#device').val(name);
		$('#deviceid').val(id);

	});
	//工种
	$('#craft').live('click',function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['设备选择' , true],
		    content: "<div style='width:200px;padding:20px'><select id='Xcraft'>"+craft+"</select> <input type='button' id='Scraft' value='清空所有'></div>"
		});
	});
	$('#Xcraft').live('change',function(){
		var name,id ='';
		id = $('#craftid').val();
		id += $(this).attr("value")+',';
		name = $('#craft').val();
		name += $("#Xcraft option:selected").text()+' ';
		$('#craft').val(name);
		$('#craftid').val(id);

	});
	//清空工种
	$('#Scraft').live('click',function(){
		$('#craft').val('');
		$('#craftid').val('');
	});
	
	//项目类型
	$('#mold').live('click',function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['设备选择' , true],
		    content: "<div style='width:100px;padding:20px'><select id='Xmold'>"+mold+"</select></div>"
		});
	});
	$('#Xmold').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#Xmold option:selected").text();
		$('#mold').val(name);
		$('#moldid').val(id);

	});
	//服务范围
	$('#alcor').live('click',function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['设备选择' , true],
		    content: "<div style='width:100px;padding:20px'><select id='Xalcor'>"+alcor+"</select></div>"
		});
	});
	$('#Xalcor').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#Xalcor option:selected").text();
		$('#alcor').val(name);
		$('#alcorid').val(id);

	});

	//地址
	$('#area').click(function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['地址选择' , true],
		     area : ['300px','auto'],
		    content: "<div style='padding:20px'><select id='area_1'>"+area_1+"</select>&nbsp;&nbsp;<select id='area_2'><option>--请上级--</option></select></div>"
		});
	});
	$('#area_1').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#area_1 option:selected").text();
		$('#area').val(name);
		$('#area1').val(id);
		ajaxPost(id,'area','area_2');
		

		
	});
	$('#area_2').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#area_1 option:selected").text();
		name += $("#area_2 option:selected").text();
		$('#area').val(name);
		$('#area2').val(id);
		
	});

	//设备出租
	$('#rentOut').click(function(){
		var str = htmlRentOut;
		$('#tab1').html(str);
		$('#status').val('1');
		$('#xtitle').text('设备出租');
		
	});
	//活找队
	$('#workTeam').click(function(){
		var str = htmlWorkTeam;
		$('#tab1').html(str);
		$('#status').val('2');
		$('#xtitle').text('活找队');
	});
	//队找活
	$('#teamWork').click(function(){
		var str = htmlTeamWork;
		$('#tab1').html(str);
		$('#status').val('3');
		$('#xtitle').text('队找活');
	});
	//队找人
	$('#teamPerson').click(function(){
		var str = htmlTeamPerson;
		$('#tab1').html(str);
		$('#status').val('4');
		$('#xtitle').text('队找人');
	});
	//辅材
	$('#alcorAdd').click(function(){
		var str = htmlAlcorAdd;
		$('#tab1').html(str);
		$('#status').val('5');
		$('#xtitle').text('辅材');
	});

	//用户
	$('#username').click(function(){

		layer.open({
		    type: 1,
		    skin: 'layui-layer-demo', //样式类名
		    closeBtn: 1, //不显示关闭按钮
		    shift: 2,
		    shadeClose: true, //开启遮罩关闭
		    title:['用户选择' , true],
		     area : ['380px','auto'],
		    content: "<div style='padding:20px'><input type='text' name='Rusername' id='Rusername' value='' placeholder='请输入手机号' > <select id='Xusername'><option>--请搜索--</option></select> <input type='button' value='搜索' id='Susername'/></div>"
		});
	});
	$('#Susername').live('click',function(){
		var name = $('#Rusername').val();
		ajaxPost(name,'Xusername','Xusername');
	});

	$('#Xusername').live('change',function(){

		var id = $(this).attr("value");
		var name = $("#Xusername option:selected").text();
		
		$('#username').val(name);
		$('#userid').val(id);
		
	});


});
function ajaxPost(id,type,t){
	$.ajax({  
        url: url+"/Demand/ajax/",  
        type:'POST',
        data :{id:id,type:type},
        async:false,
        success: function(data){
        	if(data){
        		$('#'+t).html(data);
        	}
        }
	});
}
