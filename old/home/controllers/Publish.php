<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Publish extends Indexinit {
	public function index(){
		//队找人
		$data = $this->publishAdd();
		$data['css'] = 1;
		$data['carft']=$this->selectRow("zj_craft",' 1 order by weights,id ',false);
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$sheng=$_POST["diqu"];
		$data['shi']=$this->selectRow("zj_area","area_parent_id='".$sheng."'",false);
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu1.html",$data);
	}
	public function index_2(){
		$sheng=empty($_POST["diqu"])?0:@$_POST["diqu"];
		$data=$this->selectRow("zj_area","area_parent_id='".$sheng."'",false);
		echo json_encode($data);
	}
	public function area(){
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu1.html",$data);
	}
	public function duimansub(){
		$this->cklogin();
		$_POST['status'] = 4;
		$_POST['userid'] = $_SESSION['uid'];
		$this->publishPost();
	}

	public function index2(){
		$data = $this->publishAdd();
		$data['css'] = 1;
		$data['carft']=$this->selectRow("zj_craft",' 1 order by weights,id ',false);
		$data['mold']=$this->selectRow("zj_mold",' 1 ',false);
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu2.html",$data);
	}

	public function fabu2(){
		$this->cklogin();
		$_POST['status'] = 2;
		$_POST['userid'] = $_SESSION['uid'];
		$this->publishPost();
	}
	public function index3(){
		$data = $this->publishAdd();
		$data['css'] = 1;
		$carft=$this->selectRow("zj_craft",' 1 order by weights,id ',false);
		$data['carft']=$carft;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu3.html",$data);
	}
	public function fabu3(){
		$this->cklogin();
		$_POST['status'] = 3;
		$_POST['userid'] = $_SESSION['uid'];
		$this->publishPost();
	}

	public function index4(){
		$data = $this->publishAdd();
		$data['css'] = 1;
		$alcor=$this->selectRow("zj_alcor",' 1 ',false);
		$data['alcor']=$alcor;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu4.html",$data);
	}

	public function fabu4(){
		$this->cklogin();
		$_POST['status'] = 5;
		$_POST['userid'] = $_SESSION['uid'];
		$this->publishPost();
	}

	public function index5(){
		$data = $this->publishAdd();
		$data['css'] = 1;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$data['device'] = $this->db->query("select id,name from zj_device")->result_array();
		$data['search']=$this->remen();
		$this->load->view("home/publish/fabu5.html",$data);
	}

	public function fabu5(){
		$this->cklogin();
		$_POST['status'] = 1;
		$_POST['userid'] = $_SESSION['uid'];
		$this->publishPost();
	}

	public function del(){
		$this->cklogin();
		$publishid = $this->uri->segment(3);;
		 if(empty($publishid)){
		 	error(" 非法请求！");
			exit;
		 }else{
		 	$this->load->model('Public_model','Public');
		 	$img = array('pic','terracepic');
		 	//删除主表
			$this->Public->delImgAll('zj_publish',"id = '$publishid'",$img);
			//删除工种关联表
		 	$this->Public->delImgAll('zj_publishalcor',"publishid = '$publishid'",'');
		 	//删除服务范围
		 	$this->Public->delImgAll('zj_publishcraft',"publishid = '$publishid'",'');
		 	//删除设备表
		 	$this->Public->delImgAll('zj_publishdevice',"publishid = '$publishid'",'');
		 	//删除项目类型
		 	$this->Public->delImgAll('zj_publishmold',"publishid = '$publishid'",'');
		 	//删除收藏
		 	$this->Public->delImgAll('zj_collect',"publishid = '$publishid'",'');
		 	success("操作成功！",site_url("/personalcenter/index"),1);

		 }
	}

	public function publishAdd(){

		$id=$this->uri->segment(3);
		$data = array();
		if($id){
			$sql = "SELECT p.*,p.shopname as owner,u.id as userid,u.rterrace,u.name as yname,u.type as stype,u.rterrace FROM zj_publish as p
					INNER JOIN zj_user as u
					ON p.userid = u.id
					WHERE p.id = '$id' limit 1";
			$query = $this->db->query($sql);
			$data = $query->row_array();

		}
		if($data['craftid']){
			$list = $this->db->query("select * from zj_craft where id in(".$data['craftid'].")")->result_array();
			foreach($list as $key => $value) {
				$str .= $value['name']."  ";
			}
			$data['craft_name'] = $str;
		}
		if($data['pic']){
			$data['pics'] = explode(",",$data['pic']);
		}
		if($data['terracepic']){
			$data['terracepics'] = explode(",",$data['terracepic']);
		}

		// if($data['status']==1) $data['str'] = $this->cateDisposeList('1',$data['craftid']);
		// else if($data['status']==2) $data['str'] = $this->cateDisposeList('2',$data['deviceid']);
		// else if($data['status']==3) $data['str'] = $this->cateDisposeList('3',$data['moldid']);
		// else if($data['status']==4) $data['str'] = $this->cateDisposeList('4',$data['alcorid']);
		//$this->load->model('Demand_model','Demand'); //公用model
		//查询模板
		//$data['htmlRentOut'] = $this->Demand->mRentOut($data);
		//$data['htmlWorkTeam'] = $this->Demand->mWorkTeam($data);
		//$data['htmlTeamWork'] = $this->Demand->mTeamWork($data);
		//$data['htmlTeamPerson'] = $this->Demand->mTeamPerson($data);
		//$data['htmlAlcorAdd'] = $this->Demand->mAlcorAdd($data);

		//查询设备
		//$data['device'] = $this->Public->selectDevice();
		//查询工种
		//$data['craft'] = $this->Public->selectCraft();
		//项目类型
		//$data['mold'] = $this->Public->selectMold();
		//服务范围
		//$data['alcor'] = $this->Public->selectAlcor();

		//$data['area_1'] = $this->Public->selectAddress();
		//地址
		//if(!empty($data['area1'])){

		// 	$area = $this->Public->is_sql_name('zj_area',"area_id = '".$data['area1']."'");
		// 	$data['area1_c'] = $area['area_name'];
		// 	if(!empty($data['area2'])){
		// 		$area = $this->Public->is_sql_name('zj_area',"area_id = '".$data['area2']."'");
		// 		$data['area2_c'] = $area['area_name'];
		// 	}

		// }
		return $data;

	}

	// public function cateDisposeList($t,$cateid){
	// 	if($t == '1'){
	// 		$t = "zj_craft";
	// 	}elseif($t == '2'){
	// 		$t = "zj_device";
	// 	}elseif($t == '3'){
	// 		$t = "zj_mold";
	// 	}elseif($t == '4'){
	// 		$t = "zj_alcor";
	// 	}

	// 	//查询
	// 	$str = '';
	// 	$list = $this->db->query("select * from '$t' id in($cateid)")->result_array();
	// 	$data = array('0'=>array('cid'=>'0','name'=>''));
	// 	foreach($list as $key => $value) {
	// 		//$data[$key]['cid'] = $value['id'];
	// 		$str .= $value['name']."  ";
	// 		//$data[$key]['name'] = $value['name'];
	// 	}
	// 	return $str;
	// }

	protected function publishPost(){
		$this->load->model('Public_model','Public');
		$data = array();
		$status = $this->input->post('status',true);
		$craftid =  trim($this->input->post('craftid',true),',');//工种
		$deviceid = trim($this->input->post('deviceid',true),',');//设备
		$moldid = trim($this->input->post('moldid',true),',');//项目类型
		$alcorid = trim($this->input->post('alcorid',true),',');//商店分类
		$id = $this->input->post('id',true);//发布需求id
		$zhuangtai = 1;
		$type = $this->input->post('ptype',true);

		//用户id
		$userid = $this->input->post('userid',true);

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
			error(" 非法请求！");//,site_url("/Demand/publishList"),3
			return;
		}
		$address = $this->input->post('address',true);//详细地址
		if(!empty($address)){
			$data['address'] = $address;
		}
		$area1 = $this->input->post('area1',true);//城市一级
		if(!empty($area1)){
			$data['area1'] = $area1;
			$area2 = $this->input->post('area2',true);//城市二级
			if(!empty($area2)){
				$data['area2'] = $area2;
				$area3 = $this->input->post('area3',true);//城市三级
				if(!empty($area3)){
					$data['area3'] = $area3;
				}
			}
		}


		$username = $this->input->post('name',true);//联系人
		if(!empty($username)){
			$data['username'] = $username;
		}
		$moblie = $this->input->post('moblie',true);//联系电话
		if(!empty($moblie)){
			$data['moblie'] = $moblie;
		}
		$power = $this->input->post('power',true);//权限
		if(!empty($power)){
			$data['power'] = $power;
		}
		$content = $this->input->post('content',true);//详细要求
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
		if(empty($data['address']) || empty($data['username']) || empty($data['moblie']) || empty($data['power']) || empty($userid)){

			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			return;

		}else{


			//图片
			if(!empty($_FILES)){
				$pic = '';
				for($i=0;$i<=9;$i++) {
					$pic .= $this->Public->fileImg($_FILES['pic'.$i],$_POST['pics'.$i]).',';
				}
				if(!empty($imgArr['terracepic1'])){
					for($i=1;$i<=3;$i++) {
						$terracepic .= $this->Public->fileImg($_FILES['terracepic'.$i],$_POST['terracepic'.$i]).',';
					}

				}


				$data['pic'] = trim($pic,',');
				$data['terracepic'] = trim($terracepic,',');

			}

			$data['title'] = $this->autoTitle();
			$data['zhuangtai'] = $zhuangtai;
			$data['type'] = $type;
			if(empty($id)){
				$data['userid'] = $userid;
				$data['addtime'] = time();
				$this->db->insert('zj_publish',$data);
				$publishid = $this->db->insert_id();
			}else{
				$this->db->update('zj_publish',$data,"id='".$id."'");
				$publishid = $id;
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

			success("操作成功！",site_url("ActivityMan/index"));//,site_url("/Demand/publishList"),1
		}
	}

	//设备出租
	public function rentOut(){

		$deviceid = trim($this->input->post('deviceid',true),',');//设备id
		$num = $this->input->post('num',true);//数量
		$model = $this->input->post('model',true);//型号
		$driver = intval($this->input->post('driver',true));//司机
        $shopname = $this->input->post('owner',true);//设备出租时的业主名
		if(empty($deviceid) || empty($num) || empty($model)){

			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			exit;

		}else{
            $data['shopname'] = $shopname;
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

		$price = $this->input->post('price',true); //价格
		$num = intval($this->input->post('num',true));//队伍人数
		$square = $this->input->post('square',true); //工程量
		if(empty($price)){
			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			exit;
		}else{
			$data['price'] = $price*10000;
			$data['num'] = $num;
			$data['square'] = $square;
			$data['status'] = 2;
			return $data;
		}
	}
	//队找活
	public function teamWork(){

		$num = intval($this->input->post('num',true));//队伍人数
		if(empty($num)){
			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			exit;
		}else{
			$data['num'] = $num;
			$data['status'] = 3;
			return $data;
		}

	}
	//队找人
	public function teamPerson(){

		$num = intval($this->input->post('num',true));//队伍人数
		$age1 = intval($this->input->post('age1',true));//年龄开始
		$age2 = intval($this->input->post('age2',true));//年龄结束
		$price = $this->input->post('price',true);//价格
		$price = explode('-',$price);
		$price1 = intval($price['0']);
		$price2 = intval($price['1']);
		if($price1==0){
			if($price2 !=0){
				$price1 = $price2;
			}else{
				$price1 = $price2;
			}
		}
		if(empty($num) || empty($age1) || empty($age2)){
			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			exit;
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
	public function alcorAdd($userid){

		$shopname = $this->input->post('shopname',true);//店铺名称
		if(empty($shopname)){
			error(" 参数不全！");//,site_url("/Demand/publishList"),3
			exit;
		}else{
			$data['shopname'] = $shopname;
			$data['status'] = 5;
			//判断是否上传了认证
			$datauser = array();
			//查询用户
			$arr = $this->Public->is_sql_name('zj_user',"id='$id' limit 1");
			$rterrace = $arr['rterrace'];

			// 图片上传

			if($rterrace == 0){

				if(!empty($_FILES)){ //判断是否有图片

					for($i=1;$i<=3;$i++) {
						$terracepic = $this->Public->fileImg($_FILES['terracepic'.$i],$_POST['terracepics'.$i]).',';
					}
					$datauser['terracepic'] = trim($terracepic,',');
					$datauser['rterrace'] = 2;
					$this->db->update('zj_user',$datauser,"id='".$arr['id']."'");

				}
			}
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
			$t = "zj_publishcraft";
		}elseif($t == '2'){
			$t = "zj_publishdevice";
		}elseif($t == '3'){
			$t = "zj_publishmold";
		}elseif($t == '4'){
			$t = "zj_publishalcor";
		}

		$cateid = explode(',',trim($cateid,','));

		//删除这个分类
		$this->db->delete($t,"publishid='$publishid'");
		foreach($cateid as $key => $value) {
			$data = array();
			$data['userid'] = $userid;
			$data['cateid'] = $value;
			$data['publishid'] = $publishid;
			$this->db->insert($t,$data);
		}
	}


	public function autoTitle(){

		$area1 = $this->input->post('area1',true);//城市一级
		$area2 = $this->input->post('area2',true);//城市二级
		$area3 = $this->input->post('area3',true);//城市二级
        $owner = $this->input->post('owner',true);//设备出租时的业主名
		$status = intval($this->input->post('status',true));
		$num = intval($this->input->post('num',true));
		$craftid = $this->input->post('craftid',true);
		$craftid = explode(',',trim($craftid,','));
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
			$list = $this->db->query("select * from zj_area where ".$where)->result_array();
			foreach ($list as $key => $v) {
				$title .= $v['area_name'];
			}

			//查询工种
			$list = $this->Public->is_sql_name("zj_craft","id = '$craftid'");
			if(implode(',',$craftids)){
				$craft_list = $this->Public->is_sql_exec("zj_craft","id in (".implode(',',$craftids).")");
			}else{
				$craft_list = '';
			}
            $crafts = array();
            foreach($craft_list as $value){
                $crafts[] = $value['name'];
            }
			if($status== 4){
				$title .= '招'.implode(',',$crafts).$num.'人';
			}elseif($status== 3){
				$title .= '有'.$num.'人'.implode(',',$crafts).'队';
			}elseif($status== 2){
				$title .= '招'.implode(',',$crafts).'队';
			}elseif($status== 5){
				$alcorid = $this->input->post('alcorid',true);
				$shopname = $this->input->post('shopname',true);
				$alcorid = explode(',',trim($alcorid,','));
				$list =  $this->Public->is_sql_name("zj_alcor","id = '$alcorid'");
				$title .= $shopname.$list['name'].'店';
			}elseif($status == 1) {
				$deviceid = $this->input->post('deviceid',true);
				$deviceid = explode(',',trim($deviceid,','));
				$deviceid = $deviceid['0'];
				$list =  $this->Public->is_sql_name("zj_device","id = '$deviceid'");
				$title .= $owner.'出租'.$list['name'];

			}
		}
		return $title;

	}
			//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
