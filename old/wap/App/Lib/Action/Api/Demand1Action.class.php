<?php
error_reporting(E_ALL&&E_ERROR);
// 发布商品
class Demand1Action extends IndexAction{

	//发布需求
	public function publish(){

		$data = array();
		$token = I('post.token')?I('post.token'):I('get.token');
		$resstext = I('post.resstext')?I('post.resstext'):I('get.resstext');//文字地区
		$status = intval(I('post.status')?I('post.status'):I('get.status'));
		$craftid = trim(I('post.craftid')?I('post.craftid'):I('get.craftid'),',');//工种
		$deviceid = trim(I('post.deviceid')?I('post.deviceid'):I('get.deviceid'),',');//设备
		$moldid = trim(I('post.moldid')?I('post.moldid'):I('get.moldid'),',');//项目类型
		$alcorid = trim(I('post.alcorid')?I('post.alcorid'):I('get.alcorid'),',');//商店分类
		$pid = I('post.pid')?I('post.pid'):I('get.pid');//发布需求id
		$type = I('post.ptype')?I('post.ptype'):I('get.ptype');//发布需求id
		//用户提前判断
		$Public = D('Public');
		$uerContent = $Public->userTokenCark($token);
		$userid = $uerContent['0']['id'];
		$Demand = D('Demand');
		$t = $Demand->publishTime($userid);
		if(empty($t)){
			get_obj_array('20000','发布太过频繁，请稍后！','');
		}
		$Publish = M('Publish');
		//修改判断
		if(!empty($pid)){
			$PContent = $Publish->where("id = '$pid' and userid='$userid'")->limit(1)->select();
			if(empty($PContent)){
				get_obj_array('20000','修改数据不存在','');
			}
		}
		//添加类型判断
		if($status == 1){
			if(!empty($deviceid)){
				$data = $this->rentOut();
			}
			
		}elseif($status == 2){
			if(!empty($moldid) || !empty($craftid)){
				$data = $this->workTeam();
			}
			
		}elseif($status == 3){
			if(!empty($craftid)){
				$data = $this->teamWork();
			}
			
		}elseif($status == 4){
			
				$data = $this->teamPerson();
			
			
		}elseif($status == 5){
			
				if(!empty($alcorid)){

					$data = $this->alcorAdd($uerContent);
				}
			
		}else{
			get_obj_array('20000','非法请求！','');
		}
		$address = I('post.address')?I('post.address'):I('get.address');//详细地址
		if(!empty($address)){
			$data['address'] = $address;
		}
		if(!empty($resstext)){
			$resstextArr = $this->resstext($resstext);
			$_POST['area1'] = $resstextArr['0'];
			$_POST['area2'] = $resstextArr['1'];
			$_POST['area3'] = $resstextArr['2'];
		}

		$area1 = I('post.area1')?I('post.area1'):I('get.area1');//城市一级
		if(!empty($area1)){
			$data['area1'] = $area1;
			$area2 = I('post.area2')?I('post.area2'):I('get.area2');//城市二级
			if(!empty($area2)){
				$data['area2'] = $area2;
				$area3 = I('post.area3')?I('post.area3'):I('get.area3');//城市三级
				if(!empty($area3)){
					$data['area3'] = $area3;
				}
			}
		}
	
		$username = I('post.username')?I('post.username'):I('get.username');//联系人
		if(!empty($username)){
			$data['username'] = $username;
		}
		$moblie = I('post.moblie')?I('post.moblie'):I('get.moblie');//联系电话
		if(!empty($moblie)){
			$data['moblie'] = $moblie;
		}
		$power = I('post.power')?I('post.power'):I('get.power');//权限
		if(!empty($power)){
			$data['power'] = $power;
		}
		$content = $Public->delSensitivity(I('post.content')?I('post.content'):I('get.content'));//详细要求
		if(!empty($content)){
			$data['content'] = $content;
		}
		//分类入库
		if(!empty($craftid)){
			$data['craftid'] = $craftid;
		}
		if(!empty($deviceid)){
			$data['deviceid'] = $deviceid;
		}
		if(!empty($moldid)){
			$data['moldid'] = $moldid;
		}
		if(!empty($alcorid)){
			$data['alcorid'] = $alcorid;
		}
		if(empty($data['username']) || empty($data['moblie']) || empty($data['power'])){
			
				get_obj_array('20000','参数不全！','');
			
		}else{

			
			//图片
			if(!empty($_FILES)){
				$picArr = explode(',', $PContent['0']['pic']);
				$imgArr = $Public->imgFile('1');
				$pic = '';
				for($i=0;$i<=9;$i++) {
					$Public->delImg($picArr[$i]);
					$pic .= $imgArr['pic'.$i].',';
				}
				if(!empty($imgArr['terracepic1'])){
					$picArr = explode(',', $PContent['0']['terracepic']);
					$Public->delImg($picArr['0']);
					$Public->delImg($picArr['1']);
					$Public->delImg($picArr['2']);
					$data['terracepic'] = $imgArr['terracepic1'];
					if(!empty($imgArr['terracepic2'])){
						$data['terracepic'] .= ','.$imgArr['terracepic2'];
						if(!empty($imgArr['terracepic3'])){
							$data['terracepic'] .= ','.$imgArr['terracepic3'];
						}
					}
				}
				

				$data['pic'] = trim($pic,',');
				
			}
			$data['title'] = $this->autoTitle();
			$data['addtime'] = time();
			if(empty($pid)){
				$data['userid'] = $userid;
				$data['type'] = $type;
				$publishid = $Publish->add($data);
			}else{
				$Publish->where("id='".$pid."'")->data($data)->save();
				$publishid = $pid;
			}
			
			
			//分类添加
			if(!empty($craftid)){
				$this->cateDispose('1',$craftid,$userid,$publishid);
			}
			if(!empty($deviceid)){
				$this->cateDispose('2',$deviceid,$userid,$publishid);
			}
			if(!empty($moldid)){
				$this->cateDispose('3',$moldid,$userid,$publishid);
			}
			if(!empty($alcorid)){
				$this->cateDispose('4',$alcorid,$userid,$publishid);
			}

			$root = array();
			$root['token'] = $token;
			$root['userid'] = (string)$userid;
			$root['status'] = (string)$status;
			get_obj_array('10000','操作成功！',array($root));
		}
		

	}


	
	//设备出租
	public function rentOut(){
		$deviceid = trim(I('post.deviceid')?I('post.deviceid'):I('get.deviceid'),',');//设备id
		$num = intval(I('post.num')?I('post.num'):I('get.num'));//数量
		$model = I('post.model')?I('post.model'):I('get.model');//型号
		$driver = intval(I('post.driver')?I('post.driver'):I('get.driver'));//司机
		if(empty($deviceid) || empty($num) || empty($model)){

			get_obj_array('20000','参数不全！','');

		}else{
			$data['deviceid'] = $deviceid;
			$data['num'] = $num;
			$data['model'] = $model;
			$data['status'] = 1;
			$data['driver'] = $driver;
			return $data;
		}

	}
	//活找队
	public function workTeam(){
		$price = I('post.price')?I('post.price'):I('get.price'); //价格
		$num = intval(I('post.num')?I('post.num'):I('get.num'));//队伍人数
		$square = I('post.square')?I('post.square'):I('get.square'); //工程量
		if(empty($price) || empty($square)){
			get_obj_array('20000','参数不全！','');
		}else{
			$data['price'] = $price;
			$data['num'] = $num;
			$data['square'] = $square;
			$data['status'] = 2;
			return $data;
		}



	}
	//队找活
	public function teamWork(){
		$num = intval(I('post.num')?I('post.num'):I('get.num'));//队伍人数
		if(empty($num)){
			get_obj_array('20000','参数不全！','');
		}else{
			$data['num'] = $num;
			$data['status'] = 3;
			return $data;
		}

	}
	//队找人
	public function teamPerson(){
		$num = intval(I('post.num')?I('post.num'):I('get.num'));//队伍人数
		$age1 = intval(I('post.age1')?I('post.age1'):I('get.age1'));//年龄开始
		$age2 = intval(I('post.age2')?I('post.age2'):I('get.age2'));//年龄结束
		$price = I('post.price')?I('post.price'):I('get.price');//价格
		$price = explode('-',$price);
		$price1 = intval($price['0']);
		$price2 = intval($price['1']);
		if($price1==0){
			if($price2 !=0){
				$price1 = $price2;
			}
		}
		if(empty($num) || empty($age1) || empty($age2)){
			get_obj_array('20000','参数不全！','');
		}else{
			$data['num'] = $num;
			$data['age1'] = $age1;
			$data['age2'] = $age2;
			$data['price'] = $price1;
			$data['price2'] = $price2;
			$data['status'] = 4;
			return $data;
		}

	}
	//辅材
	public function alcorAdd($arr){
		
		$shopname = I('post.shopname')?I('post.shopname'):I('get.shopname');//店铺名称
		if(empty($shopname)){
			get_obj_array('20000','参数不全！','');
		}else{
			$data['shopname'] = $shopname;
			$data['status'] = 5;
			$data['zhuangtai'] = 0;

			return $data;
		}


	}

	//分类处理
	/*
		参数：
			$t         1是工种，2是设备，3是项目类型
			$cateid    分类id
			$userid    用户id
			$publishid 发布需求id

	*/
	public function cateDispose($t,$cateid,$userid,$publishid){
		if($t == '1'){
			$t = "Publishcraft";
		}elseif($t == '2'){
			$t = "Publishdevice";
		}elseif($t == '3'){
			$t = "Publishmold";
		}elseif($t == '4'){
			$t = "publishalcor";
		}

		$cateid = explode(',',$cateid);

		//删除这个分类
		$PublishF = M($t);
		$PublishF->where("publishid='$publishid'")->delete();
		foreach($cateid as $key => $value) {
			if((intval($value) > 0) && (intval($publishid)>0)){
				$data = array();
				$data['userid'] = $userid;
				$data['cateid'] = $value;
				$data['publishid'] = $publishid;
				$PublishF->add($data);
			}
			
		}
	}
	//自动生成标题
	public function autoTitle(){
		$area1 = I('post.area1')?I('post.area1'):I('get.area1');//城市一级
		$area2 = I('post.area2')?I('post.area2'):I('get.area2');//城市二级
		$area3 = I('post.area3')?I('post.area3'):I('get.area3');//城市二级
		$status = intval(I('post.status')?I('post.status'):I('get.status'));
		$num = intval(I('post.num')?I('post.num'):I('get.num'));
		$craftid = trim(I('post.craftid')?I('post.craftid'):I('get.craftid'),',');
		$craftid = explode(',',$craftid);
        $craftids = $craftid;
		$craftid = $craftid['0'];
		$where = $title = '';
		if($area1){
			$where = " area_id = '$area1' ";
			if($area2){
				$where .= " or area_id = '$area2' ";
				if($area3){
					$where .= " or area_id = '$area3' ";
				}
			}


			//查询地区
			$Area = M('Area');
			$list = $Area->where($where)->select();
			$title = $list['0']['area_name'].$list['1']['area_name'];
			//查询工种
			$Craft = M('Craft');
			$list = $Craft->where("id = '$craftid'")->limit(1)->select();
            $craft_list = $Craft->where("id IN '$craftids'")->select();
            $crafts = array();
            foreach($craft_list as $value){
                $crafts[] = $value['name'];
            }
			if($status== 4){
				$title .= '招'.implode(',',$crafts).$num.'人';
			}elseif($status== 3){
				$title .= '有'.$num.'人'.$list['0']['name'].'队';
			}elseif($status== 2){
				$title .= '招'.$list['0']['name'].'队';
			}elseif($status== 5){
				$alcorid = trim(I('post.alcorid')?I('post.alcorid'):I('get.alcorid'),',');
				$shopname = I('post.shopname')?I('post.shopname'):I('get.shopname');
				$alcorid = explode(',',$alcorid);
				$alcorid = $alcorid['0'];
				$Alcor = M('Alcor');
				$list = $Alcor->where("id = '$alcorid'")->limit(1)->select();
				$title .= $shopname.$list['0']['name'].'店';
			}elseif($status == 1) {
				$deviceid = trim(I('post.deviceid')?I('post.deviceid'):I('get.deviceid'),',');
				$deviceid = explode(',',$deviceid);
				$deviceid = $deviceid['0'];
				$Device = M('Device');
				$list = $Device->where("id = '$deviceid'")->limit(1)->select();
				$title .= '出租'.$list['0']['name'];

			}
		}
		return $title;

	}
	//文字地区查询
	public function resstext($str){
		$str = explode(' ',$str);
		$Area = M('Area');
		for ($i=0; $i < 3; $i++) { 
			if(!empty($str[$i])){
				$list = $Area->where("area_name = '".$str[$i]."'")->limit(1)->select();
				$arr[$i] = $list['0']['area_id'];
			}
		}
		return $arr;
		

	}
	//end发布需求

	//首页
	public function publishHome(){
		$Publish = M();
		$arr = array();
		$variable = array('4','2','3','5','1');
		foreach ($variable as $key => $value) {
			$sql = "SELECT p.*,u.id as uid,u.rterrace,u.renzheng,u.type FROM zj_publish as p 
					INNER JOIN zj_user AS u ON u.id = p.userid 
					WHERE p.status = '$value' group by p.id desc limit 1";
			$list = $Publish->query($sql);
			$arr[] =$list['0']; 
		}
		$list = $this->homeList($arr);
		get_obj_array('10000','成功',$list);

	}

	// 获取发布需求列表
	/*
		参数：
			token 
			id
			status
			soso
			renzheng
			地区 area1,area2,area3
			工种 craftid 	多个逗号隔开
			人数 num 		用逗号隔开如
			设备 deviceid 	多个逗号隔开
			价格 price 		用逗号隔开如 开始价格,结束价格

					排序 sort
						企业 1
						商家 2
						司机 3

		查看其他 传该用户的userid

		
	*/

	public function publishList1(){
		$token = I('token');//用户标示
		$area1 = I('area1');//城市一级
		$area2 = I('area2');//城市二级
		$area3 = I('area3');//城市二级
		$craftid = I('craftid');//工种
		$deviceid = I('deviceid');//设备
		$price = I('price');//价格
		$num = I('num');//人数
		$status = intval(I('status'));
		$sort = I('sort');
		$userid = I('userid');
		$id =  I('pid');
		$soso =  I('soso');
		$renzheng = I('renzheng');

		//对未认证用户初始化
		$map = array();
		$map['p.zhuangtai'] = 1;
		$map['p.power'] = 2;

		//对认证用户初始化
		if(!empty($token)){
			$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			if($uerContent['0']['renzheng'] == 1){
				$map['p.zhuangtai'] = 1;
			}
		}
		if(!empty($status)){
			$map['p.status'] = $status;
		}

		if(!empty($userid)){
			if(empty($status)){ //我的发布
				if(!empty($uerContent)){
					$map['p.userid'] = $uerContent['0']['id'];
				}else{
					$map['p.userid'] = $userid;
				}
			}else{ //查看其他
				$map['p.userid'] = $userid;
			}

		}elseif(!empty($id)){
			$map['p.id'] = $id;
		}elseif(!empty($soso)){ //搜索  MATCH(p.title,a.area_name) AGAINST ($soso)
			import("ORG.Util.analysis.phpanalysis");
			$do_fork = $do_unit = true;
			$do_multi = $do_prop = $pri_dict = false;
			//初始化类
			PhpAnalysis::$loadInit = false;
		    $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
		    
		    //载入词典
		    $pa->LoadDict();
		        
		    //执行分词
		    $pa->SetSource($soso);
		    $pa->differMax = $do_multi;
		    $pa->unitWord = $do_unit;
		    
		    $pa->StartAnalysis( $do_fork );
		    
		    $str = $pa->GetFinallyResult(' ', $do_prop);
		    $str = trim($str);
			$map['_string'] = "match(p.word) against('".$str."')";
			$Searchthe = M('Searchthe');
			$Slist = $Searchthe->where("name = '$soso'")->limit('1')->select();
			$Sdata = array();
			if(empty($Slist)){
				$Sdata['name'] = $soso;
				$Sdata['addtime'] = time();
				$Searchthe->add($Sdata);
			}else{
				$Sdata['num'] =  $Slist['0']['num'] + 1;
				$Searchthe->where("name = '$soso'")->data($Sdata)->save();
			}
			
		}else{

			if(!empty($renzheng)){
				$map['u.renzheng'] = 1;
				//$where .= " and u.renzheng = '1' ";
			}
			//判断城市
			if($area3){
				$map['p.area3'] = $area3;
			}else if($area2 && !$area3){
				$map['p.area2'] = $area2;
			}else if($area1 && !$area2){
				$map['p.area1'] = $area1;
			}
			// if(!empty($area1)){
			// 	$map['p.area1'] = $area1;
			// 	//$twhere = " and ( p.area1 = '$area1' ";

			// 	if(!empty($area2)){
			// 			$map['']
			// 			$twhere .= " or p.area2 = '$area2' ";

			// 		if(empty($area3)){
			// 			$twhere .= " or p.area3 = '$area3' ";
			// 		}
			// 	}
			// 	$where .= $twhere." ) ";
			// }
			//end 判断城市

			//工种
			if(!empty($craftid)){
				$craftid = trim($craftid,',');
				$map['c.id'] = array("in",$craftid);
				//$where .= " and c.id in($craftid) ";
				//$inner .= " INNER JOIN zj_publishcraft AS c ON c.publishid = p.id "; 
			}

			//判断人数
			if(!empty($num)){
				$num = explode(',',$num);
				if(!empty($num)){
					if(!empty($num['0'])){
						$map['p.num'] = array("gt",$num[0]);
						//$where .= " and p.num > '".$num['0']."' ";
						if(!empty($num['1'])){
							$map['p.num'] = array("lt",$num[1]);
							//$where .= " and p.num < '".$num['1']."' ";
						}
					}
				}
			}
			//判断价格
			if(!empty($price)){
				$price = explode(',',$price);
				if(!empty($price)){
					if(!empty($price['0'])){
						$map['p.price'] = array("gt",$price[0]);
						//$where .= " and p.price > '".$price['0']."' ";
						if(!empty($num['1'])){
							$map['p.price'] = array("lt",$price[1]);
							//$where .= " and p.price < '".$price['1']."' ";
						}
					}
				}
			}
			//判断设备
			if(!empty($deviceid)){
				$deviceid = trim($deviceid,',');
				$map['d.id'] = array("in",$deviceid);
				//$where .= " and d.id in($deviceid) ";
				//$inner .= " INNER JOIN zj_publishdevice AS d ON d.publishid = p.id "; 
			}
			//排序
			if($sort == 1){ //企业
				$map['u.type'] = 2;
				//$where .= " and u.type='2' ";
			}elseif($sort == 2){ //商家
				$map['u.type'] =1;
				//$where .= " and u.type='1' ";
				//$inner .= " "; 
			}elseif($sort == 3){ //司机
				$map['p.driver'] = 1;
				//$where .= " and p.driver='1' ";
			}

		}

		$limit = pageLimit();
		$field = "p.*,u.id as uid,u.rterrace,u.renzheng,u.type as stype";
		$order = "";
		$list = M("publish p")->field($field)
							  ->join("zj_user u ON u.id=p.userid")
							  ->join("zj_publishcraft c ON c.publishid = p.id")
							  ->join("zj_publishdevice d ON d.publishid = p.id")
							  ->where($map)
							  ->limit($limit)
							  ->order("p.id desc")
							  ->select();
		if(!empty($list)){
			//类型判断
			if(!empty($id)){
				$status = $list['0']['status'];
			}
			
			if($status == 1){
				
				$list = $this->rentOutList($list);
			}elseif($status == 2){

				$list = $this->workTeamList($list);
			}elseif($status == 3){

				$list = $this->teamWorkList($list);
			}elseif($status == 4){
				$list = $this->teamPersonList($list);
			}elseif($status == 5){

				$list = $this->alcorList($list);
			}else{
				//主页
				$list = $this->homeList($list);

			}
			//判断是否收藏
			$list = $this->selectReason($list,$uerContent['0']['id']);

			get_obj_array('10000','成功',$list);
		}else{
			get_obj_array('20000','未查询到更多数据','');
		}						  
	}

	public function publishList(){
			$token = I('post.token')?I('post.token'):I('get.token');//用户标示
			$area1 = I('post.area1')?I('post.area1'):I('get.area1');//城市一级
			$area2 = I('post.area2')?I('post.area2'):I('get.area2');//城市二级
			$area3 = I('post.area3')?I('post.area3'):I('get.area3');//城市二级
			$craftid = trim(I('post.craftid')?I('post.craftid'):I('get.craftid'),',');//工种
			$deviceid = trim(I('post.deviceid')?I('post.deviceid'):I('get.deviceid'),',');//设备
			$price = I('post.price')?I('post.price'):I('get.price');//价格
			$num = I('post.num')?I('post.num'):I('get.num');//人数
			$status = intval(I('post.status')?I('post.status'):I('get.status'));
			$sort = I('post.sort')?I('post.sort'):I('get.sort');
			$userid = I('post.userid')?I('post.userid'):I('get.userid');
			$id = I('post.pid')?I('post.pid'):I('get.pid');
			$soso = I('post.soso')?I('post.soso'):I('get.soso');
			$renzheng = I('post.renzheng')?I('post.renzheng'):I('get.renzheng');

	
			
			//对未认证用户初始化
			$where = ' p.zhuangtai = 1 and p.power = 2 ';
			$inner = '';

			//对认证用户初始化
			if(!empty($token)){
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				if($uerContent['0']['renzheng'] == 1){
					$where =' p.zhuangtai = 1 ';
				}
			}
			if(!empty($status)){
				$where .= " and p.status ='$status' ";

			}


			//分页
			$limit = pageLimit();
			
			//这个用户发布的
			if(!empty($userid)){
				if(empty($status)){ //我的发布
					if(!empty($uerContent)){
						$where .= " and p.userid='".$uerContent['0']['id']."'";
					}else{
						$where .= " and p.userid='$userid' ";
					}
					
				}else{ //查看其他
					$where .= " and p.userid='$userid' ";
				}

				
			}elseif(!empty($id)){
				$where .= " and p.id='$id' ";
			}elseif(!empty($soso)){ //搜索
				$where .= " and p.title like '%$soso%' ";
				$Searchthe = M('Searchthe');
				$Slist = $Searchthe->where("name = '$soso'")->limit('1')->select();
				$Sdata = array();
				if(empty($Slist)){
					$Sdata['name'] = $soso;
					$Sdata['addtime'] = time();
					$Searchthe->add($Sdata);
				}else{
					$Sdata['num'] =  $Slist['0']['num'] + 1;
					$Searchthe->where("name = '$soso'")->data($Sdata)->save();
				}
				
			}else{
					if(!empty($renzheng)){
						$where .= " and u.renzheng = '1' ";
					}
					//判断城市
					if(!empty($area1)){
						$twhere = " and ( p.area1 = '$area1' ";

						if(!empty($area2)){
								$twhere .= " or p.area2 = '$area2' ";

							if(empty($area3)){
								$twhere .= " or p.area3 = '$area3' ";
							}
						}
						$where .= $twhere." ) ";
					}
					//end 判断城市

					//工种
					if(!empty($craftid)){
						$craftid = trim($craftid,',');
						$where .= " and c.id in($craftid) ";
						$inner .= " INNER JOIN zj_publishcraft AS c ON c.publishid = p.id "; 
					}

					//判断人数
					if(!empty($num)){
						$num = explode(',',$num);
						if(!empty($num)){
							if(!empty($num['0'])){
								$where .= " and p.num > '".$num['0']."' ";
								if(!empty($num['1'])){
									$where .= " and p.num < '".$num['1']."' ";
								}
							}
						}
					}
					//判断价格
					if(!empty($price)){
						$price = explode(',',$price);
						if(!empty($price)){
							if(!empty($price['0'])){
								$where .= " and p.price > '".$price['0']."' ";
								if(!empty($num['1'])){
									$where .= " and p.price < '".$price['1']."' ";
								}
							}
						}
					}
					//判断设备
					if(!empty($deviceid)){
						$deviceid = trim($deviceid,',');
						$where .= " and d.id in($deviceid) ";
						$inner .= " INNER JOIN zj_publishdevice AS d ON d.publishid = p.id "; 
					}
					//排序
					if($sort == 1){ //企业
						$where .= " and u.type='2' ";
					}elseif($sort == 2){ //商家
						$where .= " and u.type='1' ";
						$inner .= " "; 
					}elseif($sort == 3){ //司机
						$where .= " and p.driver='1' ";
					}

			}

			//查询数据
			$Publish = M();
			$sql = "SELECT p.*,u.id as uid,u.rterrace,u.renzheng,u.type as stype FROM zj_publish as p
					INNER JOIN zj_user AS u 
					ON u.id = p.userid 
					$inner
					WHERE $where group by p.id desc limit $limit";
			$list = $Publish->query($sql);
			if(!empty($list)){
				//类型判断
				if(!empty($id)){
					$status = $list['0']['status'];
				}
				
				if($status == 1){
					
					$list = $this->rentOutList($list);
				}elseif($status == 2){

					$list = $this->workTeamList($list);
				}elseif($status == 3){

					$list = $this->teamWorkList($list);
				}elseif($status == 4){
					$list = $this->teamPersonList($list);
				}elseif($status == 5){

					$list = $this->alcorList($list);
				}else{
					//主页
					$list = $this->homeList($list);

				}
				//判断是否收藏
				$list = $this->selectReason($list,$uerContent['0']['id']);

				get_obj_array('10000','成功',$list);
			}else{
				get_obj_array('20000','未查询到更多数据','');
			}	

	}
	//出租
	public function rentOutList($arr){
		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];


			$root[$key]['num'] = (string)$value['num'];
			$root[$key]['model'] = $value['model'];
			$root[$key]['driver'] = $value['driver'];
			$root[$key]['device'] = $this->cateDisposeList('2',$value['deviceid']);
			$root[$key]['appchange'] = $this->appChange($root[$key]);
		}
		return $root;

	}
	//活找队
	public function workTeamList($arr){
		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];


			$root[$key]['num'] = (string)$value['num'];
			$root[$key]['square'] = (string)$value['square'];
			$root[$key]['price'] = (string)$value['price'];
			$root[$key]['mold'] = $this->cateDisposeList('3',$value['moldid']);
			$root[$key]['craft'] = $this->cateDisposeList('1',$value['craftid']);
			$root[$key]['appchange'] = $this->appChange($root[$key]);
			
		}
		return $root;
		
	}
	//队找活
	public function teamWorkList($arr){

		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];


			$root[$key]['num'] = (string)$value['num'];
			$root[$key]['craft'] = $this->cateDisposeList('1',$value['craftid']);
			$root[$key]['appchange'] = $this->appChange($root[$key]);
			
		}
		return $root;
		
	}
	//队找人
	public function teamPersonList($arr){

		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];


			$root[$key]['num'] = (string)$value['num'];
			$root[$key]['age1'] = (string)$value['age1'];
			$root[$key]['age2'] = (string)$value['age2'];
			$root[$key]['price'] = (string)$value['price'];
			$root[$key]['price2'] = (string)$value['price2'];
			$root[$key]['craft'] = $this->cateDisposeList('1',$value['craftid']);
			$root[$key]['appchange'] = $this->appChange($root[$key]);
			
		}
		return $root;

	}
	//辅材购买
	public function alcorList($arr){

		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];
			
			$root[$key]['shopname'] = (string)$value['shopname'];
			$root[$key]['alcor'] = $this->cateDisposeList('4',$value['alcorid']);
			$root[$key]['appchange'] = $this->appChange($root[$key]);
			$root[$key]['terracepic'] = explode(",",$value['terracepic']);

		}
		return $root;

	}
	//主页
	public function homeList($arr){

		$root = array();
		foreach ($arr as $key => $value){
			$root[$key]['pid'] = (string)$value['id'];
			$root[$key]['uid'] = (string)$value['uid'];
			$root[$key]['rterrace'] = (string)$value['rterrace'];
			$root[$key]['renzheng'] = (string)$value['renzheng'];
			$root[$key]['title'] = (string)$value['title'];
			$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
			$root[$key]['pic'] = explode(',',$value['pic']);
			$root[$key]['address'] = (string)$value['address'];
			$root[$key]['content'] = explode("\r\n",$value['content']);
			$root[$key]['username'] = (string)$value['username'];
			$root[$key]['moblie'] = (string)$value['moblie'];
			$root[$key]['type'] = (string)$value['stype'];
			$root[$key]['status'] = (string)$value['status'];
			$root[$key]['square'] = (string)$value['square'];
			$root[$key]['num'] = (string)$value['num'];
			$root[$key]['power'] = (string)$value['power'];
			$root[$key]['area'] = $this->selectArea($value['area1'],$value['area2'],$value['area3']);
			$root[$key]['ptype'] = (string)$value['type'];

			$root[$key]['price'] = (string)$value['price'];
			$root[$key]['price2'] = (string)$value['price2'];
			$root[$key]['alcor'] = $this->cateDisposeList('4',$value['alcorid']);

			$root[$key]['appchange'] = $this->appChange($root[$key]);

			
		}

		return $root;

	}
	//显示app 变化的五种
	public function appChange($arr){

		$str = "";
		if($arr['status'] == 1){
			$str = "类型：";
			$str .= $arr['type']==1?'个人':'商家';
		}elseif($arr['status'] == 2){
			$str = "建筑规模：".$arr['square']." 平米";
		}elseif($arr['status'] == 3){
			$str = "队伍：".$arr['num']." 人";
		}elseif($arr['status'] == 4){
			$str = "待遇：".$arr['price']."-".$arr['price2']." 元";
		}elseif($arr['status'] == 5){
			$str = "经营范围：";
			foreach ($arr['alcor'] as $key => $value) {
				$str .= $value['name'] . ' ';
			}
		}
		return $str;
	}
	//分类
	public function cateDisposeList($t,$cateid){
		if($t == '1'){
			$t = "Craft";
		}elseif($t == '2'){
			$t = "Device";
		}elseif($t == '3'){
			$t = "Mold";
		}elseif($t == '4'){
			$t = "Alcor";
		}

		//查询
		$PublishF = M($t);
		$list = $PublishF->where("id in($cateid)")->select();
		$data = array('0'=>array('cid'=>'0','name'=>''));
		foreach($list as $key => $value) {
			$data[$key]['cid'] = $value['id'];
			$data[$key]['name'] = $value['name'];
		}
		return $data;
	}

	//查询是否收藏
	public function selectReason($arr,$userid){
		$Collect = M('Collect');
		$root = array();
		foreach ($arr as $key => $value) {
			$list = '';
			$root[$key] = $value;
			if(!empty($userid)){
				$list = $Collect->where("publishid = '".$value['pid']."' and userid = '".$userid."'")->limit(1)->select();
			}
			if(empty($list)){
				$root[$key]['collect'] = '0';
			}else{
				$root[$key]['collect'] = '1';
			}
		}
		return $root;
		

	} 

	// 地区查询
	public function selectArea($area1,$area2,$area3){
		$Area = M('Area');
		$array1 = array('area_id'=>'0','area_name'=>'');
		if(!empty($area1)){
			$list = $Area->where("area_id = '".$area1."'")->limit(1)->select();
			$array1['area_id'] = (string)$list['0']['area_id'];
			$array1['area_name'] = (string)$list['0']['area_name'];
		}
		$array2 = array('area_id'=>'0','area_name'=>'');
		if(!empty($area2)){
			$list = $Area->where("area_id = '".$area2."'")->limit(1)->select();
			$array2['area_id'] = (string)$list['0']['area_id'];
			$array2['area_name'] = (string)$list['0']['area_name'];
		}
		$array3= array('area_id'=>'0','area_name'=>'');
		if(!empty($area2)){
			$list = $Area->where("area_id = '".$area3."'")->limit(1)->select();
			$array3['area_id'] = (string)$list['0']['area_id'];
			$array3['area_name'] = (string)$list['0']['area_name'];
		}
		return $arr = array($array1,$array2,$array3);
		
		
	}
	//end 获取列表

	//删除发布信息
	/*
		参数：
			token
			pid 
	*/
	public function publishDel(){
		 $token = I('post.token')?I('post.token'):I('get.token');
		 $publishid = trim(I('post.pid')?I('post.pid'):I('get.pid'),',');
		 if(empty($token) || empty($publishid)){
		 	get_obj_array('20000','参数不全！','');
		 }else{
		 	$Public = D('Public');
			$uerContent = $Public->userTokenCark($token);
			$userid = $uerContent['0']['id'];
			//查询是否
			$Publish = M('Publish');
			$list = $Publish->where("id in ($publishid) and userid = '$userid'")->limit(1)->select();
			if(!empty($list)){
				$img = array('pic','terracepic');
				$Public->delImgAll('zj_publish',"id in ($publishid) and userid = '$userid'",$img);
			 	$Public->delImgAll('zj_publishalcor',"publishid in ($publishid) and userid = '$userid'",'');
			 	$Public->delImgAll('zj_publishcraft',"publishid in ($publishid) and userid = '$userid'",'');
			 	$Public->delImgAll('zj_publishdevice',"publishid in ($publishid) and userid = '$userid'",'');
			 	$Public->delImgAll('zj_publishmold',"publishid in ($publishid) and userid = '$userid'",'');
			 	$Public->delImgAll('zj_collect',"publishid in ($publishid)",'');
			 	get_obj_array('10000','删除成功',$token);
			}else{
				get_obj_array('20000','未查询到数据','');
			}
		 	
		 }

	}


	//举报发布信息
	/*
		参数：
			token 		用户唯一标示
			pid 		发布需求id
			reason 		举报理由
			content     我有话说


	*/
	public function reason(){

		    $token = I('post.token')?I('post.token'):I('get.token');
		    $data['publishid'] = I('post.pid')?I('post.pid'):I('get.pid');
		    $data['reason'] = I('post.reason')?I('post.reason'):I('get.reason');
		    $data['content'] = I('post.content')?I('post.content'):I('get.content');
		    if(empty($data['publishid']) || empty($data['publishid']) || empty($data['content'])){
		    	get_obj_array('20000','参数不全！','');
		    }else{
		    	//查询该信息是否存在
		    	$Publish = M('Publish');
		    	$list = $Publish->where("id = '".$data['publishid']."'")->limit(1)->select();
		    	if(!empty($list)){
		    		$Public = D('Public');
					$uerContent = $Public->userTokenCark($token);
					$data['userid'] = $uerContent['0']['id'];
					$data['addtime'] = time();
					$Reason = M('Reason');
					$Reason->add($data);
					$root = array();
					$root['token'] = (string)$token;
					$root['pid'] = (string)$data['publishid'];
					$root['status'] = (string)$list['0']['status'];
					get_obj_array('10000','举报成功',array($root));
		    	}else{
		    		get_obj_array('20000','举报信息不存在','');
		    	}
		    	
		    }

	}

	//发布需求收藏
	/*
		参数:
			token 
			pid

	*/
	public function collect(){
			$token = I('post.token')?I('post.token'):I('get.token');
		    $pid = I('post.pid')?I('post.pid'):I('get.pid');
		    if(empty($token) || empty($pid)){
		    	get_obj_array('20000','参数不全！','');
		    }else{
		    	$Public = D('Public');
		    	$Collect = M('Collect');
		    	$Publish = M('Publish');
				$uerContent = $Public->userTokenCark($token);
				$userid = $uerContent['0']['id'];
		    	//取消数据校正，获取列表请用内链查询
		    	$pid = explode(',',$pid);
		    	foreach($pid as $key => $value){ //不存在则收藏
		    		$data = array();
		    		$list = $Collect->where("publishid = '$value' and userid = '$userid'")->limit(1)->select();
		    		if(empty($list)){
		    			$Plist = $Publish->where("id = '$value'")->limit(1)->select();
		    			if(!empty($Plist)){
		    				$data['userid'] = $userid;
			    			$data['publishid'] = $value;
			    			$data['addtime'] = time();
			    			$Collect->add($data);
		    			}
		    			$code = "收藏成功";
		    		}else{
		    			$Collect->where("publishid = '$value' and userid = '$userid'")->delete();
		    			$code = "取消成功";
		    		}
		    	}
		    	get_obj_array('10000',$code,$uerContent['0']['token']);
		    }
	}
	//获取收藏列表
	/*
		参数：

			token
			排序 sort 1职位收藏 2辅材信息 3设备承租
			
	*/
	public function collectList(){

			$token = I('post.token')?I('post.token'):I('get.token');
			$sort = I('post.sort')?I('post.sort'):I('get.sort');
			if(empty($token) || empty($sort)){

				get_obj_array('20000','参数不全！','');

			}else{
				
				if($sort == 1){
					$where = " (p.status = 2 or p.status = 3 or p.status = 4)";
				}elseif($sort == 2){
					$where = " p.status = 1";
				}elseif($sort == 3){
					$where = " p.status = 5";
				}else{
					get_obj_array('20000','非法请求！','');
				}
				$Public = D('Public');
				$uerContent = $Public->userTokenCark($token);
				$where .= " and c.userid = '".$uerContent['0']['id']."'";
				$Publish = M();
				$sql = "SELECT p.*,u.id as uid,u.rterrace,u.renzheng FROM zj_publish as p 
						INNER JOIN zj_collect as c
						ON c.publishid = p.id
						INNER JOIN zj_user as u
						ON u.id = p.userid
						WHERE ".$where." group by p.id desc";
				$list = $Publish->query($sql);
				if(!empty($list)){
					$root = array();
					foreach ($list as $key => $value){
						$root[$key]['pid'] = (string)$value['id'];
						$root[$key]['uid'] = (string)$value['uid'];
						$root[$key]['rterrace'] = (string)$value['rterrace'];
						$root[$key]['renzheng'] = (string)$value['renzheng'];
						$root[$key]['title'] = (string)$value['title'];
						$root[$key]['addtime'] = date('Y-m-d',$value['addtime']);
						$root[$key]['pic'] = explode(',',$value['pic']);
						$root[$key]['address'] = (string)$value['address'];
						$root[$key]['content'] = explode("\r\n",$value['content']);
						$root[$key]['username'] = (string)$value['username'];
						$root[$key]['moblie'] = (string)$value['moblie'];
						$root[$key]['status'] = (string)$value['status'];
					}
					get_obj_array('10000','成功！',$root);
				}else{
					get_obj_array('20000','未查询到数据','');
				}
				

			}

	}
	//热门搜素
	public function searchthe(){
		$Searchthe = M('searchthe');
		$list = $Searchthe->where("name !='' ")->field('name')->order('num desc')->limit(20)->select();
		get_obj_array('10000','成功！',$list);
	}
	

}