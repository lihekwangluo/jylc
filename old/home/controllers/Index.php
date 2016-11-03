<?php
@session_start();
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Index extends Indexinit{
	function __construct(){
			parent::__construct();
			$this->load->helper('url'); //url加载辅助函数
			$this->load->database(); //数据库类
	}
	public function index(){
		$id=$this->input->get("id");
		if(!empty($id)){
			$area_id=$this->db->query("select * from `zj_area` where area_id='".$id."'");
			$area=$area_id->row_array();
			$_SESSION['area_name']=$area['area_name'];
		}
		$data=array("nav"=>1,'areaname'=>$_SESSION['area_name'],'index'=>1);
		$data['lunbo']=$this->lunbo()->result_array();
		$data['huodui1']=$this->newfabu1()->result_array();
		foreach( $data['huodui1'] as $key => $value ){
			$moldname=$this->db->query("select `name` from `zj_mold` where id='".$value['moldid']."'")->row_array();
			$area1=$this->db->query("select * from `zj_area` where area_id='".$value['area1']."'")->row_array();
			$area2=$this->db->query("select * from `zj_area` where area_id='".$value['area2']."'")->row_array();
			$data['huodui1'][$key]['area1']=$area1['area_name'];
			$data['huodui1'][$key]['area2']=$area2['area_name'];
			$data['huodui1'][$key]['moldname']=$moldname['name'];
		}
		$data['huodui2']=$this->newfabu2()->result_array();
		foreach( $data['huodui2'] as $k1 => $v1 ){
			$craftname=$this->db->query("select `name` from `zj_craft` where id='".$v1['craftid']."'")->row_array();
			$area1=$this->db->query("select * from `zj_area` where area_id='".$v1['area1']."'")->row_array();
			$area2=$this->db->query("select * from `zj_area` where area_id='".$v1['area2']."'")->row_array();
			$data['huodui2'][$k1]['area1']=$area1['area_name'];
			$data['huodui2'][$k1]['area2']=$area2['area_name'];
			$data['huodui2'][$k1]['craftid']=$craftname['name'];
		}
		$data['huodui3']=$this->newfabu3()->result_array();
		foreach( $data['huodui3'] as $k2 => $v2 ){
			$craftname=$this->db->query("select `name` from `zj_craft` where id='".$v2['craftid']."'")->row_array();
			$area1=$this->db->query("select * from `zj_area` where area_id='".$v2['area1']."'")->row_array();
			$area2=$this->db->query("select * from `zj_area` where area_id='".$v2['area2']."'")->row_array();
			$data['huodui3'][$k2]['area1']=$area1['area_name'];
			$data['huodui3'][$k2]['area2']=$area2['area_name'];
			$data['huodui3'][$k2]['craftid']=$craftname['name'];
		}
		$data['shebei']=$this->shebei()->result_array();
		foreach( $data['shebei'] as $k4 => $v4 ){
			$devicename=$this->db->query("select `name` from `zj_device` where id='".$v4['deviceid']."'")->row_array();
			$area1=$this->db->query("select * from `zj_area` where area_id='".$v4['area1']."'")->row_array();
			$area2=$this->db->query("select * from `zj_area` where area_id='".$v4['area2']."'")->row_array();
			$data['shebei'][$k4]['area1']=$area1['area_name'];
			$data['shebei'][$k4]['area2']=$area2['area_name'];
			$data['shebei'][$k4]['deviceid']=$devicename['name'];
		}
		$data['shebei2']=$this->shebei2()->result_array();
		foreach( $data['shebei2'] as $k3 => $v3 ){
			$alcorname=$this->db->query("select `name` from `zj_alcor` where id='".$v3['alcorid']."'")->row_array();
			$area1=$this->db->query("select * from `zj_area` where area_id='".$v3['area1']."'")->row_array();
			$area2=$this->db->query("select * from `zj_area` where area_id='".$v3['area2']."'")->row_array();
			$data['shebei2'][$k3]['area1']=$area1['area_name'];
			$data['shebei2'][$k3]['area2']=$area2['area_name'];
			$data['shebei2'][$k3]['alcorid']=$alcorname['name'];
		}
		$data['search']=$this->remen();
		$this->load->view("home/index.html",$data);
	}
	public function lunbo(){
		$lunbos=$this->db->query("select * from `zj_liad`");
		return $lunbos;
	}
	public function chengshi(){
		$area=$this->db->query("select * from `zj_area` where area_name='".$_SESSION['area_name']."'")->row_array();
		return $area;
	}
	public function newfabu1(){
		//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$area_id=$this->chengshi();
		$huodui=$this->db->query("select * from `zj_publish` where status=2 and area1='".$area_id['area_id']."'order by id desc  limit 0,3 ");
		return $huodui;
	}
	public function newfabu2(){
		//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$area_id=$this->chengshi();
		$huodui2=$this->db->query("select * from `zj_publish` where status=3 and area1='".$area_id['area_id']."' order by id desc  limit 0,3 ");
		return $huodui2;
	}
	public function newfabu3(){
		//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$area_id=$this->chengshi();
		$huodui3=$this->db->query("select * from `zj_publish` where status=4 and area1='".$area_id['area_id']."' order by id desc  limit 0,3");
		return $huodui3;
	}
	public function shebei(){
		//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$area_id=$this->chengshi();
		$shebei=$this->db->query("select * from `zj_publish` where status=1 and area1='".$area_id['area_id']."' order by id desc  limit 0,3");
		return $shebei;
	}
	public function shebei2(){
		//分类 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$area_id=$this->chengshi();
		$fucai=$this->db->query("select * from `zj_publish` where status=5 and area1='".$area_id['area_id']."'order by id desc  limit 0,3 ");
		return $fucai;
	}
	public function indexsearch(){
		//var_dump($_GET);
		//die();
		$this->load->model('Public_model','Public');
		$segment=$this->uri->segment(3);
		$name=$_GET['name'];

		$other="";
		if($_GET['times']=="yes"){
			$other.=' order by addtime desc';
		}
		$area1=$this->selectRow("zj_area","area_name='".$_SESSION['area_name']."'");
		unset($_SESSION['area_name']);
		if(empty($name)){
		//	$where=" `title` like '%".$_POST['search']."%' ";
			$url.="name=".$_GET['name'];
			$where="area1='".$area1['area_id']."' and `title` like '%".$_GET['name']."%' ";
			$data['z']='1';
		}else{
			$url.="name=".urldecode($name);
			//$where=" `title` like '%".urldecode($name)."%' ";
			$where="area1='".$area1['area_id']."' and `title` like '%".urldecode($name)."%' ";
			$data['zh']=urldecode($name);
		}
	//	$where="area1='".$area1['area_id']."' and `title` like '%".$_POST['search']."%' ";
		$Sql="select * from `zj_publish` where ".$where.$other;
		$pagesize=10;
		$limit=$this->Public->pageList($Sql,$this->uri->segment(3));
		$data['list']=$limit['query']->result_array();
		$data['pagecount']=$limit['pagecount'];
		$data["pageindex"]=$limit['pageindex'];
		$data["pageall"]=$limit['pageall'];
		$data["arr"]=$limit['arr'];
		//$Sql="select * from `zj_publish` where ".$where.$other;
		//$pagesize=10;
		//$limit=$this->Public->pageList($Sql,$this->uri->segment(3));
		//$data['list']=$limit['query']->result_array();
		//$data['list']=$this->selectRow("zj_publish",$where.$other,false);
		foreach( $data['list'] as $k_s => $v_s ){
			$alcor=$this->selectRow("zj_alcor","id='".$v_s['alcorid']."'");
			$data['list'][$k_s]['alcorid']=$alcor['name'];
			$craft=$this->selectRow("zj_craft","id='".$v_s['craftid']."'");
			$data['list'][$k_s]['craftid']=$craft['name'];
			$device=$this->selectRow("zj_device","id='".$v_s['deviceid']."'");
			$data['list'][$key]['deviceid']=$device['name'];
		}
		$data['searchs']=$_GET['name'];
		$data['search']=$this->remen();
		$data['xiangsi']=$this->xiangsi();
		$this->load->view("home/sousuo.html",$data);
	}
	//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
	public function indexsearch2(){
		$url="";
		$this->load->model('Public_model','Public');
		$segment=$this->uri->segment(3);
		$name=$_GET['name'];

		$other="";
		if($_GET['times']=="yes"){
			$other.=' order by addtime desc';
		}
		if(empty($name)){
			$url.="name=".$_GET['name'];
			$where=" `title` like '%".$_GET['name']."%' ";
			$data['z']='1';
		}else{
			$url.="name=".urldecode($name);
			$where=" `title` like '%".urldecode($name)."%' ";
			$data['zh']=urldecode($name);
		}
		$sql="select * from `zj_publish` where ".$where;
		$addtime=$this->db->query($sql);
		$data['num1']=$addtime->num_rows;
		//$data['list']=$this->selectRow("zj_publish",$where.$other,false);
		$Sql="select * from `zj_publish` where ".$where.$other;
		$pagesize=10;
		$limit=$this->Public->pageList($Sql,$this->uri->segment(3));
		$data['list']=$limit['query']->result_array();
		$data['pagecount']=$limit['pagecount'];
		$data["pageindex"]=$limit['pageindex'];
		$data["pageall"]=$limit['pageall'];
		$data["arr"]=$limit['arr'];
		foreach( $data['list'] as $k_s => $v_s ){
			$alcor=$this->selectRow("zj_alcor","id='".$v_s['alcorid']."'");
			$data['list'][$k_s]['alcorid']=$alcor['name'];
			$craft=$this->selectRow("zj_craft","id='".$v_s['craftid']."'");
			$data['list'][$k_s]['craftid']=$craft['name'];
			$device=$this->selectRow("zj_device","id='".$v_s['deviceid']."'");
			$data['list'][$key]['deviceid']=$device['name'];
		}
		$data['searchs']=$_GET['name'];
		$data['get'] = $url;
		$data['url'] = "Index/indexsearch2";
		$data['search']=$this->remen();
		$data['xiangsi']=$this->xiangsi();

		$this->load->view("home/sousuo.html",$data);
	}
		//相似岗位
	public function xiangsi(){
		$xiangsi=$this->selectRow("zj_publish","status=2 limit 10,3",false);
		foreach( $xiangsi as $key => $value ){
			# code...
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
		}
		return $xiangsi;
	}
	//public function zhao(){
	//		header("Content-Type: text/html; charset=utf-8");
	//		$name=$this->uri->segment(3);
	//		echo urldecode($name);
	//		//var_dump($name);
	//		//	var_dump($_GET);
	//}
}
