<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	function __construct(){
			@session_start();
			parent::__construct();
			$this->load->helper('url'); //url加载辅助函数

			$this->load->database(); //数据库类

	}
	public function login(){

		$this->load->view("admin/login.html");
	}
	public function sub(){
		$username = $this->input->post('username',true);
		$password = md5($this->input->post('password',true));
		$sql = "SELECT id,name,text FROM zj_admin where name = '$username' and password = '$password'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			$array=$query->row_array();
			$_SESSION["admin_author"]['admin_id']=$array['id'];
			$_SESSION["admin_author"]['admin_username']=$array['name'];
			$_SESSION["admin_author"]['admin_status']='1';

			$t = json_decode($array['text'],true);

			$_SESSION["num_JSONPOWER_arr"] = $t;
			header("location:".site_url("welcome/index"));
		}else{
			error("账号密码错误！");
		}

	}

	public function logout(){

			unset($_SESSION["admin_author"]['admin_id']);
			unset($_SESSION["admin_author"]['admin_username']);
			unset($_SESSION["admin_author"]['admin_status']);
			unset($_SESSION["num_JSONPOWER_arr"]);
			$_SESSION = array();
			header("location:".site_url("admin/login"));
		}
}
