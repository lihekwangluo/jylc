require(["require","jquery","app/page","jquery.ui","layzload"],function(require,$,rp){
    $(function() {
		var urlcss = require.toUrl(pageConfig.linkurl+"js/ui/jquery-ui.css")
		chinalao.tool.loadCss(urlcss);
        $("#SELECT_SEX_0").click(function(){
            location.href = ""+pageConfig.filter.sex0+"";
        });
        $("#SELECT_SEX_1").click(function(){
            location.href = ""+pageConfig.filter.sex1+"";
        });
        $('#SELECT_AGE').change(function(){
            location.href = $(this).val();
        });
        var gongzi1 = pageConfig.filter.gz1;
        var gongzi2 = pageConfig.filter.gz2;
        if(gongzi2==0)gongzi2 = 8500;
        //工资范围
        $( "#slider-range" ).slider({
            range: true,
            min: 1000,
            max: 8500,
            step: 500,
            values: [gongzi1,gongzi2],
            slide: function( event, ui ) {
				//拖动居中显示
				var w,wrange,m;
				wrange = ui.values[1]-ui.values[0];
				w = (ui.values[0]-1000)/10;
				m=w+(wrange/20-44);
				$("#amount").stop(1,1).animate({marginLeft:m});	//动画效果	
				//$( "#amount" ).css("margin-left",m);//无动画效果
				
                if(ui.values[ 1 ]==8500){
                    if(ui.values[0]==1000){
                        $( "#amount" ).val('所有');
                    }else{
                        $( "#amount" ).val(ui.values[ 0 ] + ' 以上');
                    }
                }else{
                    $( "#amount" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
                }
            },
            change:function(event,ui){
                var gongzi_base_url = pageConfig.filter.gzurl;
                if(ui.values[ 1 ]==8500)ui.values[ 1 ]=0;
                if(ui.values[0]==1000 && ui.values[ 1] ==0){
                    location.href = gongzi_base_url.replace('_gongzi_/','');
                }else{
                    location.href = gongzi_base_url.replace('_gongzi_',ui.values[ 0 ] + "-" + ui.values[ 1 ]);
                }
            } 
        });
		//初始化居中
		var init_w = ($( "#slider-range" ).slider( "values", 0)-1000)/10;
		var init_range = $( "#slider-range" ).slider( "values", 1)-$( "#slider-range" ).slider( "values", 0);
		var init_m = init_w+(init_range/20-44);
		$( "#amount" ).css("margin-left",init_m);
    });
 
	(function(){
		var m_tid = [];
		var n_tid = [];
		$(".work-box").on("click","a.w-more",function(){
			var $self =$(this);
			var companyid = $self.attr('pcompanyid');
			var $obj = $('[companyid='+companyid+']');
			var strLen = $obj.length-1;
			var time;
			strLen>=10?time =50:strLen>=5?time =100:time=150;
			if($self.hasClass("on")){
				$self.removeClass("on").children(".triangle").html("▼");
				for(var index=strLen; index>= 0; index--){
					!function(index){
						clearTimeout(n_tid[index]);
						m_tid[index]=setTimeout(function(){
							$obj.eq(index).stop(1,1).slideUp(200);
						},time+(strLen-index)*time);	
					}(index);
				}
			}else {
				$self.addClass("on").children(".triangle").html("▲");
				for(var index=0; index<=strLen; index++){
					!function(index){
						clearTimeout(m_tid[index]);
						n_tid[index]=setTimeout(function(){
							$obj.eq(index).stop(1,1).slideDown('100') 
						},time+index*time);
					}(index);
				}
				if(strLen>=3) $('body,html').animate({scrollTop:$self.offset().top},1000);			
			}
		})
	})() 
	
	rp.init();		
	$('[lazyLoadSrc]').WpsLazyLoad();
}) 

 
