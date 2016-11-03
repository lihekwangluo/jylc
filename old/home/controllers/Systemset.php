<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class Systemset extends Indexinit {
	public function aboutus(){
		$row=array();
		$query = $this->db->query("select * from `zj_aboutus` where typeaboutus=2 limit 0,1");
		$row=$query->row_array();
		$row['search']=$this->remen();
		$this->load->view("home/footer/aboutus.html",$row);
	}
	public function tell(){
		$query = $this->db->query("select * from `zj_aboutus` where typeaboutus=1 limit 0,1");
		$row=$query->row_array();
		$row['search']=$this->remen();
		$this->load->view("home/footer/tell.html",$row);
	}
	public function law(){
		$data=$this->selectRow("zj_aboutus",'typeaboutus=3');
		$data['search']=$this->remen();
		$this->load->view("home/footer/law.html",$data);
	}
	public function service(){
		$data=$this->selectRow("zj_aboutus",'typeaboutus=4');
		$data['a']='1';
		$data['search']=$this->remen();
		$this->load->view("home/footer/law.html",$data);
	}
	public function enterprise(){
		$this->load->view("home/footer/enterprise.html",$data);
	}
		//ÈÈÃÅËÑË÷
	public function remen(){
		$remenlist=$this->selectRow("zj_searchthe"," 1 order by num desc limit 0,8",false);
		return $remenlist;
	}
}
