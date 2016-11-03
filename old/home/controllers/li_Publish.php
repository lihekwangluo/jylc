<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Publish extends Indexinit {
	public function index(){
		//队找人
		$data=array("css"=>1);
		$carft=$this->selectRow("zj_craft",' 1 ',false);
		$data['carft']=$carft;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$sheng=$_POST["diqu"];
		$data['shi']=$this->selectRow("zj_area","area_parent_id='".$sheng."'",false);
		$this->load->view("home/publish/fabu1.html",$data);
	}
	public function index_2(){
		$sheng=empty($_POST["diqu"])?0:@$_POST["diqu"];
		$data=$this->selectRow("zj_area","area_parent_id='".$sheng."'",false);
		echo json_encode($data);
	}
	public function area(){
		$this->load->view("home/publish/fabu1.html",$data);
	}
	public function duimansub(){
		//队找人
		$renshu=$this->input->post('renshu');
		$age1=$this->input->post('age1');
		$age2=$this->input->post('age2');
		$gongzi=$this->input->post('gongzi');
		$price1=explode("-",$gongzi);
		if(empty($price1[1])){
			$price1[1]="0";
		}
		$diqu=$this->input->post('diqu');
		$diqu_shi=$this->input->post('diqu_shi');
		$xiangxi_dizhi=$this->input->post('xiangxi_dizhi');
		$tel=$this->input->post('tel');
		$lianxiren=$this->input->post('lianxiren');
		$yaoqiu=$this->input->post('yaoqiu');
		$gongzhong=$this->input->post('gongzhong');
		//认证可见
		$renzheng=$this->input->post('radio',true);
		if($_SESSION['userid']=="" || !isset($_SESSION['userid']) || $_SESSION['userid']==null){
				exit("<script>alert('请登录'); window.location.href='site_url(Lilogin/login)';</script>");
		}else{
			if($this->input->post("postid")==='1'){
				$array=array(
					'userid'=>$_SESSION['userid'],
					'num'=>$renshu,
					'age1'=>$age1,
					'age2'=>$age2,
					'price'=>$price1[0],
					'price2'=>$price1[1],
					'area1'=>$diqu,
					'area2'=>$diqu_shi,
					'address'=>$xiangxi_dizhi,
					'moblie'=>$tel,
					'username'=>$lianxiren,
					'content'=>$yaoqiu,
					'craftid'=>$gongzhong,
					'power'=>$renzheng,
					'status'=>4,
					//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
					'title'=>$this->autoTitle($diqu,$diqu_shi,4,$renshu,$gongzhong),
				);
				$id=$this->db->insert("zj_publish",$array);
				if($id){
					success('成功',site_url("ActivityMan/index"));
					//header("location:".site_url("Index/index"));
				}else{
					error('失败，请重新发表',site_url("Publish/index"));
				}
			}
		}
	}
	public function index2(){
		$data=array("css"=>1);
		$carft=$this->selectRow("zj_craft",' 1 ',false);
		$data['carft']=$carft;
		$mold=$this->selectRow("zj_mold",' 1 ',false);
		$data['mold']=$mold;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$this->load->view("home/publish/fabu2.html",$data);
	}
	public function fabu2(){
		$area1=$this->input->post("diqu");
		$area2=$this->input->post("diqu_shi");
		$price=$this->input->post("jiage");
		$moldid=$this->input->post("leixin");
		$square=$this->input->post("gongchenliang");
		$address=$this->input->post("xiangxi_dizhi");
		$power=$this->input->post("radio");
		$username=$this->input->post("lianxiren");
		$moblie=$this->input->post("tel");
		$content=$this->input->post("yaoqiu");
		$renshu='0';
		if($_SESSION['userid']=="" || !isset($_SESSION['userid']) || $_SESSION['userid']==null){
				exit("<script>alert('请登录'); window.location.href='site_url(Lilogin/login)';</script>");
		}else{
				if($this->input->post("postid")==='1'){
					$array=array(
						'userid'=>$_SESSION['userid'],
						'area1'=>$area1,
						'area2'=>$area2,
						'price'=>$price,
						'moldid'=>$moldid,
						'square'=>$square,
						'address'=>$address,
						'username'=>$username,
						'moblie'=>$moblie,
						'content'=>$content,
						'craftid'=>$gongzhong,
						'power'=>$power,
						'status'=>2,
						//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
						'title'=>$this->autoTitle($diqu,$diqu_shi,2,$renshu,$gongzhong),
					);
					$id=$this->db->insert("zj_publish",$array);
					if($id){
						success('成功',site_url("ActivityMan/index"));
						//header("location:".site_url("Index/index"));
					}else{
						error('失败，请重新发表',site_url("Publish/index"));
					}
				}
			}
	}
	public function index3(){
		$data=array("css"=>1);
		$carft=$this->selectRow("zj_craft",' 1 ',false);
		$data['carft']=$carft;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$this->load->view("home/publish/fabu3.html",$data);
	}
	public function fabu3(){
		var_dump($_POST);
		die();
		$area1=$this->input->post("diqu");
		$area2=$this->input->post("diqu_shi");;
		$username=$this->input->post("lianxiren");
		$num=$this->input->post("duiwurenshu");
		$power=$this->input->post("radio");
		$moblie=$this->input->post("tel");
		$content=$this->input->post("yaoqiu");
		$renshu='0';
		if($_SESSION['userid']=="" || !isset($_SESSION['userid']) || $_SESSION['userid']==null){
				exit("<script>alert('请登录'); window.location.href='site_url(Lilogin/login)';</script>");
		}else{
				if($this->input->post("postid")==='1'){
					$array=array(
						'userid'=>$_SESSION['userid'],
						'area1'=>$area1,
						'area2'=>$area2,
						'username'=>$username,
						'moblie'=>$moblie,
						'content'=>$content,
						'power'=>$power,
						'status'=>3,
						//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
						'title'=>$this->autoTitle($area1,$area2,3,$renshu,$gongzhong),
					);
					$id=$this->db->insert("zj_publish",$array);
					if($id){
						success('成功',site_url("ActivityMan/index"));
						//header("location:".site_url("Index/index"));
					}else{
						error('失败，请重新发表',site_url("Publish/index"));
					}
				}
			}
	}
	public function index4(){
		$data=array("css"=>1);
		$alcor=$this->selectRow("zj_alcor",' 1 ',false);
		$data['alcor']=$alcor;
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$this->load->view("home/publish/fabu4.html",$data);
	}
	public function fabu4(){
		$area1=$this->input->post("diqu");
		$area2=$this->input->post("diqu_shi");;
		$username=$this->input->post("lianxiren");
		$num=$this->input->post("duiwurenshu");
		$power=$this->input->post("radio");
		$moblie=$this->input->post("tel");
		$content=$this->input->post("yaoqiu");
		$renshu='0';
		if($_SESSION['userid']=="" || !isset($_SESSION['userid']) || $_SESSION['userid']==null){
				exit("<script>alert('请登录'); window.location.href='site_url(Lilogin/login)';</script>");
		}else{
				if($this->input->post("postid")==='1'){
					$array=array(
						'userid'=>$_SESSION['userid'],
						'area1'=>$area1,
						'area2'=>$area2,
						'username'=>$username,
						'moblie'=>$moblie,
						'content'=>$content,
						'power'=>$power,
						'status'=>3,
						//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
						'title'=>$this->autoTitle($area1,$area2,3,$renshu,$gongzhong),
					);
					$id=$this->db->insert("zj_publish",$array);
					if($id){
						success('成功',site_url("ActivityMan/index"));
						//header("location:".site_url("Index/index"));
					}else{
						error('失败，请重新发表',site_url("Publish/index"));
					}
				}
			}
	}
	public function index5(){
		$data=array("css"=>1);
		$data['sheng']=$this->selectRow("zj_area","area_parent_id='0'",false);
		$this->load->view("home/publish/fabu5.html",$data);
	}
		//自动生成标题
	public function autoTitle($area1,$area2,$status,$num,$craftid){
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
			$list=$this->selectRow("zj_area",$where,false);
			$title = $list['0']['area_name'].$list['1']['area_name'];
			//查询工种
			$list=$this->selectRow("zj_craft","id = '$craftid'",false);
			if($status== 4){
				$title .= '招'.$list['0']['name'].$num.'人';
			}elseif($status== 3){
				$title .= '有'.$num.'人'.$list['0']['name'].'队';
			}elseif($status== 2){
				$title .= '招'.$list['0']['name'].'队';
			}elseif($status== 5){
				$alcorid=$this->input->post("alcorid");
				$shopname=$this->input->post("shopname");
				$list=$this->selectRow("zj_alcor","id = '$alcorid'",false);
				$title .= $shopname.$list['0']['name'].'店';
			}elseif($status == 1) {
				$deviceid=$this->input->post("deviceid");
				$list=$this->selectRow("zj_device","id = '$deviceid'",false);
				$title .= '出租'.$list['0']['name'];
			}
		}
		return $title;

	}
}
