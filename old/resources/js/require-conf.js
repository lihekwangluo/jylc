
require.config({
	urlArgs: 'v=20150716',
    paths : {
		"jquery.ui":pageConfig.linkurl+"js/lib/ui/jquery-ui",
		"pslide":pageConfig.linkurl+"js/app/p.slide",
		"layzload":pageConfig.linkurl+"js/app/lazyload",
		"app":pageConfig.linkurl+"js/app/zhaogong"
    },
	shim : {
		"jquery.ui":{
			deps : [ 'jquery' ]		
		},
		"pslide":{
			deps : [ 'jquery' ]		
		},
		"layzload":{
			deps : [ 'jquery' ]		
		}		
	}
})
require(["jquery"],function($){
	$(function(){
		$('#do_search').click(function(){
			var key = $.trim($('#search_keyword').val());
			if(key!=""){
				location.href = pageConfig.searchurl+encodeURIComponent(key)+'/';
			}
		});			
		$('#search_keyword').keyup(function(e){
			if(e.keyCode=='13'){
				$('#do_search').click();
			}
		});	
		$("#backtop").click(function() {
			$("#backtop").addClass("fire");
			$('body,html').animate({scrollTop:0},1000);	
		})
		$(window).scroll(function() {
			(document.documentElement.scrollTop || document.body.scrollTop) > 0 ? $("#backtop").show() :$("#backtop").removeClass("fire").hide();
		});	
	});
})