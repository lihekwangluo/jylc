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
		$this->load->model('Public_model','Public'); //����model
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
		$this->load->model('Public_model','Public'); //����model
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
		//���Ƹ�λ
	public function xiangsi(){
		// 1���豸���⣬2�ǻ��Ҷӣ�3�Ƕ��һ4�Ƕ�����,5����
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
		//���Ƹ�λ
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
	//��������
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
