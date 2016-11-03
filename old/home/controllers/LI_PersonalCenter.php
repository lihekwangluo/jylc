<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "Indexinit.php";
class PersonalCenter extends Indexinit {
	public function index(){
		$data=array("leftcss"=>1);
		$this->load->view("home/personal/geren1.html",$data);
	}
	public function datas(){
		$data=array("leftcss"=>2);
		$this->load->view("home/personal/geren2.html",$data);
	}
	public function integral(){
		$data=array("leftcss"=>3);
		$this->load->view("home/personal/geren3.html",$data);
	}
	public function coll(){
		$data=array("leftcss"=>4);
		$this->load->view("home/personal/geren4.html",$data);
	}
	public function invitation(){
		$data=array("leftcss"=>5);
		$this->load->view("home/personal/geren5.html",$data);
	}
	public function certification(){
		$data=array("leftcss"=>6);
		$this->load->view("home/personal/geren6.html",$data);
	}
	public function updatetel(){
		$data=array("leftcss"=>7);
		$this->load->view("home/personal/geren7.html",$data);
	}
	public function updatepassword(){
		$data=array("leftcss"=>8);
		$this->load->view("home/personal/geren8.html",$data);
	}
	public function updatepasswordsub(){
		$mobile=$this->input->post("sjh");
		//登录密码
		$pass=$this->input->post("dl_mima");
		$newpass=$this->input->post("mima");
		$newpass2=$this->input->post("mima2");
		$yanzheng=$this->selectRow("zj_user","mobile='".$mobile."' and pss='".$pass."'");
		if($yanzheng){
			if($newpass===$newpass2){
				$array=array(
					'pass'=>$newpass,
				);
				$password=$this->db->update("zj_user",$array,"mobile='".$mobile."'");
				if($password){

				}else{

				}
			}
		}else{
			//exit("<script>alert('密码输入的不一致');windon.</script>");
		}
	}
	public function opinion(){
		$data=array("leftcss"=>9);
		$this->load->view("home/personal/geren9.html",$data);
	}
	public function opinionsub(){
		$name=$this->input->post("name");
		$tell=$this->input->post("tell");
		$yijian=$this->input->post("yijian");
		if($this->input->post("sub")==="1"){
			$array=array(
				'userid'=>$_SESSION['userid'],
				'name'=>$name,
				'mobile'=>$tell,
				'content'=>$yijian,
				'addtime'=>time()
			);
			$feek=$this->db->insert("zj_feedback",$array);
			if($feek){

			}else{

			}
		}
	}
	public function me(){
		$data=array("leftcss"=>10);
		$data['me']=$this->selectRow("zj_aboutus","typeaboutus=1");
		$this->load->view("home/personal/geren10.html",$data);
	}
	public function outlogin(){
	}
}
