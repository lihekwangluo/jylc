<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Gongyouquan extends Indexinit {
	public function index(){
		$segment=$this->uri->segment(3);
		//$zinvlist=$this->selectRow("zj_workmate","status=3 and userid=0 order by id desc",false);
		//$Sql=$this->db->page($Sql,$pagesize,$pagecount,$pageindex,$pageall,$segment);
		//$zinvlist=$this->db->query($Sql);
		//$data["limit"]=$zinvlist->result_array();
		//$data["pagecount"]=$pagecount;
		//$data["pageindex"]=$pageindex;
		//$data["pageall"]=$pageall;
		$this->load->model('Public_model','Public'); //公用model
		$Sql="select * from `zj_workmate` where status=1 and userid=0 order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data["limit"]=$data['query']->result_array();
		$data['xiangsi']=$this->xiangsi();
		$data['search']=$this->remen();
		$data["nav"]=7;
		$this->load->view("home/nav/gongyouquan.html",$data);
	}
	public function zinv(){
		$segment=$this->uri->segment(3);
		$this->load->model('Public_model','Public'); //公用model
		$Sql="select * from `zj_workmate` where status=2 and userid=0 order by id desc";
		$data = $this->Public->pageList($Sql,$segment);
		$data["limit"]=$data['query']->result_array();
		$data['xiangsi']=$this->xiangsis();
		$data['search']=$this->remen();
		$data["nav"]=8;
		$this->load->view("home/nav/gongyouquan.html",$data);
	}
	public function contents(){
		$id=$this->uri->segment(3);
		$row=$this->selectRow("zj_workmate","id='".$id."'");
		$pic=explode(",",$row['pic']);
		$row['pics']=$pic;
		$row['search']=$this->remen();
		$this->load->view("home/nav/gongyongquan.html",$row);
	}
		//相似岗位
	public function xiangsi(){
		// 1是设备出租，2是活找队，3是队找活，4是队找人,5辅材
		$xiangsi=$this->selectRow("zj_publish","status=2 limit 0,3",false);
		foreach( $xiangsi as $key => $value ){
			# code...
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
		}
		return $xiangsi;
	}
		//相似岗位
	public function xiangsis(){
		$xiangsi=$this->selectRow("zj_publish","status=2 limit 3,3",false);
		foreach( $xiangsi as $key => $value ){
			$area1=$this->selectRow("zj_area","area_id='".$value['area1']."'");
			$xiangsi[$key]['area1']=$area1['area_name'];
			$area2=$this->selectRow("zj_area","area_id='".$value['area2']."'");
			$xiangsi[$key]['area2']=$area2['area_name'];
		}
		return $xiangsi;
	}
	//热门搜索
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
