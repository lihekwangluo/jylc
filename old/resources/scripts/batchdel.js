// 批量删除
$(function(){
	$("#fruit").click(function(){
		var t = $(this).attr("checked");
		if(t == 'checked'){
			$(".sc").attr("checked",'true');

		}else{
			$(".sc").removeAttr("checked");
		}
	});
	//删除
	$('#batchdel').click(function(){
		if(confirm('确定删除吗?')){
			caozu(url,url2,'del');
		}
	});
	//改变状态
	$('#gbzt').click(function(){
		if(confirm('确定要操作吗?')){
			caozu(url,url2,'zhuangtai');
		}
	});
	//数据库操作
	//备份
	$('#databf').click(function(){
		dataxuanze('data');
		
	});
	//数据库恢复
	$('#databack').click(function(){
		dataxuanze('databackS');
	});
	//数据库备份删除
	$('#datadel').click(function(){
		dataxuanze('datadelS');
	});


});
function dataxuanze(dd){
	var id='';
	$("[name='sc']:checked").each(function(){
	 	id+= $(this).val()+",";
	});
	if(id){
		$('#'+dd).val(id);
		$('form').submit();
	}else{
		alert('请选择数据表');
	}
}
function caozu(url,url2,type,text){
		var id='';
		$("[name='sc']:checked").each(function(){
		 	id+= $(this).val()+",";
		});
		if(id){
			$.ajax({  
		        url: url,  
		        type:'POST',
		        data :{id:id,type:type},
		        async:false,
		        success: function(data){

		          if(data){
		          	window.location.href=url2;
		          }else{
		          	alert('操作失败！');
		          }
	        	}
    		}); 
		}
}